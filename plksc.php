<?php
/*
Plugin Name: Permalinks Shortcode
Plugin URI:   https://www.referia.com/plugins/permalinks-shortcode/
Description:  Permalink Shortcode
Version:      1.0.1
Author:       Pierre-alexandre THOMAS
Author URI:   https://www.referia.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  plksc
Domain Path:  /languages

WP GDPR is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

WP GDPR is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.

*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


if ( !class_exists( 'plksc' ) ) {
    class plksc
    {

        /**
         * plksc constructor.
         */
        function __construct() {
            add_action( 'admin_menu', array( $this, 'admin_menu' ), 10, 2 );
            plksc::init();
        }



        /**
         * plugin init
         */
        public static function init()
        {

            /**
             * Define constants
             **/
            defined( 'PLKSC_VERSION' ) or define( 'PLKSC_VERSION', '1.0.1' );
            defined( 'PLKSC_NAME' ) or define( 'PLKSC_NAME', 'Permalink Shortcode' );
            defined( 'PLKSC_AUTHOR' ) or define( 'PLKSC_AUTHOR', 'Pierre-alexandre THOMAS' );
            defined( 'PLKSC_DIR' ) or define( 'PLKSC_DIR', dirname( plugin_basename( __FILE__ ) ) );
            defined( 'PLKSC_BASE' ) or define( 'PLKSC_BASE', plugin_basename( __FILE__ ) );
            defined( 'PLKSC_URL' ) or define( 'PLKSC_URL', plugin_dir_url(__FILE__) );
            defined( 'PLKSC_PATH' ) or define( 'PLKSC_PATH', plugin_dir_path( __FILE__ ) );
            defined( 'PLKSC_SLUG' ) or define( 'PLKSC_SLUG', dirname( plugin_basename( __FILE__ ) ) );
            defined( 'PLKSC_MINWPVERSION' ) or define( 'PLKSC_MINWPVERSION', '4.8' );
            defined( 'PLKSC_MAXWPVERSION' ) or define( 'PLKSC_MAXWPVERSION', '4.9.8' );
            defined( 'PLKSC_URLWP' ) or define( 'PLKSC_URLWP', 'https://www.referia.com/plugins/permalinks-shortcode/' );


            plksc::plksc_languages();

            /**
             * manage plugin options
             */
            require_once dirname( __FILE__ ) . '/admin/add_options.php';


            /**
             * enqueue back css
             */
            add_action( 'admin_enqueue_scripts', 'plksc_admin_style' );

            /**
             * Register back style sheet.
             */
            function plksc_admin_style() {
                wp_register_style( 'plkscadmincss', plugins_url('permalinks-shortcode/admin/css/admin-css.css'), false, '1.0.0' );
                wp_enqueue_style( 'plkscadmincss' );
            }


            /**
             * enqueue back script
             */
            add_action('admin_enqueue_scripts', 'plksc_register_plugin_admin_scripts');

            /**
             * Register back script.
             */
            function plksc_register_plugin_admin_scripts() {
                wp_register_script( 'plkscadminjs', plugins_url('permalinks-shortcode/admin/js/admin-script.js') , '', '', true );
                wp_enqueue_script( 'plkscadminjs' );
            }

            plksc::shortcode_generator();

        }


        /**
         * Shortcode generation
         */
        public static function shortcode_generator() {

            require_once dirname( __FILE__ ) . '/includes/shortcode_generator.php';

        }


        /**
         * Menu
         */
        public static function admin_menu() {
            add_options_page(
                'Permalink shortcode',
                'Permalink shortcode',
                'manage_options',
                'options_permalink_shortcode',
                array(
                    $this,
                    'settings_page'
                )
            );
        }


        /**
         * Setting page
         */
        public static function settings_page() {
            require_once dirname( __FILE__ ) . '/admin/view.php';
        }


        /**
         * Plugin menu
         */
        public static function plksc_inner_menu() {

            echo '<h2 class="nav-tab-wrapper">';
                echo '<a class="nav-tab nav-tab-active" href="?page=options_permalink_shortcode">' . __('Settings','plksc') . '</a>';
            echo '</h2>';
        }



        /**
         * plugin install
         */
        public static function install() {
            function plksc_install() {

            }
            register_activation_hook( __FILE__, 'plksc_install' );
        }


        /**
         * plugin deactivation
         */
        public static function deactivation() {
            function plksc_deactivation() {

            }
            register_deactivation_hook( __FILE__, 'plksc_deactivation' );
        }


        public static function plksc_languages() {
            function plksc_languages_textdomain() {
                $plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages'; /* Relative to WP_PLUGIN_DIR */
                load_plugin_textdomain( 'plksc', false, $plugin_rel_path );
            }
            add_action( 'plugins_loaded', 'plksc_languages_textdomain' );

        }

    }

    /**
     * Object instantiation
     */
    new plksc;

}