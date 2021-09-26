<?php


namespace PremiumStockMarketWidgets;

class Http
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($decodeJson = TRUE)
    {
        if (function_exists('wp_remote_get')) {
            $response = wp_remote_get($this->url);
            // check if there is no error in the HTTP request / response
            if (!$response instanceof \WP_Error && isset($response['body'])) {
                return $decodeJson ? json_decode(Helper::cleanString($response['body'])) : $response['body'];
            } else {
                Helper::log(sprintf('WP Remote Error: %s', $response->get_error_message()));
                return NULL;
            }
        } elseif (ini_get('allow_url_fopen')) {
            $response = @file_get_contents($this->url);
            return $decodeJson ? json_decode(Helper::cleanString($response)) : $response;
        } else {
            return [
                'error' => 'Please set allow_url_fopen = On in PHP settings.'
            ];
        }
    }
}
