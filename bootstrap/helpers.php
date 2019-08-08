<?php
/**
 * @return bool
 */
if (!function_exists('isProduct')) {
    function isProduct()
    {
        return config('protect.env') === 'product';
    }
}
if (!function_exists('clear_url')) {
    function clear_url($url)
    {

        $arr = parse_url($url);

        $str = empty($arr['scheme']) ? 'http://' : $arr['scheme'] . '://';

        $str .= $arr['host'] . $arr['path'];

        return $str;

    }
}
