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

if (!function_exists('url_top_domain')) {
    function url_top_domain($url)
    {
        $arr      = parse_url($url);
        $fullHost = $arr['host'];
        $fullHost = explode('.', $fullHost);
        $topHost  = array_slice($fullHost, -2, 2);
        $topHost  = strtolower(implode('.', $topHost));
        return $topHost;
    }
}

if (!function_exists('url_domain_name')) {
    function url_domain_name($url)
    {
        $arr      = parse_url($url);
        $fullHost = $arr['host'];
        $fullHost = explode('.', $fullHost);
        $topHost  = array_slice($fullHost, -2, 1);
        if (isset($topHost[0])) {
            $topHostName = strtolower($topHost[0]);
        } else {
            $topHostName = null;
        }

        return $topHostName;
    }
}
