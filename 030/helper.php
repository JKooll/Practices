<?php
if (!function_exists('ENV')) {
    function ENV($key, $default = '')
    {
        $env_arr = env_parser();
        if (array_key_exists($key, $env_arr)) {
            return $env_arr[$key];
        }
        return $default;
    }
}

if (!function_exists('env_parser')) {
    function env_parser()
    {
        $fp = open_env('.env', 'r');
        $env_arr = [];
        while (($str = fgets($fp)) !== false) {
            if (empty(trim($str)) || strpos(trim($str), '=') === false) {
                continue;
            }
            $temp_arr = explode('=', trim($str));
            if (empty($temp_arr[1])) {
                continue;
            }
            $env_arr[$temp_arr[0]] = $temp_arr[1];
        }
        fclose($fp);
        return $env_arr;
    }
}

if (!function_exists('set_env')) {
    function set_env($key, $val)
    {
        $env_arr = env_parser();
        $env_arr[$key] = $val;
        $fp = fopen('.env', 'w');
        $env_str = '';
        foreach($env_arr as $key => $val) {
            $env_str .= "{$key}={$val}" . PHP_EOL;
        }
        $result = fwrite($fp, $env_str);
        fclose($fp);
        return $result;
    }
}

if (!function_exists('open_env')) {
    function open_env($file, $mod)
    {
        return fopen($file, $mod);
    }
}
