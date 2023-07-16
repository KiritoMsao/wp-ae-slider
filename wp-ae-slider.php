<?php 

/**
 * Plugin Name:       WP AE Slider
 * Plugin URI:        https://abdelilahelhaddad.xyz/wp-ae-slider
 * Description:       Best slider plugin.
 * Version:           1.0.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Abdelilah Elhaddad
 * Author URI:        https://abdelilahelhaddad.xyz/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://abdelilahelhaddad.xyz/<h1>
 * Text Domain:       wp-ae-slider
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    die('Wrong Page');
}

if (!class_exists('WP_AE_Slider')) {
    class WP_AE_Slider{
        function __construct()
        {
            $this->define_constants();

            add_action( 'admin_menu', array($this, 'add_menu') );

            require_once(WP_AE_Slider_PATH. 'inc/wp-ae-slider-cpt.php');
            $WP_AE_Slider_CPT = new WP_AE_Slider_CPT();

            require_once(WP_AE_Slider_PATH. 'inc/wp-ae-slider-settings.php');
            $WP_AE_Slider_SETTINGS = new WP_AE_Slider_SETTINGS();
        }

        public function define_constants(){
            define('WP_AE_Slider_PATH', plugin_dir_path( __FILE__ ));
            define('WP_AE_Slider_URL', plugin_dir_url( __FILE__ ));
            define('WP_AE_Slider_VERSION', '1.0.0');
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type('wp-ae-slider');
        }

        public static function uninstall(){
            
        }

        public function add_menu(){
            add_menu_page( 
                'WP AE Slider Options', 
                'WP AE Slider', 
                'manage_options', 
                'wp_ae_slider_admin', 
                array($this, 'wp_ae_slider_settings_page'), 
                'dashicons-images-alt2' );

            add_submenu_page( 
                'wp_ae_slider_admin',
                'Manage WP AE Slider',
                'Manage WP AE Slider',
                'manage_options',
                'edit.php?post_type=wp-ae-slider',
                null, 
                null );

            add_submenu_page( 
                'wp_ae_slider_admin',
                'Add New Slider',
                'Add New Slider',
                'manage_options',
                'post-new.php?post_type=wp-ae-slider',
                null, 
                null );
        }

        public function wp_ae_slider_settings_page(){
            if(!current_user_can('manage_options')){
                return;
            }
            if(isset($_GET['settings-updated'])){
                add_settings_error( 'wp_ae_slider_options', 'wp_ae_slider_messsage', 'Settings Saved', 'success' );
            }
            settings_errors('wp_ae_slider_options');
            require(WP_AE_Slider_PATH . 'inc/wp-ae-settings-page.php');
        }

    }
}

if (class_exists('WP_AE_Slider')) {
    register_activation_hook( __FILE__, array('WP_AE_Slider', 'activate') );
    register_deactivation_hook( __FILE__, array('WP_AE_Slider', 'deactivate') );
    register_uninstall_hook( __FILE__, array('WP_AE_Slider', 'uninstall') );

    $wp_ae_slider = new WP_AE_Slider();
}