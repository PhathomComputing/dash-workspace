<?php
/**
 * Plugin Name: Premium Stock Market Widgets
 * Description: Premium Stock Market Widgets plugin provides an easy way to add various financial data widgets to your website.
 * Text Domain: premium-stock-market-widgets
 * Version: 3.2.6
 * Author: Financial apps and plugins <info@financialplugins.com>
 * Author URI: https://financialplugins.com/
 * Plugin URI: https://stockmarketwidgets.financialplugins.com/
 * Purchase: https://1.envato.market/az97R
 * Like: https://www.facebook.com/financialplugins/
 */

use \PremiumStockMarketWidgets\Plugin;
use \PremiumStockMarketWidgets\WPHelper;

defined('ABSPATH') or die('Direct access is not allowed');

// define plugin root folder to be used by other classess
define('SMW_PLUGIN_FILE', __FILE__);
define('SMW_ROOT_DIR', dirname(__FILE__));

require SMW_ROOT_DIR . '/vendor/autoload.php';

// plugin activation hook
register_activation_hook(__FILE__, [WPHelper::class, 'activate']);
register_uninstall_hook(__FILE__, [WPHelper::class, 'uninstall']);

// instantiate a new plugin instance
$premiumStockMarketWidgets = new Plugin();
