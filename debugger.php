<?php
/**
 * A basic debugger that writes output to a file.
 * It takes three parameters:
 * The message to output, a variable to output, and a mode (.e.g DEBUG, INFO, ERROR, etc)
 */
if (!function_exists('debugger')) {
    function debugger($message, $variable = '', $mode = "DEBUG")
    {
        if (get_option('forms_api_enable_debugger') !== "1") {
            return;
        }

        $serverAddr = $_SERVER['SERVER_ADDR'];

        $dateTimeFormat = date('Y-m-d H:i:s');

        $prefix = "[$dateTimeFormat] $serverAddr.$mode: ";

        if (is_array($variable) or is_object($variable)) {
            $variable = print_r($variable, 1);
        } else if (gettype($variable) == 'boolean') {
            $variable = "(Boolean: $variable)";
        }

        $logPath = (dirname(__FILE__)) . '/';

        file_put_contents($logPath . 'log.txt', $prefix . $message . $variable . "\n", FILE_APPEND);
    }
}
