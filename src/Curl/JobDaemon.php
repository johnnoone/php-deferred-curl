<?php

namespace Curl;

use Curl\Exceptions\InvalidArgumentException;
use Curl\Exceptions\UnexpectedValueException;
use Curl\Exceptions\LogicException;

class JobDaemon
{
    /**
     * Queue for pending jobs
     *
     * @var array
     */
    protected $waitingJobs;

    /**
     * Queue for pending jobs
     *
     * @var array
     */
    protected $runningJobs;

    /**
     * List of jobs done
     *
     * @var array
     */
    protected $done;

    /**
     * Will keep buffered data into temporary streams
     *
     * @var array
     */
    protected $buffers;

    /**
     * max concurrent downloads allowed
     *
     * @var int
     */
    protected $maxConcurrence;

    /**
     * Multi curl handle
     *
     * @var resources
     */
    protected $mHandle;

    private $execRunning;
    private $execStatus;

    /**
     * @param int $maxConcurrence
     * @throws ErrorException
     */
    public function __construct($maxConcurrence=30)
    {
        if (!extension_loaded('curl')) {
			throw new \ErrorException("cURL library is not loaded. Please recompile PHP with the cURL library.");
        }

        $this->waitingJobs = array();
        $this->runningJobs = array();
        $this->buffers = array();
        $this->done = array();

        $this->maxConcurrence = $maxConcurrence;

		$this->mHandle = curl_multi_init();
    }

    public function __destruct()
    {
        curl_multi_close($this->mHandle);
    }

    /**
     * Defers request
     *
     * @param Request|resource $request
     * @param callable $callback where 1rst argument expects an Exception|null,
     *                           and 2nd argument excepts Response|null.
     * @return this
     */
    public function defer($request, $callback)
    {
        if ($request instanceof RequestInterface) {
            $handle = $request->getHandle();
        }
        else {
            $handle = $request;
            $request = null;
        }

        $key = (string) $handle;

        if (is_callable($callback) == false) {
            throw new InvalidArgumentException('Must be callable');
        }

        $job = array(
		    'request' => $request,
		    'handle' => $handle,
		    'callback' => $callback
		);

        if (count($this->runningJobs) < $this->maxConcurrence) {
            $this->run($job);
		} else {
        	$this->waitingJobs[$key] = $job;
		}

		return $this;
    }

    public function run(array $job) {
        $handle = $job['handle'];
        $key = (string) $handle;

        // move to running jobs
	    $this->runningJobs[$key] = $job;
	    unset($this->waitingJobs[$key]);

        // declare buffers
	    $this->buffers[$key] = array(
	        'headers' => '',
	        'body' => fopen('php://temp', 'r+')
	    );
	    Option::set($handle, array(
	        Option::HEADERFUNCTION => array($this, 'readHeader'),
	        Option::WRITEFUNCTION => array($this, 'readBody'),
	        Option::RETURNTRANSFER => true
	    ));

        // start handling
	    $code = curl_multi_add_handle($this->mHandle, $handle);
        if ($code === CURLM_OK || $code === CURLM_CALL_MULTI_PERFORM) {
            do {
                $this->execStatus = curl_multi_exec($this->mHandle, $this->execRunning);
            } while ($this->execStatus === CURLM_CALL_MULTI_PERFORM);

            return true;
        }

        return false;
    }

    /**
     * Pushes headers data into buffer
     *
     * @param resource $handle
     * @param string $buffer
     * @return int
     */
    public function readHeader($handle, $buffer)
    {
        $key = (string) $handle;
        $this->buffers[$key]['headers'] .= $buffer;

        $this->resolve();
        return strlen($buffer);
    }

    /**
     * Pushes body data into buffer
     *
     * @param resource $handle
     * @param string $buffer
     * @return int
     */
    public function readBody($handle, $buffer)
    {
        $key = (string) $handle;
        fputs($this->buffers[$key]['body'], $buffer);

        $this->resolve();
        return strlen($buffer);
    }

    /**
     * Waits until the resolution of all jobs
     *
     * @return this
     */
    public function join()
    {
        while ($this->execRunning or count($this->waitingJobs)) {
            // unstack waiting jobs
    		while (count($this->waitingJobs) && count($this->runningJobs) < $this->maxConnection) {
    		    $job = array_shift($this->waitingJobs);
    		    $this->run($job);
    		}

            $sleep = false;
            do {
                if ($sleep) {
                    usleep($sleep);
                    $sleep *= 1.1;
                }
                else {
                    $sleep = 1.1;
                }

                $this->execStatus = curl_multi_exec($this->mHandle, $this->execRunning);
            } while ($this->execStatus === CURLM_CALL_MULTI_PERFORM);

            $this->resolve();
        }

		return $this;
    }

    /**
     * Wait for the resolution of this job
     *
     * @param Request|resource $request
     * @return this
     */
    public function waitFor($request)
    {
        if ($request instanceof RequestInterface) {
            $handle = $request->getHandle();
        }
        else {
            $handle = $request;
            $request = null;
        }

        $key = (string) $handle;

        /**
         * Make a more and more sleeping time
         */
        $sleep = function() {
            static $time = 0;
            if ($time) {
                usleep($time);
                $time *= 1.1;
            } else {
                $time = 1;
            }
        };

        while ($this->execRunning or count($this->waitingJobs)) {
            // unstack waiting jobs
    		while (count($this->waitingJobs) && count($this->runningJobs) < $this->maxConnection) {
    		    $job = array_shift($this->waitingJobs);
    		    $this->run($job);
    		}

            do {
                $sleep();

                $this->execStatus = curl_multi_exec($this->mHandle, $this->execRunning);
            } while ($this->execStatus === CURLM_CALL_MULTI_PERFORM);

            $this->resolve();

            if (isset($this->done[$key])) {
                break;
            }
        }

		return $this;
    }

    /**
     * Resolves resolved handles
     */
    public function resolve() {
		while ($mResponse = curl_multi_info_read($this->mHandle)) {
		    $error = $response = null;
			$key = (string) $mResponse['handle'];

            if (empty($this->runningJobs[$key])) {
    			throw new LogicException('There is no running job for handle ' . $key);
    		}
		    elseif ($mResponse['result'] !== CURLE_OK) {
		        // something bad append
		        $error = new UnexpectedValueException(
		            curl_error($mResponse['handle']), $mResponse['result']);
		    }
    		elseif (empty($this->buffers[$key])) {
    			$error = new LogicException('There is no buffer for handle ' . $key);
			}
			else {
                $this->done[$key] = true;

                $job = $this->runningJobs[$key];
                unset($this->runningJobs[$key]);

    			$header = $this->buffers[$key]['headers'];
    			$body = $this->buffers[$key]['body'];
                unset($this->buffers[$key]);

    			curl_multi_remove_handle($this->mHandle, $mResponse['handle']);
                $response = new Response($job['handle'], $job['request'], $header, $body);
            }

            $callback = $job['callback'];
            $callback($error, $response);
		}

		return $this;
    }

    /**
     * Clears this $request
     *
     * @param Request|resource $request
     * @return this
     */
    public function clear($request)
    {
        if ($request instanceof RequestInterface) {
            $handle = $request->getHandle();
        }
        else {
            $handle = $request;
            $request = null;
        }

		curl_multi_remove_handle($this->mHandle, $handle);

        $key = (string) $handle;
        unset($this->waitingJobs[$key]);
        unset($this->runningJobs[$key]);
        unset($this->buffers[$key]);
        unset($this->done[$key]);

		return $this;
    }
}
