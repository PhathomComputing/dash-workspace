<?php

namespace PremiumStockMarketWidgets;

/**
 * Class WPHelper - WordPress related helper functions
 * @package PremiumStockMarketWidgets
 */
class WPHelper
{
    public static function activate()
    {
        self::checkPhpVersion();
        self::checkPhpExtensions();
        self::checkFolderPermissions();
        self::addOptions();
    }

    public static function uninstall()
    {
        self::unregister();
        self::deleteOptions();
    }

    public static function checkPhpVersion()
    {
        // Check current PHP version against the min version required for the plugin to run
        if (version_compare(PHP_VERSION, Plugin::MIN_PHP_VERSION, '<')) {
            wp_die(
                sprintf('<p>PHP <b>%s+</b> is required to use <b>%s</b> plugin. You have <b>%s</b> installed.</p>', Plugin::MIN_PHP_VERSION, Plugin::NAME, PHP_VERSION),
                Plugin::NAME . ': Activation Error',
                ['response' => 200, 'back_link' => TRUE]
            );
        }
    }

    public static function checkPhpExtensions()
    {
        if (!function_exists('simplexml_load_string')) {
            wp_die(
                sprintf('<p>PHP <b>XML extension</b> is required to use <b>%s</b> plugin.</p>', Plugin::NAME),
                Plugin::NAME . ': Activation Error',
                ['response' => 200, 'back_link' => TRUE]
            );
        }
    }

    public static function checkFolderPermissions()
    {
        $errorMessage = NULL;

        if (!is_writable(SMW_ROOT_DIR)) {
            $errorMessage = sprintf(
                'The plugin folder should be writable by the web server: <b>%s</b>', SMW_ROOT_DIR
            );
        }

        if ($errorMessage) {
            wp_die(
                $errorMessage,
                Plugin::NAME . ': Activation Error',
                ['response' => 200, 'back_link' => TRUE]
            );
        }

        return;
    }

    public static function addOptions()
    {
        // note that if the option already exists add_option() won't re-create or update it
        add_option('smw_purchase_code', '');
        add_option('smw_installation_id', '');

        $defaultConfig = [
            'locale'                    => 'en',
            'thousands_separator'       => ',',
            'decimal_separator'         => '.',
            'enqueue_priority'          => 10,
            'ajax_method'               => 'post',
            'asset_recognition_regexp'  => '',
            'asset_page_regexp'         => '',
            'asset_page_content'        => '',
            'asset_names_overrides'     => [],
            'default_number_format'     => '0,0.00',
            'fields_number_format'      => [
                'volume'                    => '0,0.00a',
                'shares_outstanding'        => '0,0.00a',
                'market_cap'                => '0,0.00a',
                'total_revenue'             => '0,0.00a',
                'total_cash'                => '0,0.00a',
                'total_debt'                => '0,0.00a',
                'gross_profit'              => '0,0.00a',
                'free_cashflow'             => '0,0.00a',
                'operating_cashflow'        => '0,0.00a',
                'change_pct'                => '0.00%',
                '52_week_low_change_pct'    => '0.00%',
                '52_week_high_change_pct'   => '0.00%',
                'payout_ratio'              => '0.00%',
                'dividend_yield'            => '0.00%',
                'annual_dividend_yield'     => '0.00%',
                'short_pct_of_float'        => '0.00%',
                'profit_margin'             => '0.00%',
                'quarter_earnings_growth'   => '0.00%',
                'gross_margin'              => '0.00%',
                'operating_margin'          => '0.00%',
                'ebitda_margin'             => '0.00%',
                'return_on_assets'          => '0.00%',
                'return_on_equity'          => '0.00%',
                'earnings_growth'           => '0.00%',
                'revenue_growth'            => '0.00%',
                'portfolio_change_pct'      => '0.00%',
                'portfolio_return_pct'      => '0.00%',
                'portfolio_quantity'        => '0,0',
                'employees_count'           => '0,0',
                'implied_volatility'        => '0.00%',
                'open_interest'             => '0,0',
            ],
            'default_date_format'      => 'LL',
            'fields_date_format'       => [
                'date'                  => 'll',
                'time'                  => 'H:mm',
                'date_time'             => 'lll',
                'last_update'           => 'LLL',
                'portfolio_date'        => 'L',
                'portfolio_sell_date'   => 'L',
                'expiration_date'       => 'll',
            ],
            'null_value_format'         => '-',
            'hide_symbol_suffix'        => FALSE,
            'default_asset_logo_url'    => plugin_dir_url(SMW_PLUGIN_FILE) . 'assets/images/asset.png',
            'google_maps_api_key'       => '',
        ];

        $userConfig = get_option('smw_config');

        if ($userConfig === FALSE) {
            add_option('smw_config', $defaultConfig);
        } else {
            array_walk($defaultConfig, function (&$options, $key) use ($userConfig) {
                $options = is_array($options) ? array_merge($options, $userConfig[$key]) : $userConfig[$key];
            });

            update_option('smw_config', $defaultConfig);
        }
    }

    public static function deleteOptions()
    {
        delete_option('smw_purchase_code');
        delete_option('smw_installation_id');
        delete_option('smw_config');
    }

    /**
     * Convert array to new line delimited key = value pairs
     *
     * @param $array
     * @return string
     */
    public static function arrayToTextarea($array)
    {
        $result = '';

        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $result .= $key . '=' . $value . "\n";
            }
        }

        return $result;
    }

    /**
     * Convert new line delimited key = value pairs to array
     *
     * @param $string
     * @return array
     */
    public static function textareaToArray($string)
    {
        $result = [];

        foreach (explode("\n", $string) as $row) {
            $row = trim($row);
            if ($row != '' && strpos($row, '=') !== FALSE) {
                $items = explode('=', $row, 3);
                // support symbols which contain = (e.g. ZW=F)
                if (count($items) == 3) {
                    $result[$items[0] . '=' . $items[1]] = $items[2];
                } else {
                    $result[$items[0]] = $items[1];
                }
            }
        }

        return $result;
    }

    public static function recordInstallation()
    {
        wp_remote_post(Plugin::API_URL . Plugin::API_INSTALLATION_ENDPOINT, [
            'method'        => 'POST',
            'timeout'       => 10,
            'redirection'   => 5,
            'blocking'      => FALSE,
            'sslverify'     => FALSE,
            'headers'       => [
                'Content-type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'hash'      => Plugin::HASH,
                'version'   => Plugin::VERSION,
                'domain'    => site_url(),
                'info' => [
                    'php' => PHP_VERSION
                ]
            ]
        ]);
    }

    public static function unregister()
    {
        if ($id = get_option('smw_installation_id')) {
            wp_remote_post(Plugin::API_URL . Plugin::API_REMOVAL_ENDPOINT, [
                'method'        => 'POST',
                'timeout'       => 10,
                'redirection'   => 5,
                'blocking'      => FALSE,
                'sslverify'     => FALSE,
                'headers'       => [
                    'Content-type' => 'application/x-www-form-urlencoded'
                ],
                'body' => [
                    'domain'    => site_url(),
                    'hash'      => Plugin::HASH,
                    'hash2'     => $id,
                ]
            ]);
        }
    }
}
