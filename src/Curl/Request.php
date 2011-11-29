<?php

namespace Curl;

use Info;
use Option;

/**
 * Simple Wrapper around cURL handle
 */
class Request implements RequestInterface
{
    protected $url;
    protected $handle;

    public function __construct($url=null, array $options=null)
    {
        $this->url = $url;
        $this->handle = curl_init($url);
        if (!$this->handle) {
            throw new \Exception('Instantiation exception');
        }

        if ($options) {
            self::setOption($options);
        }
    }

    public function __destruct() {
        $this->close();
    }

    /**
     * Closes handle.
     *
     * @return this
     */
    public function close()
    {
        curl_close($this->handle);
        return $this;
    }

    /**
     * Returns a new cURL handle.
     *
     * @return Request
     */
    public function __clone()
    {
        $this->handle = curl_copy_handle($this->handle);
    }

    /**
     * Returns the error number or 0 (zero) if no error occurred.
     *
     * @see http://curl.haxx.se/libcurl/c/libcurl-errors.html
     * @return int
     */
    public function getErrno()
    {
        return curl_errno($this->handle);
    }

    /**
     * Returns the error message or '' (the empty string) if no error occurred.
     *
     * @return string
     */
    public function getError()
    {
        return curl_error($this->handle);
    }

    /**
     * Returns TRUE on success or FALSE on failure. However, if the CURLOPT_RETURNTRANSFER option is set, it will return the result on success, FALSE on failure.
     *
     * @param bool $return
     * @return bool|string
     */
    public function exec($return=false) {
        if ($return) {
            curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        }
        return curl_exec($this->handle);
    }

    /**
     * If opt is given, returns its value as a string. Otherwise, returns an associative array with the following elements (which correspond to opt), or FALSE on failure:
     *
     * @param int|null $option
     * @return string|array
     */
    public function getInfo($option=null)
    {
        return Info::get($this->handle, $option);
    }

    /**
     * @param string|array $option
     * @param mixed|null $value
     * @return this
     */
    public function setOption($option, $value=null)
    {
        Option::set($this->handle, $option, $value);
        return $this;
    }

    /**
     * @return handle
     */
    public function getHandle()
    {
        return $this->handle;
    }

}
