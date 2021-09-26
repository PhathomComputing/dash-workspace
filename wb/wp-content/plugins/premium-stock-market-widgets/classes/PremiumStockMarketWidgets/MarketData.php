<?php

namespace PremiumStockMarketWidgets;

/**
 * Class MarketData
 *
 * @package PremiumStockMarketWidgets
 */
class MarketData
{
    const CACHE_FOLDER = 'data';

    protected $params;

    protected $endPoints = [
        'quotes' => [
            'fields'    => ['type', 'symbol', 'name', 'logo', 'logo_name', 'logo_name_link', 'link', 'chart', 'price', 'currency', 'currency_symbol', 'open', 'low', 'high', 'previous_close', 'change_abs', 'change_pct', '52_week_low', '52_week_low_change_abs', '52_week_low_change_pct', '52_week_high', '52_week_high_change_abs', '52_week_high_change_pct', 'volume', 'shares_outstanding', 'market_cap', 'exchange_code', 'exchange_name', 'exchange_tz_name', 'exchange_tz_code', 'last_update'],
            'url'       => 'https://query%d.finance.yahoo.com/v7/finance/quote?formatted=false&symbols=%s&fields=shortName,longName,regularMarketOpen,regularMarketPrice,regularMarketChange,regularMarketChangePercent,regularMarketVolume,sharesOutstanding,marketCap,fiftyTwoWeekLow,fiftyTwoWeekHigh',
            'result'    => 'quoteResponse.result',
            'cache'     => 600
        ],
        'quotes-extended' => [
            'url'       => 'https://query%d.finance.yahoo.com/v10/finance/quoteSummary/%s?formatted=false&modules=price,summaryDetail,defaultKeyStatistics,financialData',
            'result'    => 'quoteSummary.result',
            'cache'     => 600
        ],
        'info' => [
            'fields'    => ['symbol', 'name', 'logo', 'logo_name', 'description', 'industry', 'sector', 'phone', 'website', 'address', 'city', 'state', 'country', 'zip', 'employees_count'],
            'url'       => 'https://query%d.finance.yahoo.com/v10/finance/quoteSummary/%s?formatted=false&modules=price,summaryProfile',
            'result'    => 'quoteSummary.result',
            'cache'     => 15724800 // 182 days
        ],
        'options' => [
            'url'       => 'https://query%d.finance.yahoo.com/v7/finance/options/%s?formatted=true&date=%s',
            'result'    => 'optionChain.result',
            'cache'     => 600
        ],
        'history' => [
            'url'       => 'https://query%d.finance.yahoo.com/v8/finance/chart/%s?range=%s&interval=%s&includePrePost=false',
            'result'    => 'chart.result',
            'cache'     => [
//                '1m' => 60,
//                '2m' => 60,
                '5m' => 300,
                '15m' => 900,
                '30m' => 1800,
                '60m' => 3600,
                '90m' => 5400,
                '1h' => 3600,
                '1d' => 43200, // 12h
                '5d' => 86400, // 24h
                '1wk' => 86400, // 24h
                '1mo' => 86400, // 24h
                '3mo' => 604800, // 7d
            ]
        ]
    ];

    protected $endpointKey;

    function __construct(array $request)
    {
        $cacheDirPath = __DIR__ . '/../../' . self::CACHE_FOLDER;

        // automatically create cache dir if it doesn't exist
        if (!is_dir($cacheDirPath)) {
            mkdir($cacheDirPath);
        }

        foreach ($request as $key => $value) {
            if (in_array($key, ['api', 'type', 'assets', 'fields', 'range', 'interval', 'feed', 'expiration_date'])) {
                $this->params[$key] = $value;
            }
        }

        if ($this->params['api'] == 'yf') {
            // determine request type
            if (isset($this->params['range']) && isset($this->params['interval'])) {
                $this->endpointKey = 'history';
            // equity options
            } elseif (strpos($this->params['type'], '-options') !== FALSE) {
                $this->endpointKey = 'options';
            // basic quote fields
            } elseif (!isset($this->params['fields']) || (is_array($this->params['fields']) && Helper::arrayContainsAll($this->params['fields'], $this->endPoints['quotes']['fields']))) {
                $this->endpointKey = 'quotes';
            } elseif (isset($this->params['fields']) && is_array($this->params['fields'])) {
                // company info
                if (Helper::arrayContainsAll($this->params['fields'], $this->endPoints['info']['fields'])) {
                    $this->endpointKey = 'info';
                // extended quote fields
                } else {
                    $this->endpointKey = 'quotes-extended';
                }
            }
        }
    }

    public function get()
    {
        $data = [];

        if ($this->params['api'] == 'yf') {
            if (isset($this->endPoints[$this->endpointKey]) && is_array($this->params['assets']) && !empty($this->params['assets'])) {

                $assets = [];
                // loop through requested assets
                foreach ($this->params['assets'] as $asset) {
                    // check if cache for the given asset exists and not expired
                    $cacheFileName = $this->getCacheFileName($asset);

                    if (Helper::cacheExists($cacheFileName, $this->getCacheTime())) {
                        $data[] = Helper::readJson($cacheFileName);
                    // otherwise mark the given asset to pull data from API
                    } else {
                        $assets[] = $asset;
                    }
                }

                // if not all data can be loaded from cache
                if (!empty($assets)) {
                    $urls = $this->getRequestUrls($assets);

                    $unprocessedAssets = $assets;

                    foreach ($urls as $url) {
                        $http = new Http($url);
                        $response = $http->get();

                        // get array of data items
                        $dataItems = Helper::getObjectProperty($response, $this->endPoints[$this->endpointKey]['result']);
                        if (!empty($dataItems)) {
                            // loop through all received data items
                            foreach ($dataItems as $dataItem) {
                                $dataItem = $this->processDataItem($dataItem); // re-format item object if needed
                                $data[] = $dataItem; // add item to the result array
                                Helper::saveJson($this->getCacheFileName($dataItem['symbol']), $dataItem); // save in cache
                                unset($unprocessedAssets[array_search($dataItem['symbol'], $unprocessedAssets)]);
                            }
                        }
                    }

                    // loop through unprocessed assets and return an empty response
                    foreach ($unprocessedAssets as $asset) {
                        $data[] = array_merge($this->processDataItem(NULL), ['symbol' => $asset]);
                    }
                }
            }
        } elseif ($this->params['api'] == 'news' && preg_match('#^https?://#', $this->params['feed'])) {
            $data = [['symbol' => $this->params['feed'], 'items' => []]]; // note that $data should be an indexed array
            $cacheFileName = $this->getCacheFileName($this->params['feed']);

            if (Helper::cacheExists($cacheFileName, $this->getCacheTime())) {
                $xml = Helper::readFile($cacheFileName);
            } else {
                $http = new Http($this->params['feed']);
                $xml = $http->get(FALSE);
                Helper::saveFile($cacheFileName, $xml);
            }

            $simpleXml = simplexml_load_string($xml);
            foreach ($simpleXml->channel->item as $item) {
                $media = $item->children('media', TRUE)->content;
                // note that date_create_from_format(\DateTime::RSS, trim((string) $item->pubDate))->getTimestamp() doesn't work in all cases
                $dateTime = strtotime(trim((string) $item->pubDate));

                $data[0]['items'][] = [
                    'title'         => trim(html_entity_decode((string) $item->title, ENT_QUOTES)),
                    'url'           => trim((string) $item->link),
                    'date_time'     => $dateTime ? $dateTime * 1000 : NULL,
                    'description'   => trim(strip_tags(html_entity_decode((string) $item->description, ENT_QUOTES))),
                    'image_url'     => $media ? (string) $media->attributes()['url'] : ($item->image ? (string) $item->image : ''),
                    'categories'    => $item->category ? array_map(function ($c) { return (string) $c; }, (array) $item->category) : [],
                ];
            }
        }

        return json_encode(['success' => !empty($data) ? TRUE : FALSE, 'data' => $data]);
    }

    /**
     * Get API request URLs based on the request type
     *
     * @param $assets
     * @return array
     */
    private function getRequestUrls($assets)
    {
        $urls = [];
        $baseUrl = $this->endPoints[$this->endpointKey]['url'];

        // for history requests each asset should be processed one by one
        if ($this->endpointKey == 'history') {
            foreach ($assets as $asset) {
                $urls[] = sprintf($baseUrl, rand(1, 2), $asset, $this->params['range'], $this->params['interval']);
            }
        // for extended quotes requests each asset should be processed one by one
        } elseif ($this->endpointKey == 'quotes-extended' || ($this->endpointKey == 'info' && count($assets) > 1)) {
            foreach ($assets as $asset) {
                $urls[] = sprintf($baseUrl, rand(1, 2), $asset);
            }
        } elseif ($this->endpointKey == 'options') {
            $urls[] = sprintf($baseUrl, rand(1, 2), implode(',', $assets), $this->params['expiration_date'] ?: '');
        }  else {
            $urls[] = sprintf($baseUrl, rand(1, 2), implode(',', $assets));
        }

        return $urls;
    }

    private function processDataItem($item)
    {
        $result = [];

        // regular quotes
        if ($this->endpointKey == 'quotes') {
            $result['type'] = Helper::getObjectProperty($item, 'quoteType');
            $result['symbol'] = Helper::getObjectProperty($item, 'symbol');
            $result['name'] = Helper::getObjectProperty($item, 'longName') ?: Helper::getObjectProperty($item, 'shortName');
            $result['price'] = Helper::getObjectProperty($item, 'regularMarketPrice');
            $result['currency'] = Helper::getObjectProperty($item, 'currency');
            $result['currency_symbol'] = $this->getCurrencySymbol(Helper::getObjectProperty($item, 'currency'));
            $result['open'] = Helper::getObjectProperty($item, 'regularMarketOpen');
            $result['low'] = Helper::getObjectProperty($item, 'regularMarketDayLow');
            $result['high'] = Helper::getObjectProperty($item, 'regularMarketDayHigh');
            $result['previous_close'] = Helper::getObjectProperty($item, 'regularMarketPreviousClose');
            $result['change_abs'] = Helper::getObjectProperty($item, 'regularMarketChange');
            $result['change_pct'] = Helper::getObjectProperty($item, 'regularMarketChangePercent') / 100;
            $result['52_week_low'] = Helper::getObjectProperty($item, 'fiftyTwoWeekLow');
            $result['52_week_low_change_abs'] = Helper::getObjectProperty($item, 'fiftyTwoWeekLowChange');
            $result['52_week_low_change_pct'] = Helper::getObjectProperty($item, 'fiftyTwoWeekLowChangePercent');
            $result['52_week_high'] = Helper::getObjectProperty($item, 'fiftyTwoWeekHigh');
            $result['52_week_high_change_abs'] = Helper::getObjectProperty($item, 'fiftyTwoWeekHighChange');
            $result['52_week_high_change_pct'] = Helper::getObjectProperty($item, 'fiftyTwoWeekHighChangePercent');
            $result['volume'] = Helper::getObjectProperty($item, 'regularMarketVolume');
            $result['shares_outstanding'] = Helper::getObjectProperty($item, 'sharesOutstanding');
            $result['market_cap'] = Helper::getObjectProperty($item, 'marketCap');
            $result['exchange_code'] = Helper::getObjectProperty($item, 'exchange');
            $result['exchange_name'] = Helper::getObjectProperty($item, 'fullExchangeName');
            $result['exchange_tz_name'] = Helper::getObjectProperty($item, 'exchangeTimezoneName');
            $result['exchange_tz_code'] = Helper::getObjectProperty($item, 'exchangeTimezoneShortName');
            $result['last_update'] = Helper::getObjectProperty($item, 'regularMarketTime') * 1000; // seconds --> miliseconds
        // extended quotes
        } elseif ($this->endpointKey == 'quotes-extended') {
            // general
            $result['type'] = Helper::getObjectProperty($item, 'price.quoteType');
            $result['symbol'] = Helper::getObjectProperty($item, 'price.symbol');
            $result['name'] = Helper::getObjectProperty($item, 'price.longName') ?: Helper::getObjectProperty($item, 'price.shortName');
            $result['price'] = Helper::getObjectProperty($item, 'price.regularMarketPrice');
            $result['currency'] = Helper::getObjectProperty($item, 'price.currency');
            $result['currency_symbol'] = $this->getCurrencySymbol(Helper::getObjectProperty($item, 'price.currency'));
            $result['open'] = Helper::getObjectProperty($item, 'price.regularMarketOpen');
            $result['low'] = Helper::getObjectProperty($item, 'price.regularMarketDayLow');
            $result['high'] = Helper::getObjectProperty($item, 'price.regularMarketDayHigh');
            $result['previous_close'] = Helper::getObjectProperty($item, 'price.regularMarketPreviousClose');
            $result['change_abs'] = Helper::getObjectProperty($item, 'price.regularMarketChange');
            $result['change_pct'] = Helper::getObjectProperty($item, 'price.regularMarketChangePercent');
            $result['volume'] = Helper::getObjectProperty($item, 'price.regularMarketVolume');
            $result['market_cap'] = Helper::getObjectProperty($item, 'price.marketCap');
            $result['exchange_code'] = Helper::getObjectProperty($item, 'price.exchange');
            $result['exchange_name'] = Helper::getObjectProperty($item, 'price.exchangeName');
            $result['last_update'] = Helper::getObjectProperty($item, 'price.regularMarketTime') * 1000; // seconds --> miliseconds
            // summaryDetail
            $result['52_week_low'] = Helper::getObjectProperty($item, 'summaryDetail.fiftyTwoWeekLow');
            $result['52_week_high'] = Helper::getObjectProperty($item, 'summaryDetail.fiftyTwoWeekHigh');
            $result['dividend_rate'] = Helper::getObjectProperty($item, 'summaryDetail.dividendRate');
            $result['dividend_yield'] = Helper::getObjectProperty($item, 'summaryDetail.dividendYield');
            $result['ex_dividend_date'] = Helper::getObjectProperty($item, 'summaryDetail.exDividendDate') * 1000;
            $result['5_year_avg_dividend_yield'] = Helper::getObjectProperty($item, 'summaryDetail.fiveYearAvgDividendYield');
            $result['payout_ratio'] = Helper::getObjectProperty($item, 'summaryDetail.payoutRatio');
            $result['beta'] = Helper::getObjectProperty($item, 'summaryDetail.beta');
            $result['pe_ratio'] = Helper::getObjectProperty($item, 'summaryDetail.trailingPE');
            $result['forward_pe_ratio'] = Helper::getObjectProperty($item, 'summaryDetail.forwardPE');
            $result['average_volume'] = Helper::getObjectProperty($item, 'summaryDetail.averageVolume');
            $result['average_volume_10_days'] = Helper::getObjectProperty($item, 'summaryDetail.averageVolume10days');
            $result['price_to_sales_trailing_12_months'] = Helper::getObjectProperty($item, 'summaryDetail.priceToSalesTrailing12Months');
            $result['50_day_average'] = Helper::getObjectProperty($item, 'summaryDetail.fiftyDayAverage');
            $result['200_day_average'] = Helper::getObjectProperty($item, 'summaryDetail.twoHundredDayAverage');
            $result['annual_dividend_rate'] = Helper::getObjectProperty($item, 'summaryDetail.trailingAnnualDividendRate');
            $result['annual_dividend_yield'] = Helper::getObjectProperty($item, 'summaryDetail.trailingAnnualDividendYield');
            // defaultKeyStatistics
            $result['52_week_change'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.52WeekChange');
            $result['enterprise_value'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.enterpriseValue');
            $result['profit_margin'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.profitMargins');
            $result['shares_outstanding'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.sharesOutstanding');
            $result['shares_float'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.floatShares');
            $result['shares_short'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.sharesShort');
            $result['short_ratio'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.shortRatio');
            $result['short_pct_of_float'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.shortPercentOfFloat');
            $result['book_value'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.bookValue');
            $result['price_book'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.priceToBook');
            $result['quarter_earnings_growth'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.earningsQuarterlyGrowth');
            $result['net_income_to_common'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.netIncomeToCommon');
            $result['eps'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.trailingEps');
            $result['forward_eps'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.forwardEps');
            $result['peg_ratio'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.pegRatio');
            $result['last_split_factor'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.lastSplitFactor');
            $result['last_split_date'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.lastSplitDate') * 1000;
            $result['enterprise_revenue'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.enterpriseToRevenue');
            $result['enterprise_ebitda'] = Helper::getObjectProperty($item, 'defaultKeyStatistics.enterpriseToEbitda');
            // financialData
            $result['target_high_price'] = Helper::getObjectProperty($item, 'financialData.targetHighPrice');
            $result['target_low_price'] = Helper::getObjectProperty($item, 'financialData.targetLowPrice');
            $result['target_mean_price'] = Helper::getObjectProperty($item, 'financialData.targetMeanPrice');
            $result['target_median_price'] = Helper::getObjectProperty($item, 'financialData.targetMedianPrice');
            $result['recommendation_mean'] = Helper::getObjectProperty($item, 'financialData.recommendationMean');
            $result['recommendation_key'] = Helper::getObjectProperty($item, 'financialData.recommendationKey');
            $result['analyst_opinions'] = Helper::getObjectProperty($item, 'financialData.numberOfAnalystOpinions');
            $result['total_cash'] = Helper::getObjectProperty($item, 'financialData.totalCash');
            $result['total_cash_per_share'] = Helper::getObjectProperty($item, 'financialData.totalCashPerShare');
            $result['ebitda'] = Helper::getObjectProperty($item, 'financialData.ebitda');
            $result['ebitda_margin'] = Helper::getObjectProperty($item, 'financialData.ebitdaMargins');
            $result['total_debt'] = Helper::getObjectProperty($item, 'financialData.totalDebt');
            $result['quick_ratio'] = Helper::getObjectProperty($item, 'financialData.quickRatio');
            $result['current_ratio'] = Helper::getObjectProperty($item, 'financialData.currentRatio');
            $result['total_revenue'] = Helper::getObjectProperty($item, 'financialData.totalRevenue');
            $result['debt_equity'] = Helper::getObjectProperty($item, 'financialData.debtToEquity');
            $result['revenue_per_share'] = Helper::getObjectProperty($item, 'financialData.revenuePerShare');
            $result['return_on_assets'] = Helper::getObjectProperty($item, 'financialData.returnOnAssets');
            $result['return_on_equity'] = Helper::getObjectProperty($item, 'financialData.returnOnEquity');
            $result['gross_profit'] = Helper::getObjectProperty($item, 'financialData.grossProfits');
            $result['gross_margin'] = Helper::getObjectProperty($item, 'financialData.grossMargins');
            $result['free_cashflow'] = Helper::getObjectProperty($item, 'financialData.freeCashflow');
            $result['operating_cashflow'] = Helper::getObjectProperty($item, 'financialData.operatingCashflow');
            $result['earnings_growth'] = Helper::getObjectProperty($item, 'financialData.earningsGrowth');
            $result['revenue_growth'] = Helper::getObjectProperty($item, 'financialData.revenueGrowth');
            $result['operating_margin'] = Helper::getObjectProperty($item, 'financialData.operatingMargins');
        // info data
        } elseif ($this->endpointKey == 'info') {
            $result['symbol'] = Helper::getObjectProperty($item, 'price.symbol');
            $result['name'] = Helper::getObjectProperty($item, 'price.longName') ?: Helper::getObjectProperty($item, 'price.shortName');
            $result['address'] = Helper::getObjectProperty($item, 'summaryProfile.address1');
            $result['city'] = Helper::getObjectProperty($item, 'summaryProfile.city');
            $result['state'] = Helper::getObjectProperty($item, 'summaryProfile.state');
            $result['zip'] = Helper::getObjectProperty($item, 'summaryProfile.zip');
            $result['country'] = Helper::getObjectProperty($item, 'summaryProfile.country');
            $result['phone'] = Helper::getObjectProperty($item, 'summaryProfile.phone');
            $result['website'] = Helper::getObjectProperty($item, 'summaryProfile.website');
            $result['industry'] = Helper::getObjectProperty($item, 'summaryProfile.industry');
            $result['sector'] = Helper::getObjectProperty($item, 'summaryProfile.sector');
            $result['description'] = Helper::getObjectProperty($item, 'summaryProfile.longBusinessSummary');
            $result['employees_count'] = Helper::getObjectProperty($item, 'summaryProfile.fullTimeEmployees');
        // options
        } elseif ($this->endpointKey == 'options') {
            $map = function ($option) {
                return [
                    'contract_symbol' => Helper::getObjectProperty($option, 'contractSymbol'),
                    'currency' => Helper::getObjectProperty($option, 'currency'),
                    'bid' => Helper::getObjectProperty($option, 'bid.raw'),
                    'ask' => Helper::getObjectProperty($option, 'ask.raw'),
                    'price' => Helper::getObjectProperty($option, 'lastPrice.raw'),
                    'change_abs' => Helper::getObjectProperty($option, 'change.raw'),
                    'change_pct' => Helper::getObjectProperty($option, 'percentChange.raw') / 100,
                    'strike' => Helper::getObjectProperty($option, 'strike.raw'),
                    'volume' => Helper::getObjectProperty($option, 'volume.raw'),
                    'open_interest' => Helper::getObjectProperty($option, 'openInterest.raw'),
                    'in_the_money' => Helper::getObjectProperty($option, 'inTheMoney'),
                    'implied_volatility' => Helper::getObjectProperty($option, 'impliedVolatility.raw'),
                    'last_trade_date' => Helper::getObjectProperty($option, 'lastTradeDate.raw') * 1000,
                    'contract_size' => ucwords(strtolower(Helper::getObjectProperty($option, 'contractSize'))),
                ];
            };

            $result['symbol'] = Helper::getObjectProperty($item, 'underlyingSymbol');
            $result['currency'] = Helper::getObjectProperty($item, 'quote.currency');
            $result['currency_symbol'] = $this->getCurrencySymbol(Helper::getObjectProperty($item, 'quote.currency'));
            $result['expiration_dates'] = array_map(function ($date) { return $date * 1000; }, Helper::getObjectProperty($item, 'expirationDates'));
            $result['expiration_date'] = isset($this->params['expiration_date'])
                ? $this->params['expiration_date'] * 1000
                : (!empty($result['expiration_dates']) ? $result['expiration_dates'][0] : NULL);
            $result['strikes'] = Helper::getObjectProperty($item, 'strikes');
            $result['calls'] = array_map($map, Helper::getObjectProperty($item, 'options.0.calls'));
            $result['puts'] = array_map($map, Helper::getObjectProperty($item, 'options.0.puts'));
            $result['calls_puts'] = array_merge(
                array_map(function ($option) { return array_merge($option, ['type' => 'Call']); }, $result['calls']),
                array_map(function ($option) { return array_merge($option, ['type' => 'Put']); }, $result['puts'])
            );
        // historical data
        } elseif ($this->endpointKey == 'history') {
            $ts = Helper::getObjectProperty($item, 'timestamp');
            $open = Helper::getObjectProperty($item, 'indicators.quote.0.open');
            $high = Helper::getObjectProperty($item, 'indicators.quote.0.high');
            $low = Helper::getObjectProperty($item, 'indicators.quote.0.low');
            $close = Helper::getObjectProperty($item, 'indicators.quote.0.close');
            $volume = Helper::getObjectProperty($item, 'indicators.quote.0.volume');

            $result = [
                'symbol' => Helper::getObjectProperty($item, 'meta.symbol'),
                'currency' => Helper::getObjectProperty($item, 'meta.currency'),
                'currency_symbol' => $this->getCurrencySymbol(Helper::getObjectProperty($item, 'meta.currency')),
                'series' => [
                    $this->params['range'] => [
                        $this->params['interval'] => [
                            'date'      => !empty($ts) ? array_map(function($date) { return $date * 1000; }, $ts) : [], // seconds --> miliseconds
                            'open'      => !empty($open) ? $open : [],
                            'high'      => !empty($high) ? $high : [],
                            'low'       => !empty($low) ? $low : [],
                            'close'     => !empty($close) ? $close : [],
                            'volume'    => !empty($volume) ? $volume : [],
                        ]
                    ]
                ]
            ];
        }

        return $result;
    }

    private function getCacheFileName($id)
    {
        return $this->params['api'] == 'yf'
            ? ($this->endpointKey == 'history'
                ? sprintf('%s/%s_%s_%s_%s.json', self::CACHE_FOLDER, $id, $this->endpointKey, $this->params['range'], $this->params['interval'])
                : ($this->endpointKey == 'options' && isset($this->params['expiration_date'])
                    ? sprintf('%s/%s_%s_%d.json', self::CACHE_FOLDER, $id, $this->endpointKey, $this->params['expiration_date'])
                    : sprintf('%s/%s_%s.json', self::CACHE_FOLDER, $id, $this->endpointKey)))
            : sprintf('%s/%s.xml', self::CACHE_FOLDER, md5($id));
    }

    private function getCacheTime()
    {
        return $this->params['api'] == 'yf'
            ? ($this->endpointKey == 'history'
                ? $this->endPoints[$this->endpointKey]['cache'][$this->params['interval']]
                : $this->endPoints[$this->endpointKey]['cache'])
            : 600;
    }

    private function getCurrencySymbol($code)
    {
        $symbols = [
            'USD' => '$',
            'AUD' => '$',
            'BRL' => 'R$',
            'CAD' => '$',
            'CNY' => '¥',
            'CZK' => 'Kč',
            'EUR' => '€',
            'EGP' => '£',
            'GBP' => '£',
            'INR' => '₹',
            'ILS' => '₪',
            'IDR' => 'Rp',
            'JPY' => '¥',
            'KPW' => '₩',
            'KRW' => '₩',
            'PLN' => 'zł',
            'RUB' => '₽',
            'UAH' => '₴',
            'QAR' => '﷼',
            'GOLD' => 'Gold g',
        ];

        return isset($symbols[$code]) ? $symbols[$code] : $code;
    }
}
