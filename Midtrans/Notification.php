<?php

namespace Midtrans;

/**
 * Read raw post input and parse as JSON. Provide getters for fields in notification object
 *
 * Example:
 *
 * ```php
 *   $notif = new Midtrans_Notification();
 *   echo $notif->order_id;
 *   echo $notif->transaction_status;
 * ```
 */
class Midtrans_Notification
{
    private $response;

    public function __construct($input_source = "php://input")
    {
        $raw_notification = json_decode(file_get_contents($input_source), true);
        $status_response = Midtrans_Transaction::status($raw_notification['transaction_id']);
        $this->response = $status_response;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->response)) {
            return $this->response->$name;
        }
    }
}
