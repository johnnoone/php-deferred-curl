<?php

namespace Curl;

use Curl\Exceptions\InvalidArgumentException;

/**
 * Simple Wrapper around cURL options
 */
class Option
{
    /**
     * Required bool
     */

    const AUTOREFERER = CURLOPT_AUTOREFERER;
    const BINARYTRANSFER = CURLOPT_BINARYTRANSFER;
    const COOKIESESSION = CURLOPT_COOKIESESSION;
    const CERTINFO = CURLOPT_CERTINFO;
    const CRLF = CURLOPT_CRLF;
    const DNS_USE_GLOBAL_CACHE = CURLOPT_DNS_USE_GLOBAL_CACHE;
    const FAILONERROR = CURLOPT_FAILONERROR;
    const FILETIME = CURLOPT_FILETIME;
    const FOLLOWLOCATION = CURLOPT_FOLLOWLOCATION;
    const FORBID_REUSE = CURLOPT_FORBID_REUSE;
    const FRESH_CONNECT = CURLOPT_FRESH_CONNECT;
    const FTP_USE_EPRT = CURLOPT_FTP_USE_EPRT;
    const FTP_USE_EPSV = CURLOPT_FTP_USE_EPSV;
    const FTPAPPEND = CURLOPT_FTPAPPEND;
    // const FTPASCII = CURLOPT_FTPASCII;
    const FTPLISTONLY = CURLOPT_FTPLISTONLY;
    const HEADER = CURLOPT_HEADER;
    const _HEADER_OUT = CURLINFO_HEADER_OUT;
    const HTTPGET = CURLOPT_HTTPGET;
    const HTTPPROXYTUNNEL = CURLOPT_HTTPPROXYTUNNEL;
    // const MUTE = CURLOPT_MUTE;
    const NETRC = CURLOPT_NETRC;
    const NOBODY = CURLOPT_NOBODY;
    const NOPROGRESS = CURLOPT_NOPROGRESS;
    const NOSIGNAL = CURLOPT_NOSIGNAL;
    const POST = CURLOPT_POST;
    const PUT = CURLOPT_PUT;
    const RETURNTRANSFER = CURLOPT_RETURNTRANSFER;
    const SSL_VERIFYPEER = CURLOPT_SSL_VERIFYPEER;
    const TRANSFERTEXT = CURLOPT_TRANSFERTEXT;
    const UNRESTRICTED_AUTH = CURLOPT_UNRESTRICTED_AUTH;
    const UPLOAD = CURLOPT_UPLOAD;
    const VERBOSE = CURLOPT_VERBOSE;

    /**
     * Required int
     */

    const BUFFERSIZE = CURLOPT_BUFFERSIZE;
    const CLOSEPOLICY = CURLOPT_CLOSEPOLICY;
    const CONNECTTIMEOUT = CURLOPT_CONNECTTIMEOUT;
    const CONNECTTIMEOUT_MS = CURLOPT_CONNECTTIMEOUT_MS;
    const DNS_CACHE_TIMEOUT = CURLOPT_DNS_CACHE_TIMEOUT;
    const FTPSSLAUTH = CURLOPT_FTPSSLAUTH;
    const HTTP_VERSION = CURLOPT_HTTP_VERSION;
    const HTTPAUTH = CURLOPT_HTTPAUTH;
    const INFILESIZE = CURLOPT_INFILESIZE;
    const LOW_SPEED_LIMIT = CURLOPT_LOW_SPEED_LIMIT;
    const LOW_SPEED_TIME = CURLOPT_LOW_SPEED_TIME;
    const MAXCONNECTS = CURLOPT_MAXCONNECTS;
    const MAXREDIRS = CURLOPT_MAXREDIRS;
    const PORT = CURLOPT_PORT;
    const PROTOCOLS = CURLOPT_PROTOCOLS;
    const PROXYAUTH = CURLOPT_PROXYAUTH;
    const PROXYPORT = CURLOPT_PROXYPORT;
    const PROXYTYPE = CURLOPT_PROXYTYPE;
    const REDIR_PROTOCOLS = CURLOPT_REDIR_PROTOCOLS;
    const RESUME_FROM = CURLOPT_RESUME_FROM;
    const SSL_VERIFYHOST = CURLOPT_SSL_VERIFYHOST;
    const SSLVERSION = CURLOPT_SSLVERSION;
    const TIMECONDITION = CURLOPT_TIMECONDITION;
    const TIMEOUT = CURLOPT_TIMEOUT;
    const TIMEOUT_MS = CURLOPT_TIMEOUT_MS;
    const TIMEVALUE = CURLOPT_TIMEVALUE;
    const MAX_RECV_SPEED_LARGE = CURLOPT_MAX_RECV_SPEED_LARGE;
    const MAX_SEND_SPEED_LARGE = CURLOPT_MAX_SEND_SPEED_LARGE;

    /**
     * Required string
     */

    const CAINFO = CURLOPT_CAINFO;
    const CAPATH = CURLOPT_CAPATH;
    const COOKIE = CURLOPT_COOKIE;
    const COOKIEFILE = CURLOPT_COOKIEFILE;
    const COOKIEJAR = CURLOPT_COOKIEJAR;
    const CUSTOMREQUEST = CURLOPT_CUSTOMREQUEST;
    const EGDSOCKET = CURLOPT_EGDSOCKET;
    const ENCODING = CURLOPT_ENCODING;
    const FTPPORT = CURLOPT_FTPPORT;
    const INTERF = CURLOPT_INTERFACE;
    const KRB4LEVEL = CURLOPT_KRB4LEVEL;
    const POSTFIELDS = CURLOPT_POSTFIELDS;
    const PROXY = CURLOPT_PROXY;
    const PROXYUSERPWD = CURLOPT_PROXYUSERPWD;
    const RANDOM_FILE = CURLOPT_RANDOM_FILE;
    const RANGE = CURLOPT_RANGE;
    const REFERER = CURLOPT_REFERER;
    const SSL_CIPHER_LIST = CURLOPT_SSL_CIPHER_LIST;
    const SSLCERT = CURLOPT_SSLCERT;
    const SSLCERTPASSWD = CURLOPT_SSLCERTPASSWD;
    const SSLCERTTYPE = CURLOPT_SSLCERTTYPE;
    const SSLENGINE = CURLOPT_SSLENGINE;
    const SSLENGINE_DEFAULT = CURLOPT_SSLENGINE_DEFAULT;
    const SSLKEY = CURLOPT_SSLKEY;
    const SSLKEYPASSWD = CURLOPT_SSLKEYPASSWD;
    const SSLKEYTYPE = CURLOPT_SSLKEYTYPE;
    const URL = CURLOPT_URL;
    const USERAGENT = CURLOPT_USERAGENT;
    const USERPWD = CURLOPT_USERPWD;

    /**
     * Required array
     */

    const HTTP200ALIASES = CURLOPT_HTTP200ALIASES;
    const HTTPHEADER = CURLOPT_HTTPHEADER;
    const POSTQUOTE = CURLOPT_POSTQUOTE;
    const QUOTE = CURLOPT_QUOTE;

    /**
     * Required stream
     */

    const FILE = CURLOPT_FILE;
    const INFILE = CURLOPT_INFILE;
    const STDERR = CURLOPT_STDERR;
    const WRITEHEADER = CURLOPT_WRITEHEADER;

    /**
     * Required callback
     */

    const HEADERFUNCTION = CURLOPT_HEADERFUNCTION;
    // const PASSWDFUNCTION = CURLOPT_PASSWDFUNCTION;
    const PROGRESSFUNCTION = CURLOPT_PROGRESSFUNCTION;
    const READFUNCTION = CURLOPT_READFUNCTION;
    const WRITEFUNCTION = CURLOPT_WRITEFUNCTION;

    protected static $mapping = array(
        self::AUTOREFERER => 'bool',
        self::BINARYTRANSFER => 'bool',
        self::COOKIESESSION => 'bool',
        self::CERTINFO => 'bool',
        self::CRLF => 'bool',
        self::DNS_USE_GLOBAL_CACHE => 'bool',
        self::FAILONERROR => 'bool',
        self::FILETIME => 'bool',
        self::FOLLOWLOCATION => 'bool',
        self::FORBID_REUSE => 'bool',
        self::FRESH_CONNECT => 'bool',
        self::FTP_USE_EPRT => 'bool',
        self::FTP_USE_EPSV => 'bool',
        self::FTPAPPEND => 'bool',
        // self::FTPASCII => 'bool',
        self::FTPLISTONLY => 'bool',
        self::HEADER => 'bool',
        self::_HEADER_OUT => 'bool',
        self::HTTPGET => 'bool',
        self::HTTPPROXYTUNNEL => 'bool',
        // self::MUTE => 'bool',
        self::NETRC => 'bool',
        self::NOBODY => 'bool',
        self::NOPROGRESS => 'bool',
        self::NOSIGNAL => 'bool',
        self::POST => 'bool',
        self::PUT => 'bool',
        self::RETURNTRANSFER => 'bool',
        self::SSL_VERIFYPEER => 'bool',
        self::TRANSFERTEXT => 'bool',
        self::UNRESTRICTED_AUTH => 'bool',
        self::UPLOAD => 'bool',
        self::VERBOSE => 'bool',
        self::BUFFERSIZE => 'int',
        self::CLOSEPOLICY => 'int',
        self::CONNECTTIMEOUT => 'int',
        self::CONNECTTIMEOUT_MS => 'int',
        self::DNS_CACHE_TIMEOUT => 'int',
        self::FTPSSLAUTH => 'int',
        self::HTTP_VERSION => 'int',
        self::HTTPAUTH => 'int',
        self::INFILESIZE => 'int',
        self::LOW_SPEED_LIMIT => 'int',
        self::LOW_SPEED_TIME => 'int',
        self::MAXCONNECTS => 'int',
        self::MAXREDIRS => 'int',
        self::PORT => 'int',
        self::PROTOCOLS => 'int',
        self::PROXYAUTH => 'int',
        self::PROXYPORT => 'int',
        self::PROXYTYPE => 'int',
        self::REDIR_PROTOCOLS => 'int',
        self::RESUME_FROM => 'int',
        self::SSL_VERIFYHOST => 'int',
        self::SSLVERSION => 'int',
        self::TIMECONDITION => 'int',
        self::TIMEOUT => 'int',
        self::TIMEOUT_MS => 'int',
        self::TIMEVALUE => 'int',
        self::MAX_RECV_SPEED_LARGE => 'int',
        self::MAX_SEND_SPEED_LARGE => 'int',
        self::CAINFO => 'string',
        self::CAPATH => 'string',
        self::COOKIE => 'string',
        self::COOKIEFILE => 'string',
        self::COOKIEJAR => 'string',
        self::CUSTOMREQUEST => 'string',
        self::EGDSOCKET => 'string',
        self::ENCODING => 'string',
        self::FTPPORT => 'string',
        self::INTERF => 'string',
        self::KRB4LEVEL => 'string',
        self::POSTFIELDS => 'string',
        self::PROXY => 'string',
        self::PROXYUSERPWD => 'string',
        self::RANDOM_FILE => 'string',
        self::RANGE => 'string',
        self::REFERER => 'string',
        self::SSL_CIPHER_LIST => 'string',
        self::SSLCERT => 'string',
        self::SSLCERTPASSWD => 'string',
        self::SSLCERTTYPE => 'string',
        self::SSLENGINE => 'string',
        self::SSLENGINE_DEFAULT => 'string',
        self::SSLKEY => 'string',
        self::SSLKEYPASSWD => 'string',
        self::SSLKEYTYPE => 'string',
        self::URL => 'string',
        self::USERAGENT => 'string',
        self::USERPWD => 'string',
        self::HTTP200ALIASES => 'array',
        self::HTTPHEADER => 'array',
        self::POSTQUOTE => 'array',
        self::QUOTE => 'array',
        self::FILE => 'stream',
        self::INFILE => 'stream',
        self::STDERR => 'stream',
        self::WRITEHEADER => 'stream',
        self::HEADERFUNCTION => 'callback',
        // self::PASSWDFUNCTION => 'callback',
        self::PROGRESSFUNCTION => 'callback',
        self::READFUNCTION => 'callback',
        self::WRITEFUNCTION => 'callback',
    );

    public static function validate($option, $value)
    {
        if (false == array_key_exists($option, self::$mapping)) {
            throw new InvalidArgumentException('This option does not exists');
        }

        $type = self::$mapping[$option];

        if ($type == 'bool') {
            if (false == is_bool($value)) {
                throw new InvalidArgumentException('Boolean expected');
            }
        }
        elseif ($type == 'int') {
            if (false == is_int($value)) {
                throw new InvalidArgumentException('Integer expected');
            }
        }
        elseif ($type == 'string') {
            if (false == is_string($value)) {
                throw new InvalidArgumentException('String expected');
            }
        }
        elseif ($type == 'array') {
            if (false == is_array($value)) {
                throw new InvalidArgumentException('Array expected');
            }
        }
        elseif ($type == 'array') {
            if (false == is_resource($value)) {
                throw new InvalidArgumentException('Stream expected');
            }
        }
        elseif ($type == 'callback') {
            if (false == is_callable($value)) {
                throw new InvalidArgumentException('Callback expected');
            }
        }
    }

    public static function set($handler, $option, $value=null)
    {
        $options = is_array($option) ? $option : array($option => $value);

        foreach ($options as $option => $value) {
            self::validate($option, $value);
            $resp = curl_setopt($handler, $option, $value);
            if (!$resp) {
                throw new InvalidArgumentException('Error while setting option');
            }
        }
    }
}