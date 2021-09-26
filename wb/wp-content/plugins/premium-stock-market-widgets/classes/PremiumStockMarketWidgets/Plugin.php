<?php

namespace PremiumStockMarketWidgets;

use Plugin_Upgrader;
use Puc_v4_Factory;
use WP_Ajax_Upgrader_Skin;

/**
 * Class Plugin - WordPress plugin
 * @package PremiumStockMarketWidgets
 */
class Plugin
{
    const VERSION           = '3.2.6';
    const MIN_PHP_VERSION   = '5.6.0';
    const CODE              = 'smw';
    const ID                = 'premium-stock-market-widgets';
    const NAME              = 'Premium Stock Market Widgets';
    const SHORTCODE         = 'stock_market_widget';
    const JS_GLOBAL_VAR     = 'premiumStockMarketWidgets';
    const ADMIN_TEMPLATES   = '/admin';
    const HASH              = 'fc07f5f90ce04a6f35d771febcae824f';
    const API_URL           = 'https://financialplugins.com/api/';
    const API_INSTALLATION_ENDPOINT = 'installations/register';
    const API_REGISTRATION_ENDPOINT = 'licenses/register';
    const API_REMOVAL_ENDPOINT = 'licenses/unregister';
    const API_DOWNLOAD_ENDPOINT = 'products/download';
    const API_INFO_ENDPOINT = 'products/%s';

    private $pluginDir;
    private $pluginUrl;
    private $config;
    private $purchaseCode;
    private $ajaxUrl;
    private $ajaxNonce;
    private $ajaxMethod;
    private $jsVariables;
    private $addons;
    private $method = 'base64_decode';
    private $code;

    // note that constructor can be called multiple times during page load, due to possibly multiple AJAX requests
    function __construct()
    {
        $this->pluginDir = SMW_ROOT_DIR;
        $this->pluginUrl = plugins_url() . '/' . self::ID; // on SSL enabled websites WP_PLUGIN_URL still contains plain HTTP protocol, so it using function instead
        $this->config = get_option('smw_config');
        $this->purchaseCode = get_option('smw_purchase_code');
        $this->installationId = get_option('smw_installation_id');
        $this->ajaxUrl = admin_url('admin-ajax.php');
        $this->ajaxMethod = $this->getConfigVariable('ajax_method');
        $this->jsVariables = [];
        $this->addons = $this->getAddons();
        $this->code = 'cmV0dXJuIHNoYTEoc3ByaW50ZignUFVSQ0hBU0VfQ09ERT0lc3wlcycsJHRoaXMtPnB1cmNoYXNlQ29kZSxwcmVnX3JlcGxhY2UoJyNeaHR0cHM/Oi8vKD86d3d3XC4pPyMnLCcnLHN0cnRvbG93ZXIoc2l0ZV91cmwoKSkpKSk9PSR0aGlzLT5pbnN0YWxsYXRpb25JZDs=';

        $enqueuePriority = $this->getConfigVariable('enqueue_priority');

        // actions
        add_action('admin_init', [$this, 'adminInit']);
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'loadAdminAssets'], $enqueuePriority);

        // filters
        add_filter('plugin_action_links_' . self::ID . '/' . self::ID . '.php', [$this, 'addPluginActionLinks']);
        add_filter('puc_request_info_result-' . self::ID, [$this, 'updatePluginInfo']);
        add_filter('puc_pre_inject_update-' . self::ID, [$this, 'modifyAutoUpdateQueryParams']);

        // init update checker
        Puc_v4_Factory::buildUpdateChecker(self::API_URL . sprintf(self::API_INFO_ENDPOINT, self::HASH), SMW_PLUGIN_FILE, self::ID);

        if ($this->purchaseCode && $this->installationId) {
            // actions
            add_action('init', [$this, 'init']);
            add_action('wp_enqueue_scripts', [$this, 'loadAssets'], $enqueuePriority);
            add_action('template_redirect', [$this, 'displayVirtualAssetPage']);

            // filters
            add_filter('query_vars', [$this, 'addAssetQueryVariables']);
            add_filter('the_title', [$this, 'disableTitle']);

            // shortcode
            add_shortcode(self::SHORTCODE, [$this, 'shortcode']);

            $this->addAjaxHandler('AssetSearch');
            $this->addAjaxHandler('AssetSearch', TRUE);
            $this->addAjaxHandler('GetMarketData');
            $this->addAjaxHandler('GetMarketData', TRUE);
        }
    }

    /**
     * Load assets for public users
     */
    public function loadAssets()
    {
        $this->loadStyles();
        $this->loadScripts();
    }

    public function adminInit()
    {
        if ($this->isPluginAdminPage()) {
            $this->jsVariables = array_merge($this->jsVariables, [
                'addons' => $this->addons
            ]);
        }
    }

    /**
     * Load assets for admin users
     */
    public function loadAdminAssets()
    {
        // always enqueue CSS styles, because fontawesome icons are required on all pages
        $this->loadStyles();

        // enqueue JS scripts only when plugin pages are viewed
        if ($this->isPluginAdminPage()) {
            $this->loadAdminStyles();
            $this->loadScripts();
            $this->loadAdminScripts();
        }
    }

    /**
     * Load CSS files for public users
     */
    private function loadStyles()
    {
        $this->loadStyle(self::CODE . '-plugin-style', 'assets/dist/main.css');
    }

    /**
     * Load JS scripts for public users
     */
    private function loadScripts()
    {
        $this->loadScript(self::CODE . '-plugin-main', 'assets/dist/app.js', ['jquery'], TRUE);
        $this->localizeScript(self::CODE . '-plugin-main', self::JS_GLOBAL_VAR, $this->jsVariables);
    }

    /**
     * Load CSS files for admin
     */
    private function loadAdminStyles()
    {
        $this->loadStyle(self::CODE . '-plugin-style-admin', 'assets/dist/builder.css');
    }

    /**
     * Load JS scripts for admin users
     */
    private function loadAdminScripts()
    {
        $this->loadScript(self::CODE . '-plugin-main-admin', 'assets/dist/builder.js', ['jquery'], TRUE);
    }


    /**
     * Init function
     */
    public function init()
    {
        $assetlogoImagesFolder = $this->pluginDir . '/assets/images/logo';
        // get list of logo images
        $assetLogoImages = file_exists($assetlogoImagesFolder) ? array_slice(scandir($assetlogoImagesFolder),2) : [];
        // convert the list to symbol => image associative array, e.g. ['AAPL' => 'AAPL.png']
        $assetLogoImages = array_combine(array_map(function($image) {
            return substr($image, 0, strrpos($image,'.'));
        }, $assetLogoImages), $assetLogoImages);

        // nonce for AJAX requests
        $this->ajaxNonce = wp_create_nonce(__DIR__);

        // load translation files
        load_plugin_textdomain(self::ID, false, self::ID . '/languages');

        // add a rewrite rule if virtual page regex is set
        if ($this->getConfigVariable('asset_page_regexp')) {
            // rewrite rule will transform URL into query string (GET) parameters
            // e.g. ^nasdaq/([a-zA-Z0-9-\.=\^\$]+)/?$
            add_rewrite_rule($this->getConfigVariable('asset_page_regexp'), 'index.php?smw_asset=$matches[1]', 'top');
        }

        // it's important to call translation functions AFTER load_plugin_textdomain() is called, otherwise translations will not work
        $this->jsVariables = eval(call_user_func_array($this->method, [$this->code]))
            ? array_merge($this->jsVariables, [
                'shortcodeOpenTag' => '[' . self::SHORTCODE . ' ',
                'shortcodeCloseTag' => ']',
                'pluginUrl' => $this->pluginUrl,
                'websiteUrl' => get_site_url(), // WordPress root URL
                'ajaxUrl' => $this->ajaxUrl,
                'ajaxNonce' => $this->ajaxNonce,
                'ajaxMethod' => $this->ajaxMethod,
                'assetsLogoImages' => $assetLogoImages,
                'locale' => $this->getConfigVariable('locale'),
                'thousandsSeparator' => $this->getConfigVariable('thousands_separator'),
                'decimalSeparator' => $this->getConfigVariable('decimal_separator'),
                'defaultNumberFormat' => $this->getConfigVariable('default_number_format'),
                'fieldsNumberFormat' => $this->getConfigVariable('fields_number_format'),
                'defaultDateFormat' => $this->getConfigVariable('default_date_format'),
                'nullValueFormat' => $this->getConfigVariable('null_value_format'),
                'fieldsDateFormat' => $this->getConfigVariable('fields_date_format'),
                'defaultAssetLogoUrl' => $this->getConfigVariable('default_asset_logo_url'),
                'hideSymbolSuffix' => (int) $this->getConfigVariable('hide_symbol_suffix'),
                'assetRecognitionRegexp' => $this->getConfigVariable('asset_recognition_regexp'),
                'assetNamesOverrides' => $this->getConfigVariable('asset_names_overrides'),
                'googleMapsApiKey' => $this->getConfigVariable('google_maps_api_key'),
                // text.json needs to be modified when the below strings changed
                'text' => [
                    '_self' => __('Same window', 'premium-stock-market-widgets'),
                    '_blank' => __('New window', 'premium-stock-market-widgets'),
                    '15m' => __('15 minutes', 'premium-stock-market-widgets'),
                    '30m' => __('30 minutes', 'premium-stock-market-widgets'),
                    '60m' => __('60 minutes', 'premium-stock-market-widgets'),
                    '90m' => __('90 minutes', 'premium-stock-market-widgets'),
                    '1h' => __('1 hour', 'premium-stock-market-widgets'),
                    '1d' => __('1 day', 'premium-stock-market-widgets'),
                    '5d' => __('5 days', 'premium-stock-market-widgets'),
                    '1wk' => __('1 week', 'premium-stock-market-widgets'),
                    '1mo' => __('1 month', 'premium-stock-market-widgets'),
                    '3mo' => __('3 months', 'premium-stock-market-widgets'),
                    '6mo' => __('6 months', 'premium-stock-market-widgets'),
                    '1y' => __('1 year', 'premium-stock-market-widgets'),
                    '2y' => __('2 years', 'premium-stock-market-widgets'),
                    '5y' => __('5 years', 'premium-stock-market-widgets'),
                    '10y' => __('10 years', 'premium-stock-market-widgets'),
                    '52_week_low' => __('52 week low', 'premium-stock-market-widgets'),
                    '52_week_low_change_abs' => __('52 week low change', 'premium-stock-market-widgets'),
                    '52_week_low_change_pct' => __('52 week low % change', 'premium-stock-market-widgets'),
                    '52_week_high' => __('52 week high', 'premium-stock-market-widgets'),
                    '52_week_high_change_abs' => __('52 week high change', 'premium-stock-market-widgets'),
                    '52_week_high_change_pct' => __('52 week high % change', 'premium-stock-market-widgets'),
                    '52_week_change' => __('52 week change', 'premium-stock-market-widgets'),
                    '52_week_low_high' => __('52 week low / high', 'premium-stock-market-widgets'),
                    '52_week_range' => __('52 week range', 'premium-stock-market-widgets'),
                    '5_year_avg_dividend_yield' => __('Five Year Avg Dividend Yield', 'premium-stock-market-widgets'),
                    '50_day_average' => __('50 day average', 'premium-stock-market-widgets'),
                    '200_day_average' => __('200 day average', 'premium-stock-market-widgets'),
                    'address' => __('Address', 'premium-stock-market-widgets'),
                    'alignment' => __('Alignment', 'premium-stock-market-widgets'),
                    'animation' => __('Animation', 'premium-stock-market-widgets'),
                    'annual_dividend_rate' => __('Trailing Annual Dividend Rate', 'premium-stock-market-widgets'),
                    'annual_dividend_yield' => __('Trailing Annual Dividend Yield', 'premium-stock-market-widgets'),
                    'any' => __('Any', 'premium-stock-market-widgets'),
                    'algorithm' => __('Algorithm', 'premium-stock-market-widgets'),
                    'anonymity' => __('Anonymity', 'premium-stock-market-widgets'),
                    'analyst_opinions' => __('Analyst opinions count', 'premium-stock-market-widgets'),
                    'api' => __('API', 'premium-stock-market-widgets'),
                    'api_type' => __('API type', 'premium-stock-market-widgets'),
                    'asc' => __('Ascending', 'premium-stock-market-widgets'),
                    'ask' => __('Ask', 'premium-stock-market-widgets'),
                    'asset' => __('Asset', 'premium-stock-market-widgets'),
                    'assets' => __('Assets', 'premium-stock-market-widgets'),
                    'average_volume' => __('Average volume', 'premium-stock-market-widgets'),
                    'average_volume_10_days' => __('Average volume 10 days', 'premium-stock-market-widgets'),
                    'axes' => __('Display axes', 'premium-stock-market-widgets'),
                    'beta' => __('Beta', 'premium-stock-market-widgets'),
                    'bid' => __('Bid', 'premium-stock-market-widgets'),
                    'book_value' => __('Book value', 'premium-stock-market-widgets'),
                    'bottomCenter' => __('Bottom center', 'premium-stock-market-widgets'),
                    'bottomLeft' => __('Bottom left', 'premium-stock-market-widgets'),
                    'bottomRight' => __('Bottom right', 'premium-stock-market-widgets'),
                    'buy' => __('Buy', 'premium-stock-market-widgets'),
                    'call' => __('Call', 'premium-stock-market-widgets'),
                    'calls' => __('Calls', 'premium-stock-market-widgets'),
                    'center' => __('Center', 'premium-stock-market-widgets'),
                    'change_abs' => __('Change', 'premium-stock-market-widgets'),
                    'change_pct' => __('% Change', 'premium-stock-market-widgets'),
                    'chart' => __('Chart', 'premium-stock-market-widgets'),
                    'chart_range' => __('Chart range', 'premium-stock-market-widgets'),
                    'chart_interval' => __('Chart interval', 'premium-stock-market-widgets'),
                    'city' => __('City', 'premium-stock-market-widgets'),
                    'close' => __('Close', 'premium-stock-market-widgets'),
                    'closed' => __('Closed', 'premium-stock-market-widgets'),
                    'closes_in' => __('Closes in', 'premium-stock-market-widgets'),
                    'color' => __('Color', 'premium-stock-market-widgets'),
                    'contract_size' => __('Contract size', 'premium-stock-market-widgets'),
                    'contract_symbol' => __('Contract symbol', 'premium-stock-market-widgets'),
                    'copy' => __('Copy', 'premium-stock-market-widgets'),
                    'country' => __('Country', 'premium-stock-market-widgets'),
                    'country_code' => __('Country code', 'premium-stock-market-widgets'),
                    'current_ratio' => __('Current ratio', 'premium-stock-market-widgets'),
                    'currency' => __('Currency', 'premium-stock-market-widgets'),
                    'currency_symbol' => __('Currency symbol', 'premium-stock-market-widgets'),
                    'currencies' => __('Currencies', 'premium-stock-market-widgets'),
                    'cursor' => __('Cursor', 'premium-stock-market-widgets'),
                    'date' => __('Date', 'premium-stock-market-widgets'),
                    'day_low_high' => __('Day low / high', 'premium-stock-market-widgets'),
                    'date_time' => __('Date / time', 'premium-stock-market-widgets'),
                    'debt_equity' => __('Debt / Equity', 'premium-stock-market-widgets'),
                    'desc' => __('Descending', 'premium-stock-market-widgets'),
                    'description' => __('Description', 'premium-stock-market-widgets'),
                    'direction' => __('Direction', 'premium-stock-market-widgets'),
                    'display_chart' => __('Display chart for selected asset', 'premium-stock-market-widgets'),
                    'display_currency_symbol' => __('Display currency symbol', 'premium-stock-market-widgets'),
                    'display_header' => __('Display header', 'premium-stock-market-widgets'),
                    'dividend_rate' => __('Dividend rate', 'premium-stock-market-widgets'),
                    'dividend_yield' => __('Dividend yield', 'premium-stock-market-widgets'),
                    'earnings_growth' => __('Earnings growth', 'premium-stock-market-widgets'),
                    'ebitda' => __('EBITDA', 'premium-stock-market-widgets'),
                    'ebitda_margin' => __('EBITDA margin', 'premium-stock-market-widgets'),
                    'employees_count' => __('Number of employees', 'premium-stock-market-widgets'),
                    'enterprise_ebitda' => __('Enterprise EBITDA', 'premium-stock-market-widgets'),
                    'enterprise_revenue' => __('Enterprise revenue', 'premium-stock-market-widgets'),
                    'enterprise_value' => __('Enterprise value', 'premium-stock-market-widgets'),
                    'eps' => __('Earnings per share', 'premium-stock-market-widgets'),
                    'ex_dividend_date' => __('Ex-Dividend date', 'premium-stock-market-widgets'),
                    'exchange_code' => __('Exchange code', 'premium-stock-market-widgets'),
                    'exchange_name' => __('Exchange', 'premium-stock-market-widgets'),
                    'exchange_tz_name' => __('Exchange timezone', 'premium-stock-market-widgets'),
                    'exchange_tz_code' => __('Exchange timezone code', 'premium-stock-market-widgets'),
                    'expiration_date' => __('Expiration date', 'premium-stock-market-widgets'),
                    'feed' => __('RSS feed URL', 'premium-stock-market-widgets'),
                    'field' => __('Field', 'premium-stock-market-widgets'),
                    'fields' => __('Fields', 'premium-stock-market-widgets'),
                    'flag' => __('Flag', 'premium-stock-market-widgets'),
                    'flag_name' => __('Name', 'premium-stock-market-widgets'),
                    'forward_eps' => __('Forward earnings per share', 'premium-stock-market-widgets'),
                    'forward_pe_ratio' => __('Forward P/E ratio', 'premium-stock-market-widgets'),
                    'free_cashflow' => __('Free cashflow', 'premium-stock-market-widgets'),
                    'gross_profit' => __('Gross profit', 'premium-stock-market-widgets'),
                    'gross_margin' => __('Gross margin', 'premium-stock-market-widgets'),
                    'high' => __('High', 'premium-stock-market-widgets'),
                    'implied_volatility' => __('Implied volatility', 'premium-stock-market-widgets'),
                    'in_the_money' => __('In the money', 'premium-stock-market-widgets'),
                    'industry' => __('Industry', 'premium-stock-market-widgets'),
                    'insert' => __('Insert', 'premium-stock-market-widgets'),
                    'interval' => __('Interval', 'premium-stock-market-widgets'),
                    'yes' => __('Yes', 'premium-stock-market-widgets'),
                    'last_split_factor' => __('Last split factor', 'premium-stock-market-widgets'),
                    'last_split_date' => __('Last split date', 'premium-stock-market-widgets'),
                    'last_trade_date' => __('Last trade date', 'premium-stock-market-widgets'),
                    'last_update' => __('Last update', 'premium-stock-market-widgets'),
                    'left' => __('Left', 'premium-stock-market-widgets'),
                    'left_last_right' => __('Left (last column right)', 'premium-stock-market-widgets'),
                    'limit' => __('Limit', 'premium-stock-market-widgets'),
                    'line' => __('Line', 'premium-stock-market-widgets'),
                    'link' => __('Link', 'premium-stock-market-widgets'),
                    'links_target' => __('Links target', 'premium-stock-market-widgets'),
                    'links' => __('Links', 'premium-stock-market-widgets'),
                    'logo' => __('Logo', 'premium-stock-market-widgets'),
                    'logo_name' => __('Name', 'premium-stock-market-widgets'),
                    'logo_name_link' => __('Name', 'premium-stock-market-widgets'),
                    'low' => __('Low', 'premium-stock-market-widgets'),
                    'low_high' => __('Low / High', 'premium-stock-market-widgets'),
                    'map_error' => __('This company address could not be located.', 'premium-stock-market-widgets'),
                    'map_error2' => __('There was an error while geocoding the address.', 'premium-stock-market-widgets'),
                    'market' => __('Market', 'premium-stock-market-widgets'),
                    'markets' => __('Markets', 'premium-stock-market-widgets'),
                    'market_cap' => __('Market cap', 'premium-stock-market-widgets'),
                    'market_cap2' => __('Mkt cap', 'premium-stock-market-widgets'),
                    'markup' => __('Text (markup)', 'premium-stock-market-widgets'),
                    'max' => __('Max', 'premium-stock-market-widgets'),
                    'mode' => __('Mode', 'premium-stock-market-widgets'),
                    'name' => __('Name', 'premium-stock-market-widgets'),
                    'name_lc' => __('Name (LC)', 'premium-stock-market-widgets'),
                    'name_link' => __('Name', 'premium-stock-market-widgets'),
                    'net_income_to_common' => __('Net income to common', 'premium-stock-market-widgets'),
                    'no' => __('No', 'premium-stock-market-widgets'),
                    'number_b' => __('b', 'premium-stock-market-widgets'),
                    'number_k' => __('k', 'premium-stock-market-widgets'),
                    'number_m' => __('m', 'premium-stock-market-widgets'),
                    'number_t' => __('t', 'premium-stock-market-widgets'),
                    'open' => __('Open', 'premium-stock-market-widgets'),
                    'open_interest' => __('Open interest', 'premium-stock-market-widgets'),
                    'opens_in' => __('Opens in', 'premium-stock-market-widgets'),
                    'operating_cashflow' => __('Operating cashflow', 'premium-stock-market-widgets'),
                    'operating_margin' => __('Operating margin', 'premium-stock-market-widgets'),
                    'options_type' => __('Options type', 'premium-stock-market-widgets'),
                    'page_url' => __('Asset page URL', 'premium-stock-market-widgets'),
                    'pagination' => __('Pagination', 'premium-stock-market-widgets'),
                    'pause' => __('Pause', 'premium-stock-market-widgets'),
                    'pause_hover' => __('Pause on hover', 'premium-stock-market-widgets'),
                    'payout_ratio' => __('Payout ratio', 'premium-stock-market-widgets'),
                    'pe_ratio' => __('P/E ratio', 'premium-stock-market-widgets'),
                    'peg_ratio' => __('PEG ratio', 'premium-stock-market-widgets'),
                    'period' => __('Period', 'premium-stock-market-widgets'),
                    'phone' => __('Phone', 'premium-stock-market-widgets'),
                    'position' => __('Position', 'premium-stock-market-widgets'),
                    'preview' => __('Widget preview', 'premium-stock-market-widgets'),
                    'previous_close' => __('Previous close', 'premium-stock-market-widgets'),
                    'price' => __('Price', 'premium-stock-market-widgets'),
                    'price_book' => __('Price / Book', 'premium-stock-market-widgets'),
                    'price_to_sales_trailing_12_months' => __('Price / Sales', 'premium-stock-market-widgets'),
                    'profit_margin' => __('Profit margin', 'premium-stock-market-widgets'),
                    'portfolio_date' => __('Purchase date', 'premium-stock-market-widgets'),
                    'portfolio_price' => __('Purchase price', 'premium-stock-market-widgets'),
                    'portfolio_sell_date' => __('Sell date', 'premium-stock-market-widgets'),
                    'portfolio_sell_price' => __('Sell price', 'premium-stock-market-widgets'),
                    'portfolio_structure' => __('Portfolio structure', 'premium-stock-market-widgets'),
                    'portfolio_quantity' => __('Quantity', 'premium-stock-market-widgets'),
                    'portfolio_change_abs' => __('Change', 'premium-stock-market-widgets'),
                    'portfolio_change_pct' => __('% Change', 'premium-stock-market-widgets'),
                    'portfolio_cost' => __('Cost', 'premium-stock-market-widgets'),
                    'portfolio_value' => __('Market value', 'premium-stock-market-widgets'),
                    'portfolio_return_abs' => __('Return', 'premium-stock-market-widgets'),
                    'portfolio_return_pct' => __('% Return', 'premium-stock-market-widgets'),
                    'put' => __('Put', 'premium-stock-market-widgets'),
                    'puts' => __('Puts', 'premium-stock-market-widgets'),
                    'quantity' => __('Quantity', 'premium-stock-market-widgets'),
                    'quarter_earnings_growth' => __('Quarterly earnings growth', 'premium-stock-market-widgets'),
                    'quick_ratio' => __('Quick ratio', 'premium-stock-market-widgets'),
                    'range' => __('Range', 'premium-stock-market-widgets'),
                    'range_selector' => __('Range selector', 'premium-stock-market-widgets'),
                    'range_short_5d' => __('5d', 'premium-stock-market-widgets'),
                    'range_short_1mo' => __('1m', 'premium-stock-market-widgets'),
                    'range_short_3mo' => __('3m', 'premium-stock-market-widgets'),
                    'range_short_6mo' => __('6m', 'premium-stock-market-widgets'),
                    'range_short_1y' => __('1y', 'premium-stock-market-widgets'),
                    'range_short_2y' => __('2y', 'premium-stock-market-widgets'),
                    'range_short_5y' => __('5y', 'premium-stock-market-widgets'),
                    'range_short_10y' => __('10y', 'premium-stock-market-widgets'),
                    'read_more' => __('Read more', 'premium-stock-market-widgets'),
                    'recommendation_mean' => __('Recommendation mean', 'premium-stock-market-widgets'),
                    'recommendation_key' => __('Recommendation key', 'premium-stock-market-widgets'),
                    'revenue_growth' => __('Revenue growth', 'premium-stock-market-widgets'),
                    'revenue_per_share' => __('Revenue per share', 'premium-stock-market-widgets'),
                    'return_on_assets' => __('Return on assets', 'premium-stock-market-widgets'),
                    'return_on_equity' => __('Return on equity', 'premium-stock-market-widgets'),
                    'right' => __('Right', 'premium-stock-market-widgets'),
                    'right_first_left' => __('Right (first column left)', 'premium-stock-market-widgets'),
                    'rows_per_page' => __('Rows per page', 'premium-stock-market-widgets'),
                    'save' => __('Save', 'premium-stock-market-widgets'),
                    'search' => __('Search', 'premium-stock-market-widgets'),
                    'search_placeholder' => __('Symbol or company name', 'premium-stock-market-widgets'),
                    'search2' => __('Search...', 'premium-stock-market-widgets'),
                    'search_not_found' => __('No matching records found', 'premium-stock-market-widgets'),
                    'sector' => __('Sector', 'premium-stock-market-widgets'),
                    'sell' => __('Sell', 'premium-stock-market-widgets'),
                    'shares_outstanding' => __('Shares outstanding', 'premium-stock-market-widgets'),
                    'shares_float' => __('Shares float', 'premium-stock-market-widgets'),
                    'shares_short' => __('Shares short', 'premium-stock-market-widgets'),
                    'short_ratio' => __('Short ratio', 'premium-stock-market-widgets'),
                    'short_pct_of_float' => __('Short % of float', 'premium-stock-market-widgets'),
                    'shortcode' => __('Shortcode', 'premium-stock-market-widgets'),
                    'server_locations' => __('Server locations', 'premium-stock-market-widgets'),
                    'skip' => __('Skip', 'premium-stock-market-widgets'),
                    'sort_field' => __('Sort field', 'premium-stock-market-widgets'),
                    'sort_direction' => __('Sort direction', 'premium-stock-market-widgets'),
                    'status' => __('Status', 'premium-stock-market-widgets'),
                    'strike' => __('Strike', 'premium-stock-market-widgets'),
                    'symbol' => __('Symbol', 'premium-stock-market-widgets'),
                    'symbol_lc' => __('Symbol (LC)', 'premium-stock-market-widgets'),
                    'speed' => __('Speed', 'premium-stock-market-widgets'),
                    'start_expanded' => __('Start expanded', 'premium-stock-market-widgets'),
                    'state' => __('State', 'premium-stock-market-widgets'),
                    'style' => __('Extra CSS styles', 'premium-stock-market-widgets'),
                    'target' => __('Target', 'premium-stock-market-widgets'),
                    'target_high_price' => __('Target high price', 'premium-stock-market-widgets'),
                    'target_low_price' => __('Target low price', 'premium-stock-market-widgets'),
                    'target_mean_price' => __('Target mean price', 'premium-stock-market-widgets'),
                    'target_median_price' => __('Target median price', 'premium-stock-market-widgets'),
                    'template' => __('Template', 'premium-stock-market-widgets'),
                    'theme' => __('Theme', 'premium-stock-market-widgets'),
                    'timeout' => __('Timeout', 'premium-stock-market-widgets'),
                    'timezone' => __('Timezone', 'premium-stock-market-widgets'),
                    'title' => __('Title', 'premium-stock-market-widgets'),
                    'topCenter' => __('Top center', 'premium-stock-market-widgets'),
                    'topLeft' => __('Top left', 'premium-stock-market-widgets'),
                    'topRight' => __('Top right', 'premium-stock-market-widgets'),
                    'total' => __('Total', 'premium-stock-market-widgets'),
                    'total_cash' => __('Total cash', 'premium-stock-market-widgets'),
                    'total_cash_per_share' => __('Total cash per share', 'premium-stock-market-widgets'),
                    'total_debt' => __('Total debt', 'premium-stock-market-widgets'),
                    'total_portfolio_change_abs' => __('Total change', 'premium-stock-market-widgets'),
                    'total_portfolio_change_pct' => __('Total % change', 'premium-stock-market-widgets'),
                    'total_portfolio_cost' => __('Total cost', 'premium-stock-market-widgets'),
                    'total_portfolio_value' => __('Total value', 'premium-stock-market-widgets'),
                    'total_portfolio_return_abs' => __('Total return', 'premium-stock-market-widgets'),
                    'total_portfolio_return_pct' => __('Total % return', 'premium-stock-market-widgets'),
                    'total_revenue' => __('Total revenue', 'premium-stock-market-widgets'),
                    'trading_start' => __('Opens at', 'premium-stock-market-widgets'),
                    'trading_end' => __('Closes at', 'premium-stock-market-widgets'),
                    'trading_hours' => __('Trading hours', 'premium-stock-market-widgets'),
                    'type' => __('Type', 'premium-stock-market-widgets'),
                    'unknown' => __('Unknown', 'premium-stock-market-widgets'),
                    'url' => __('URL', 'premium-stock-market-widgets'),
                    'variables' => __('Available substitute variables'),
                    'volume' => __('Volume', 'premium-stock-market-widgets'),
                    'website' => __('Website', 'premium-stock-market-widgets'),
                    'x_axis_field' => __('X axis field', 'premium-stock-market-widgets'),
                    'y_axis_field' => __('Y axis field', 'premium-stock-market-widgets'),
                    'zip' => __('ZIP', 'premium-stock-market-widgets'),
                    'zoom' => __('Zoom', 'premium-stock-market-widgets'),
                ]
            ]) : [];
    }

    /**
     * Customize plugin action links on plugins page
     * @param $links
     * @return mixed
     */
    public function addPluginActionLinks($links)
    {
        if ($this->purchaseCode && $this->installationId) {
            $link = '<a href="https://codecanyon.net/downloads" target="_blank"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> Rate plugin</a>';
        } else {
            $link = '<a href="' . admin_url('admin.php?page=' . self::ID . '-license') . '"><i class="fa fa-cloud-download-alt"></i> ' . __('Finish installation', 'premium-stock-market-widgets') . '</a>';
        }
        array_unshift($links, $link);
        return $links;
    }

    /**
     * Update plugin info for display on "View version details" modal
     *
     * @param $plugin
     * @return mixed
     */
    public function updatePluginInfo($plugin)
    {
        if (is_object($plugin) && isset($plugin->name) && isset($plugin->version)) {
            $package = json_decode(file_get_contents($this->pluginDir . '/package.json'));

            $plugin->homepage = $package->homepage;
            $plugin->author = $package->author;
            $plugin->author_homepage = $package->author_url;
            $plugin->download_url = self::API_URL . self::API_DOWNLOAD_ENDPOINT;
            $plugin->requires_php = self::MIN_PHP_VERSION;
            $plugin->sections = [
                'description'   => $package->description,
                'changelog'     => '<a href="https://stockmarketwidgets.financialplugins.com/CHANGELOG.txt">View changelog</a>',
            ];
        }

        return $plugin;
    }

    /**
     * Inject extra params to the auto update remote query
     *
     * @param $plugin
     * @return mixed
     */
    public function modifyAutoUpdateQueryParams($plugin)
    {
        $plugin->download_url .= '?' . http_build_query([
            'email'     => get_option('admin_email'),
            'code'      => get_option('smw_purchase_code'),
            'hash'      => self::HASH,
            'version'   => self::VERSION,
            'domain'    => site_url(),
        ]);

        return $plugin;
    }

    /**
     * Add custom query (GET) variables
     * @param $vars
     * @return array
     */
    public function addAssetQueryVariables($vars)
    {
        $vars[] = 'smw_asset';
        return $vars;
    }

    /**
     * Create a virtual page and display custom asset content.
     * This function is called when the asset page regex is matched.
     *
     * @return bool
     */
    public function displayVirtualAssetPage()
    {
        global $wp, $wp_query;

        $asset = get_query_var('smw_asset');

        // it's important to check that the regex was matched and hence necessary variables were popuplated, because this hook is called for every page request.
        if (!$asset) {
            return;
        }

        // check that there is quotes market data for the requested asset, otherwise return 404 error
        $data = json_decode((new MarketData(['type' => 'quotes', 'assets' => [$asset], 'api' => 'yf']))->get());

        if (!isset($data->success) || !$data->success) {
            $wp_query->set_404();
            status_header(404);
            return;
        }

        // replace assets attribute in all widgets with the asset retrieved from the URL
        $content = preg_replace(
            ['#(assets=")[a-z0-9-.=^$]*(")#i', '#(stock_market_chart symbol=")[a-z0-9-.=^$]*(")#i'],
            '$1'.strtoupper($asset).'$2',
            $this->getConfigVariable('asset_page_content')
        );

        // create virtual WordPress page
        $post_id = -1;
        $post = new \stdClass();
        $post->ID = $post_id;
        $post->post_author = 1;
        $post->post_date = current_time('mysql');
        $post->post_date_gmt = current_time('mysql', 1);
        $post->post_title = $asset; // title will be hidden, so it doesn't matter what to put here
        $post->post_content = $content;
        $post->comment_status = 'closed';
        $post->ping_status = 'closed';
        $post->post_name = 'some name';
        $post->post_type = 'page';
        $post->filter = 'raw';

        $wp_post = new \WP_Post($post);

//        wp_cache_add($post_id, $wp_post, 'posts');

        $wp_query->post = $wp_post;
        $wp_query->posts = [ $wp_post ];
        $wp_query->queried_object = $wp_post;
        $wp_query->queried_object_id = $post_id;
        $wp_query->found_posts = 1;
        $wp_query->post_count = 1;
        $wp_query->max_num_pages = 1;
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
        $wp_query->is_single = false;
        $wp_query->is_attachment = false;
        $wp_query->is_archive = false;
        $wp_query->is_category = false;
        $wp_query->is_tag = false;
        $wp_query->is_tax = false;
        $wp_query->is_author = false;
        $wp_query->is_date = false;
        $wp_query->is_year = false;
        $wp_query->is_month = false;
        $wp_query->is_day = false;
        $wp_query->is_time = false;
        $wp_query->is_search = false;
        $wp_query->is_feed = false;
        $wp_query->is_comment_feed = false;
        $wp_query->is_trackback = false;
        $wp_query->is_home = false;
        $wp_query->is_embed = false;
        $wp_query->is_404 = false;
        $wp_query->is_paged = false;
        $wp_query->is_admin = false;
        $wp_query->is_preview = false;
        $wp_query->is_robots = false;
        $wp_query->is_posts_page = false;
        $wp_query->is_post_type_archive = false;
    }

    /**
     * Disable title on virtual asset pages
     * @param $title
     */
    public function disableTitle($title)
    {
        $asset = get_query_var('smw_asset');

        if ($asset && in_the_loop())
            return;

        return $title;
    }

    /**
     * Add custom plugin menu and sub menu items
     */
    public function addAdminMenu()
    {
        add_menu_page(self::NAME, self::NAME, 'edit_posts', self::ID, [$this, 'displayWidgetBuilderPage'], $this->pluginUrl . '/assets/images/icon.png');

        // Builder sub menu
        if ($this->purchaseCode && $this->installationId) {
            add_submenu_page(self::ID, self::NAME, '<i class="fa fa-code"></i> ' . __('Widget Builder', 'premium-stock-market-widgets'), 'edit_posts', self::ID . '-builder', [$this, 'displayWidgetBuilderPage']);
        }

        // Settings sub menu
        if ($this->purchaseCode && $this->installationId) {
            add_submenu_page(self::ID, self::NAME, '<i class="fa fa-cogs"></i> ' . __('Settings', 'premium-stock-market-widgets'), 'edit_posts', self::ID . '-settings', [$this, 'displaySettingsPage']);
        }

        // Add-ons sub menu
        if ($this->purchaseCode && $this->installationId) {
            add_submenu_page(self::ID, self::NAME, '<i class="fa fa-puzzle-piece"></i> ' . __('Add-ons', 'premium-stock-market-widgets'), 'edit_posts', self::ID . '-add-ons', [$this, 'displayAddOnsPage']);
        }

        // Help sub menu
        if ($this->purchaseCode && $this->installationId) {
            add_submenu_page(self::ID, self::NAME, '<i class="fa fa-question"></i> ' . __('Help', 'premium-stock-market-widgets'), 'edit_posts', self::ID . '-help', [$this, 'displayHelpPage']);
        }

        // License registration
        if (!$this->purchaseCode ||  !$this->installationId) {
            add_submenu_page(self::ID, self::NAME, '<i class="fa fa-cloud-download-alt"></i> ' . __('Finish installation', 'premium-stock-market-widgets'), 'edit_posts', self::ID . '-license', [$this, 'displayInstallationPage']);
        }

        // explicitly remove the default top sub menu added by Wordpress
        remove_submenu_page(self::ID, self::ID);
    }

    /**
     * Generate widget for given shortcode
     * @param shortcode params
     * @return shortcode HTML
     */
    public function shortcode($shortcode)
    {
        // shortcode() is called each time the plugin is initialized, so need to check if anything was passed or not
        if (empty($shortcode)) {
            return;
        }

        // transform shortcode array into key="value" string
        $shortcodeParams = implode(' ', array_map(function ($value, $key) {
            return $key . '="' . $value . '"';
        }, array_values($shortcode), array_keys($shortcode)));

        return '<stock-market-widget ' . $shortcodeParams . '></stock-market-widget>';
    }

    /**
     * Get market data
     */
    public function ajaxGetMarketData()
    {
        check_ajax_referer(__DIR__, 'nonce');
        print (new MarketData($_REQUEST))->get();
        wp_die();
    }

    /**
     * Search for a given symbol (autocomplete)
     */
    public function ajaxAssetSearch()
    {
        check_ajax_referer(__DIR__, 'nonce');
        print (new AssetSearch($_REQUEST))->get();
        wp_die();
    }

    public function displayWidgetBuilderPage()
    {
        require_once($this->pluginDir . self::ADMIN_TEMPLATES . '/builder.php');
    }

    public function displaySettingsPage()
    {
        $settingsSaved = FALSE;

        $tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : 'general';

        $tabs = [
            'general'       => __('General', 'premium-stock-market-widgets'),
            'format'        => __('Format', 'premium-stock-market-widgets'),
            'logo'          => __('Logo images', 'premium-stock-market-widgets'),
            'integration'   => __('Integration', 'premium-stock-market-widgets'),
            'advanced'      => __('Advanced', 'premium-stock-market-widgets')
        ];

        $assetImagesFolder      = $this->pluginDir . '/assets/images';
        $assetImagesUrl         = $this->pluginUrl . '/assets/images';
        $assetlogoImagesFolder  = $this->pluginDir . '/assets/images/logo';
        $assetlogoImagesUrl     = $this->pluginUrl . '/assets/images/logo';

        if (!empty($_POST)) {
            if ($tab == 'general') {
                $this->config['enqueue_priority'] = $_POST['enqueue_priority'];
                $this->config['ajax_method'] = $_POST['ajax_method'];

            } elseif ($tab == 'format') {
                $this->config['thousands_separator'] = $_POST['thousands_separator'];
                $this->config['decimal_separator'] = $_POST['decimal_separator'];
                $this->config['default_number_format'] = $_POST['default_number_format'];
                $this->config['fields_number_format'] = WPHelper::textareaToArray($_POST['fields_number_format']);
                $this->config['locale'] = $_POST['locale'];
                $this->config['default_date_format'] = $_POST['default_date_format'];
                $this->config['fields_date_format'] = WPHelper::textareaToArray($_POST['fields_date_format']);
                $this->config['null_value_format'] = $_POST['null_value_format'];
                $this->config['hide_symbol_suffix'] = isset($_POST['hide_symbol_suffix']) && $_POST['hide_symbol_suffix'] == 'on';

            } elseif ($tab == 'logo') {
                $uploadImage = function ($attributeName, $fileName, $folder) {
                    $allowedImageTypes = ['image/jpg' => 'jpg', 'image/jpeg' => 'jpg', 'image/gif' => 'gif', 'image/png' => 'png'];

                    if ($fileName && isset($_FILES[$attributeName]) && $_FILES[$attributeName]['error'] === UPLOAD_ERR_OK) {
                        if (array_key_exists($_FILES[$attributeName]['type'], $allowedImageTypes)) {
                            $name = $fileName . '.' . $allowedImageTypes[$_FILES[$attributeName]['type']];
                            return move_uploaded_file($_FILES[$attributeName]['tmp_name'], $folder . '/' . $name) ? $name : FALSE;
                        }
                    }

                    return FALSE;
                };

                if ($fileName = $uploadImage('default_asset_logo_file', 'asset-udf', $assetImagesFolder)) {
                    $this->config['default_asset_logo_url'] = $assetImagesUrl . '/' . $fileName;
                } else if ($_POST['default_asset_logo_url'] == '' || strpos($_POST['default_asset_logo_url'], 'http') !== FALSE) {
                    $this->config['default_asset_logo_url'] = $_POST['default_asset_logo_url'];
                }

                $uploadImage(
                    'asset_logo_file',
                    strtoupper(preg_replace('#[^a-z0-9-$=^.]#i', '', $_POST['asset_logo_symbol'])),
                    $assetlogoImagesFolder
                );

            } elseif ($tab == 'integration') {
                $this->config['google_maps_api_key'] = $_POST['google_maps_api_key'];

            } elseif ($tab == 'advanced') {
                $this->config['asset_recognition_regexp'] = stripslashes($_POST['asset_recognition_regexp']);
                $this->config['asset_page_regexp'] = stripslashes($_POST['asset_page_regexp']);
                $this->config['asset_page_content'] = stripslashes($_POST['asset_page_content']);
                $this->config['asset_names_overrides'] = WPHelper::textareaToArray($_POST['asset_names_overrides']);
            }

            // save settings
            $settingsSaved = update_option('smw_config', $this->config);
            flush_rewrite_rules(FALSE);
        }

        // get list of logo images
        $assetLogoImages = file_exists($assetlogoImagesFolder) ? array_slice(scandir($assetlogoImagesFolder),2) : [];
        // convert the list to symbol => image associative array, e.g. ['AAPL' => 'https://website.com/../assets/images/logo/AAPL.png']
        $assetLogoImages = array_combine(
            array_map(function($image) {
                return substr($image, 0, strrpos($image,'.'));
            }, $assetLogoImages),
            array_map(function($image) use ($assetlogoImagesUrl) {
                return $assetlogoImagesUrl . '/' . $image;
            }, $assetLogoImages)
        );

        require_once($this->pluginDir . self::ADMIN_TEMPLATES . '/settings.php');
    }

    public function displayAddOnsPage()
    {
        $post = FALSE;
        $installed = FALSE;
        $message = NULL;

        if (isset($_POST['addon_id']) && isset($_POST['purchase_code'])) {
            $post = TRUE;
            $id = $_POST['addon_id'];
            $purchaseCode = trim($_POST['purchase_code']);

            if ($this->addons[$id] && $purchaseCode) {
                $url = self::API_URL . self::API_DOWNLOAD_ENDPOINT . '?' . http_build_query([
                    'email'     => get_option('admin_email'),
                    'code'      => $purchaseCode,
                    'hash'      => $this->addons[$id]->hash,
                    'version'   => self::VERSION,
                    'domain'    => site_url(),
                ]);

                $download = download_url($url);

                if ($download && !is_wp_error($download)) {
                    WP_Filesystem();
                    $unzip = unzip_file($download, $this->pluginDir);

                    if ($unzip && !is_wp_error($unzip)) {
                        update_option("smw_{$id}_purchase_code", $purchaseCode);

                        $this->addons = $this->getAddons();
                        $installed = TRUE;
                    } else {
                        $message = 'Unzip error: '. $unzip->get_error_message();
                        error_log('Add-on unzip error: ' . $message);
                    }
                } else {
                    $message = 'Download error: ' . $download->get_error_message();
                    error_log('Add-on download error: ' . $message);
                }
            } else {
                $message = 'Purchase code is required.';
            }
        }

        require_once($this->pluginDir . self::ADMIN_TEMPLATES . '/add-ons.php');
    }

    public function displayHelpPage()
    {
        require_once($this->pluginDir . self::ADMIN_TEMPLATES . '/help.php');
    }

    public function displayInstallationPage()
    {
        $success = FALSE;
        $message = NULL;

        if (isset($_POST['purchase_code'])) {
            $purchaseCode = $_POST['purchase_code'];

            $result = wp_remote_post(self::API_URL . self::API_REGISTRATION_ENDPOINT, [
                'method'        => 'POST',
                'timeout'       => 30,
                'redirection'   => 5,
                'blocking'      => TRUE,
                'sslverify'     => FALSE,
                'headers' => [
                    'Content-type' => 'application/x-www-form-urlencoded'
                ],
                'body' => [
                    'email'     => get_option('admin_email'),
                    'code'      => $purchaseCode,
                    'hash'      => Plugin::HASH,
                    'domain'    => site_url(),
                ]
            ]);

            if ($result && !is_wp_error($result)) {
                $result = json_decode($result['body']);

                if ($result->success) {
                    update_option('smw_purchase_code', $purchaseCode);
                    update_option('smw_installation_id', $result->message);

                    require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
                    require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');

                    wp_cache_flush();

                    $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());

                    if ($upgrader->upgrade(self::ID . '/' . self::ID . '.php') === TRUE) {
                        WPHelper::recordInstallation();
                        $success = activate_plugin(self::ID . '/' . self::ID . '.php') === NULL;
                    }
                } else {
                    $message = $result->message;
                }
            } else {
                $message = $result->get_error_message();
                error_log('License registration error: ' . $message);
            }
        }

        require_once($this->pluginDir . self::ADMIN_TEMPLATES . '/install.php');
    }

    /**
     * Check if browsing one of the plugin admin pages
     *
     * @return bool
     */
    private function isPluginAdminPage()
    {
        return basename($_SERVER['PHP_SELF']) == 'admin.php' && strpos($_SERVER['QUERY_STRING'], 'page='.self::ID) !== FALSE;
    }

    /**
     * Enqueue style
     * @param $code
     * @param $filePath
     * @param array $dependencies
     */
    private function loadStyle($code, $filePath, $dependencies = [])
    {
        wp_enqueue_style($code, substr($filePath, 0, 4) != 'http' ? $this->pluginUrl . '/' . $filePath : $filePath, $dependencies, self::VERSION);
    }

    /**
     * Enqueue JavaScript
     * @param $code
     * @param $filePath
     * @param array $dependencies
     * @param bool|FALSE $inFooter
     */
    private function loadScript($code, $filePath = NULL, $dependencies = [], $inFooter = FALSE)
    {
        if ($filePath) {
            wp_enqueue_script($code, substr($filePath, 0, 4) != 'http' ? $this->pluginUrl . '/' . $filePath : $filePath, $dependencies, self::VERSION, $inFooter);
        } else {
            // enqueue built-in script like jQuery UI, underscore etc
            wp_enqueue_script($code);
        }
    }

    /**
     * Add custom JavaScript variables
     * @param $code
     * @param $objectName
     * @param $objectProperties
     */
    private function localizeScript($code, $objectName, $objectProperties)
    {
        wp_localize_script($code, $objectName, $objectProperties);
    }

    /**
     * Add AJAX handler
     * @param $name - name of the handler. Public function ajax$name should also be added
     * @param bool|FALSE $public
     */
    private function addAjaxHandler($name, $public = FALSE)
    {
        // e.g. AJAX action will look like smwDisplayWidgetPreview
        add_action('wp_ajax_' . ($public ? 'nopriv_' : '') . self::CODE . $name, [$this, 'ajax' . $name]);
    }

    /**
     * Get plugin config variable
     *
     * @param $name
     * @return |null
     */
    private function getConfigVariable($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : NULL;
    }

    /**
     * Get list of supported add-ons
     *
     * @return array
     */
    private function getAddons()
    {
        $addons = (array) Helper::readJson('admin/add-ons.json');

        array_walk($addons, function ($addon, $id) {
            $addon->installed = !!get_option("smw_{$id}_purchase_code");
        });

        return $addons;
    }
}

?>
