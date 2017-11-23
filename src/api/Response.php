<?php

namespace API;

/**
 * Return data with right response headers
 */
class Response
{
    public static function json($responseData)
    {
        echo json_encode($responseData);
    }

    public static function success($data)
    {
        $response = array(
            'success' => true
        );

        foreach ($data as $key => $value) {
            $response[$key] = $value;
        }

        self::json($response);
    }

    public static function error($data)
    {
        $response = array(
            'success' => false
        );

        foreach ($data as $key => $value) {
            $response[$key] = $value;
        }

        self::json($response);
    }

    /**
     * Echo data to the page
     *
     * @param array $imageData
     *    $imageData['type'] string - image mime-type
     *    $imageData['blob'] string - blob image
     *    $imageData['length'] int - image size
     */
    public static function showData($imageData)
    {
        $blob   = $imageData['blob'];
        $type   = $imageData['type'];
        $length = $imageData['length'];

        if ($type) {
            header("Content-Type: $type");
        }

        if ($length) {
            header("Content-Length: $length");
        }

        echo $blob;
    }

}
