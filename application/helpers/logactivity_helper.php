<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function logActivity($log_date_time, $log_browser, $log_path)
{
        $log_filename = "./assets/log_activities";

        if (!file_exists($log_filename)) {
                mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename . '/log_' . date('Ymd') . '.log';
        if (!file_exists($log_file_data)) {
                $log_msg = 'No         Date/Time            Browser            Access Path' . "\n" .
                        '---------  -------------------  -----------------  ---------------------------------------------------------------------------------------';
                file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
        }
        $lines = str_pad(count(file($log_file_data)) - 1, 9, "0", STR_PAD_LEFT);
        file_put_contents($log_file_data, str_pad($lines,11," ") . str_pad($log_date_time,21," ") .str_pad($log_browser,19," "). $log_path . "\n", FILE_APPEND);
}


