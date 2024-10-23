<?php
function customErrorHandler($errno, $errstr, $errfile, $errline): void
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            throw new Exception("Notice: [$errno] $errstr - $errfile:$errline");
        // Handle other error types here
        default:
            throw new Exception("Error: [$errno] $errstr - $errfile:$errline");
    }
}

set_error_handler("customErrorHandler");