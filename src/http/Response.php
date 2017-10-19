<?php

namespace HTTP;


class Response
{

    public static function NotFound() {

        self::response(404, 'Not Found');

    }

    public static function InternalServerError() {

        self::response(500, 'Internal Server Error');

    }

    /**
     * Echo data to the page
     *
     * @param $data
     * @param null|MIME-type $type - MIME type og data
     * @param null|int $length - size of data
     */
    public static function data($data, $type=null, $length=null) {

        if ($type) {
            header("Content-Type: $type");
        }

        if ($length) {
            header("Content-Length: $length");
        }

        echo $data;

    }

    private static function response($code, $status) {

        header("HTTP/1.0 $code $status");
        header("HTTP/1.1 $code $status");
        header("Status: $code $status");
        die();

    }

}