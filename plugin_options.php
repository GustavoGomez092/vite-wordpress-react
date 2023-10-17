<?php

class plugin_options {

  protected $plugin_options_page = '';

  /**
  * Initialize hooks.
  */
  function init() {

    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
    add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );
    add_action('admin_menu', array( $this, 'create_admin_menu_page' ) );
  }

  function register_plugin_settings() {
      register_setting( 'WPReact-settings-group', 'WPReact-plugin' );
  }

  /**
  *
  * Create new plugin options page under the Settings menu.
  */
  function create_admin_menu_page() {
    $this->plugin_options_page = add_menu_page('Plugin options', 'plugin options', 'manage_options', __FILE__, array( $this, 'render_plugin_options_page' ), 'dashicons-editor-table' );
  }

  function render_plugin_options_page() {
    echo '<script type="module">
    import RefreshRuntime from "http://localhost:5173/@react-refresh"
    RefreshRuntime.injectIntoGlobalHook(window)
    window.$RefreshReg$ = () => {}
    window.$RefreshSig$ = () => (type) => type
    window.__vite_plugin_react_preamble_installed__ = true
    </script>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/src/main.jsx"></script>
    </script> <div id="WPReact-options"></div>';
  }

  function add_type_attribute_admin($tag, $handle, $src)
  {
      // change the script tag by adding type="module" and return it.
      if ($handle  === 'WPReact-plugin-options-dev') {
          $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
          return $tag;
      }
      // if not your script, do nothing and return original $tag
      return $tag;
  }

  function enqueue_admin_scripts($hook) {

    // Are we on the plugin options page?
    if( $hook === $this->plugin_options_page ) {

      // add react and react-dom from core
      $dep = ['wp-element'];

      $handle = 'WPReact-plugin-options-';

      add_filter('script_loader_tag', array($this,'add_type_attribute_admin'), 10, 3);

      if(file_exists(dirname(__FILE__) . "/dist/react-wp.js")) {
        $handle .= 'prod';
        wp_enqueue_script( $handle, plugins_url( "/dist/react-wp.js", __FILE__ ), ['wp-element'], '0.1', true );
        wp_enqueue_style( $handle, plugins_url( "/dist/style.css", __FILE__ ), false, '0.1', 'all' );
        } else {
        $handle .= 'dev';
        wp_enqueue_script( $handle, 'http://localhost:5173/src/main.js', ['wp-element'], '0.1', true );
        
        }
    }
  }
}

$plugin_options = new plugin_options();
$plugin_options->init();