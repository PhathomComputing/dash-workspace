<?php

namespace PremiumStockMarketWidgets;

/**
 * Class MarketData
 *
 * @package PremiumStockMarketWidgets
 */
class AssetSearch
{
    const URL = 'https://finance.yahoo.com/_finance_doubledown/api/resource/searchassist;searchTerm=%s?&intl=us&lang=en-US';

    private $query;

    function __construct($request)
    {
        $this->query = isset($request['query']) ? $request['query'] : '';
    }

    public function get()
    {
        $data = [];

        if ($this->query) {
            $url = sprintf(self::URL, urlencode($this->query));
            $http = new Http($url);
            $response = $http->get();

            if (isset($response->items)) {
                foreach ($response->items as $key => $item) {
                    $data[$key]['symbol']   = str_replace(' ', '', $item->symbol); // important to replace space as some symbols like llpd.l contain a space for a some reason
                    $data[$key]['id']       = $data[$key]['symbol'];
                    $data[$key]['text']     = $item->name;
                    $data[$key]['type']     = $item->typeDisp;
                    $data[$key]['exchange'] = ucwords($item->exchDisp);
                }
            }
        }

        return json_encode($data);
    }
}