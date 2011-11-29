PHP Referred Curl
*****************

This library allows to manage multiple concurrents cURL handles.
It requires 5.3 and cURL extension to be installed.

An example::

    <?php

    $r1 = new Curl\Request('http://www.google.com');
    $r2 = new Curl\Request('http://www.yahoo.fr');
    $r3 = new Curl\Request('http://www.facebook.com');
    $r4 = new Curl\Request('http://soundcloud.com/');

    $r5 = curl_init('http://msn.fr');

    $jobdaemon = new Curl\JobDaemon;

    $callback = function($error, $response) use ($jobdaemon, $r5) {
        if ($error) {
            echo 'Oups, error!' . PHP_EOL;
            throw $error;
        }
        else {
            echo 'We got a response' . PHP_EOL;
            var_dump(Curl\Info::get($response->getHandle()));
        }
    };

    $jobdaemon
        // defer 1rst
        ->defer($r1, $callback)
        // defer 2nd
        ->defer($r2, $callback)
        // defer 3rd
        ->defer($r3, $callback)
        // have we some defered requests already resolved?
        ->resolve()
        // defer 4th
        ->defer($r4, $callback)
        // We need $r4 now!
        ->waitFor($r4)
        // Required all pending curls to be finished
        ->join();
