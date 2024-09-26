<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function setNotification($message, $type)
    {
        return [
            'message' => $message,
            'alert-type' => $type
        ];
    }
}
