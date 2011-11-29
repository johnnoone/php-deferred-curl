<?php

namespace Curl;

interface ResponseInterface
{
    public function getHandle();

    public function getRequest();

    public function getHeader();

    public function getBody();
}