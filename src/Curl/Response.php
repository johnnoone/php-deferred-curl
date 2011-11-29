<?php

namespace Curl;

class Response implements ResponseInterface
{
    public function __construct($handle, $request=null, $header, $body)
    {
        $this->handle = $handle;
        $this->request = $request;
        $this->header = $header;
        $this->body = $body;
    }

    public function getHandle()
    {
        return $this->handle;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getBody()
    {
        return $this->body;
    }
}
