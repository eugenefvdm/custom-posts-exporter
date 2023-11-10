<?php
/**
 * Register a debugger. This debugger shows output and can take three
 * parameters, the message, a variable, and mode (.e.g DEBUG)
 */
if (!function_exists('debugger')) {
    function debugger($message, $variable = '', $mode = "DEBUG")
    {
        global $plugin_name;

        if (get_option('forms_api_enable_debugger') !== "1") {
            return;
        }



        $serverAddr     = $_SERVER['SERVER_ADDR'];

        $dateTimeFormat = date('Y-m-d H:i:s');

        $prefix         = "[$dateTimeFormat] $serverAddr.$mode: ";

        if (is_array($variable) or is_object($variable)) {
            $variable = print_r($variable, 1);
        } else if (gettype($variable) == 'boolean') {
            $variable = "(Boolean: $variable)";
        }

        $logPath = (dirname(__FILE__)) . '/';
//        die($logPath);
//        $logPath = ABSPATH . "wp-content/plugins/$plugin_name/";
                                
        // file_put_contents($logPath . 'log_' . date("dmY") . '.log', $prefix . $message . $variable . "\n", FILE_APPEND);
        file_put_contents($logPath . 'log.txt', $prefix . $message . $variable . "\n", FILE_APPEND);
    }
}

/**
 * TODO
 * 
 * - Add option to output date according to locale
 */