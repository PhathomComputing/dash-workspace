<?php
session_start();

/**
 * @package base-plugin
 * @version 0.1.0
 */
/*
Plugin Name: base-plugin
Plugin URI:  http://www.phathomcomputing.com
Description: base plugin setup for development
Author: Christopher Andreev
Version: 0.1.0
Text Domain: base-plugin
Author URI: http://www.phathomcomputing.com
*/


if ( !defined('ABSPATH') ) exit;


if( ! class_exists('base_plugin_class')):

	global $wpdb;

	class base_plugin_class {
	
		/**
		 * Main WWT Dropship Commerce Instance
		 * 
		 * @since 0.0.1
		 * @static object $instance
		 * 
		 */

		public static function instance(){
			if(!isset (self::$instance) && (self::$instance instanceof base_plugin_class)){
				self::$instance = new base_plugin_class;
				self::$instance->setup_constants();

				add_action('plugins_loaded', array(self::$instance, 'load_textdomain'));
				add_action('init',array(self::$instance, 'init_includes'));
			}
			return self::$instance;
		}


		public function __construct(){
			add_action('plugins_loaded', array($this, 'init'));
		}

        public function init(){
            if(True){
                $this->setup_constants();
                $this->includes();
				$this->activate_setup();
			}
        }

		public function activate_setup(){
			$filter_name = "plugin_action_links_". plugin_basename(__FILE__);
			add_filter($filter_name, 'base_plugin_dropship_settings_add_settings_link');
		}

		public function __clone(){_doing_it_wrong(__FUNCTION__,__('NoHaxPlzThnx','wwt_dropshipping'),'0.0.1');}

		public function __wakeup(){_doing_it_wrong(__FUNCTION__,__('NoHaxPlzThnx','wwt_dropshipping'),'0.0.1');}

		public function setup_constants(){
			if(!defined('BASE_PLUGIN_VER')){
				define('BASE_PLUGIN_VER','0.1.0');
			}
			if(!defined('BASE_PLUGIN_PLUG_DIR')){
				define('BASE_PLUGIN_PLUG_DIR',plugin_dir_path(__FILE__) );
			}
			if(!defined('BASE_PLUGIN_PLUG_URL')){
				define('BASE_PLUGIN_PLUG_URL',plugin_dir_url(__FILE__) );
			}
			if(!defined('BASE_PLUGIN_PLUG_FILE')){
				define('BASE_PLUGIN_PLUG_FILE',__FILE__);
			}
			if(!defined('BASE_PLUGIN_VER')){
				define('BASE_PLUGIN_VER','5.3.2');
			}
		}

		private function includes() {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			
			require_once BASE_PLUGIN_PLUG_DIR.'includes/base-plugin-tools.php';
			require_once BASE_PLUGIN_PLUG_DIR.'includes/base-plugin-menu.php';
		}
       
		private function is_woocommerce_activated(){
			if ( class_exists( 'WooCommerce' ) ) {
                return true;
              } else {
                return false;
              }
		}

		function test_code(){
			echo "Looks Good!";
			echo plugin_dir_url(__FILE__);
			echo admin_url( 'admin-ajax.php' );
		}
		
		
	}

	$_SESSION['base-plugin-session'] = new base_plugin_class();

endif;





 