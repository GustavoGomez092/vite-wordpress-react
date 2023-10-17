<?php
/*
Plugin Name: React WordPress Plugin
Description: Use the [wp-react] shortcode to display the plugin
Version: 0.0.1
Author: Gustavo Gomez
Author URI: https://github.com/GustavoGomez092
*/


class Wpreact {

    protected $plugin_options_page = '';

    /**
    * Class constructor
    */
    public function __construct() {
    require('plugin_options.php');
    add_action('wp_enqueue_scripts', [$this, 'REST_API_DATA_LOCALIZER'] );
    }

    /**
     * Script tag modifier
     */

    public function add_type_attribute_front($tag, $handle, $src) {
        // change the script tag by adding type="module" and return it.
        if ($handle  === 'wp-react-plugin-dev' || $handle  === 'wp-react-plugin-prod') {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
            return $tag;
        }
        // if not your script, do nothing and return original $tag
        return $tag;
    }

    /**
     * Initialize RADL
     */
    public function REST_API_DATA_LOCALIZER () {
        // define the name of the file to be inserted
        $name = 'serverData';

        // add the data you want to pass from PHP to JS
        // Data will be inserted in the window object with the name defined above
        $page_on_front = get_option( 'page_on_front' );
        // Get ACF options
        $plugin_options = array();

        // Get custom data example
        $custom_data = array(
            'plugin_data' => array(
                'main' => array(
                    'plugin_name' => 'wp_react_plugin',
                    'plugin_version' => '1.0'
                ),
                'options' => array(
                    'juan_es_gay' => true,
                    'miguel_es_gei' => true,
                    'home_page_id' => $page_on_front
                )
            )
        );

        $normalized_array = array_merge($plugin_options, $custom_data);

        wp_register_script( $name, '' );
        wp_enqueue_script( $name );
        wp_add_inline_script( $name, 'window.' . $name . ' = ' . wp_json_encode( $normalized_array ), 'after' );
    }

    /**
     * Stupid react code for shit to work
     */
    function custom_header_scripts()
    {
        error_log(plugins_url( "/@react-refresh", __FILE__ ));
        echo '<script type="module">
        import RefreshRuntime from "http://localhost:5173/wp-content/plugins/react-wp/@react-refresh"
        RefreshRuntime.injectIntoGlobalHook(window)
        window.$RefreshReg$ = () => {}
        window.$RefreshSig$ = () => (type) => type
        window.__vite_plugin_react_preamble_installed__ = true
        </script>
        <script type="module" src="http://localhost:5173/wp-content/plugins/react-wp/@vite/client"></script>
        <script type="module" src="http://localhost:5173/wp-content/plugins/react-wp/src/main.jsx"></script>
        ';
    }

    /**
     * Plugin shortcode for front-end
     */
    function plugin_shortcode( $atts ) {
        $handle = 'wp-react-plugin-';

        add_filter('script_loader_tag', [$this, 'add_type_attribute_front'], 10, 3);

        // enqueue development or production react code
        if(file_exists(dirname(__FILE__) . "/dist/react-wp.js")) {
        $handle .= 'prod';
        wp_enqueue_script( $handle, plugins_url( "/dist/react-wp.js", __FILE__ ), ['wp-element'], '0.1', true );
        wp_enqueue_style( $handle, plugins_url( "/dist/style.css", __FILE__ ), false, '0.1', 'all' );
        } else {
        $handle .= 'dev';
        add_action( 'wp_head', [$this, 'custom_header_scripts'] );
        }

        /**
        * React specific stuff to make hot reload work with vite on plugin development
        */
        $tag = '<div id="wp-react"></div>';
        
        return $tag;
    }

    /**
     * Inserting nonce to window object for admin
     */
    public function add_nonce() {
        wp_register_script(
            'custom-js-file', 
            plugins_url( "custom.js", __FILE__ ), 
            [], 
            null, 
            false 
        );
        
        wp_enqueue_script('custom-js-file');
    }

    /**
     * Custom API endpoints for admin
     */

    public function get_user(WP_REST_Request $request) {
        $user = wp_get_current_user();
        return $user;
    }

    public function api_init() {
        register_rest_route('wp-react/v1', '/user/', [
            'methods'   => 'GET',
            'callback'  => [$this, 'get_user'],
            'permission_callback'   => function () {
                    return current_user_can('manage_options');
            }
        ]);
    }

    /**
    * Initialize hooks.
    */
    public function init() {
        add_shortcode( 'wp-react', [$this, 'plugin_shortcode'] );
        add_action('rest_api_init', [$this , 'api_init']); 
        
        // adding nonce to the window object if logged in
        add_action('admin_enqueue_scripts', function() {
            if ( is_user_logged_in() ) {
                $this->add_nonce();
                wp_localize_script('custom-js-file', 'wpApiSettings', array(
                'root' => esc_url_raw(rest_url()),
                'nonce' => wp_create_nonce('wp_rest')
                ));
            }
        });   
    }
}

$wp_react = new Wpreact();
$wp_react->init();