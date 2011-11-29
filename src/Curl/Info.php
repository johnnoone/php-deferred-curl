<?php

namespace Curl;

use Curl\Exceptions\InvalidArgumentException;

/**
 * Simple Wrapper around cURL informations
 */
class Info
{
    const EFFECTIVE_URL = CURLINFO_EFFECTIVE_URL;
    const HTTP_CODE = CURLINFO_HTTP_CODE;
    const FILETIME = CURLINFO_FILETIME;
    const TOTAL_TIME = CURLINFO_TOTAL_TIME;
    const NAMELOOKUP_TIME = CURLINFO_NAMELOOKUP_TIME;
    const CONNECT_TIME = CURLINFO_CONNECT_TIME;
    const PRETRANSFER_TIME = CURLINFO_PRETRANSFER_TIME;
    const STARTTRANSFER_TIME = CURLINFO_STARTTRANSFER_TIME;
    const REDIRECT_TIME = CURLINFO_REDIRECT_TIME;
    const REDIRECT_COUNT = CURLINFO_REDIRECT_COUNT;
    const SIZE_UPLOAD = CURLINFO_SIZE_UPLOAD;
    const SIZE_DOWNLOAD = CURLINFO_SIZE_DOWNLOAD;
    const SPEED_DOWNLOAD = CURLINFO_SPEED_DOWNLOAD;
    const SPEED_UPLOAD = CURLINFO_SPEED_UPLOAD;
    const HEADER_SIZE = CURLINFO_HEADER_SIZE;
    const HEADER_OUT = CURLINFO_HEADER_OUT;
    const REQUEST_SIZE = CURLINFO_REQUEST_SIZE;
    const SSL_VERIFYRESULT = CURLINFO_SSL_VERIFYRESULT;
    const CONTENT_LENGTH_DOWNLOAD = CURLINFO_CONTENT_LENGTH_DOWNLOAD;
    const CONTENT_LENGTH_UPLOAD = CURLINFO_CONTENT_LENGTH_UPLOAD;
    const CONTENT_TYPE = CURLINFO_CONTENT_TYPE;
    const CERTINFO = CURLINFO_CERTINFO;

    protected static $mapping = array(
        self::EFFECTIVE_URL => 'url', // Last effective URL
        self::HTTP_CODE => 'http_code', // Last received HTTP code
        self::FILETIME => 'filetime', // Remote time of the retrieved document, if -1 is returned the time of the document is unknown
        self::TOTAL_TIME => 'total_time', // Total transaction time in seconds for last transfer
        self::NAMELOOKUP_TIME => 'namelookup_time', // Time in seconds until name resolving was complete
        self::CONNECT_TIME => 'connect_time', // Time in seconds it took to establish the connection
        self::PRETRANSFER_TIME => 'pretransfer_time', // Time in seconds from start until just before file transfer begins
        self::STARTTRANSFER_TIME => 'starttransfer_time', // Time in seconds until the first byte is about to be transferred
        self::REDIRECT_TIME => 'redirect_time', // Time in seconds of all redirection steps before final transaction was started
        self::REDIRECT_COUNT => 'redirect_count',
        self::SIZE_UPLOAD => 'size_upload', // Total number of bytes uploaded
        self::SIZE_DOWNLOAD => 'size_download', // Total number of bytes downloaded
        self::SPEED_DOWNLOAD => 'speed_download', // Average download speed
        self::SPEED_UPLOAD => 'speed_upload', // Average upload speed
        self::HEADER_SIZE => 'header_size', // Total size of all headers received
        self::HEADER_OUT => 'request_header', // The request string sent. For this to work, add the CURLINFO_HEADER_OUT option to the handle by calling curl_setopt()
        self::REQUEST_SIZE => 'request_size', // Total size of issued requests, currently only for HTTP requests
        self::SSL_VERIFYRESULT => 'ssl_verify_result', // Result of SSL certification verification requested by setting CURLOPT_SSL_VERIFYPEER
        self::CONTENT_LENGTH_DOWNLOAD => 'download_content_length', // content-length of download, read from Content-Length: field
        self::CONTENT_LENGTH_UPLOAD => 'upload_content_length', // Specified size of upload
        self::CONTENT_TYPE => 'content_type', // Content-Type: of the requested document, NULL indicates server did not send valid Content-Type: header
        self::CERTINFO => 'certinfo'
    );

    public static function validate($option=null)
    {
        if ($option === null) {
            return null;
        }
        elseif (is_string($option)) {
            $opt = array_search($option, self::$mapping);
            if ($opt === false) {
                throw new InvalidArgumentException('Not an option');
            }
            return $opt;
        }
        elseif (is_int($option)) {
            if (false === array_key_exists($option, self::$mapping)) {
                throw new InvalidArgumentException('Not an option');
            }
            return $option;
        }
    }

    public static function get($handler, $option=null)
    {
        if ($option) {
            $option = self::validate($option);
            return curl_getinfo($handler, $option);
        }
        return curl_getinfo($handler);
    }
}
