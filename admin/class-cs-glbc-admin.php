<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codescheme.github.io
 * @since      1.0.0
 *
 * @package    Cs_Glbc
 * @subpackage Cs_Glbc/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cs_Glbc
 * @subpackage Cs_Glbc/admin
 * @author     Codescheme <codescheme@gmail.com>
 */
class Cs_Glbc_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cs_Glbc_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cs_Glbc_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        //wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cs-glbc-admin.css', array(), $this->version, 'all' );

        if ( 'settings_page_cs-glbc' == get_current_screen() -> id ) {

            wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cs-glbc-admin.css', array( 'wp-color-picker' ), $this->version, 'all' );
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cs_Glbc_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cs_Glbc_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        //wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cs-glbc-admin.js', array( 'jquery' ), $this->version, false );
        
         if ( 'settings_page_cs-glbc' == get_current_screen() -> id ) {
            wp_enqueue_media();
            wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cs-glbc-admin.js', array( 'jquery', 'media-upload' ), $this->version, false );
        }
        
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
        add_options_page( 'Google Local Business Search Profile', 'Google Business Search', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
    }

    /**
    * Add settings action link to the plugins page.
    *
    * @since    1.0.0
    */

    public function add_action_links( $links ) {
    /*
    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
    */
        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge( $settings_link, $links );
    }

    /**
    * Render the settings page for this plugin.
    *
    * @since    1.0.0
    */

    public function display_plugin_setup_page() {
        include_once( 'partials/cs-glbc-admin-display.php' );
    }
    
    /**
     *
     * admin/class-wp-cbf-admin.php
     *
    **/

    public function validate($input) {

        $old_opt = get_option('cs-glbc');
        $valid = [];

        $valid['schema_type'] = (isset($input['schema_type']) && !empty($input['schema_type'])) ? sanitize_text_field($input['schema_type']) : '';
        $valid['image_id'] = (isset($input['image_id']) && !empty($input['image_id'])) ? absint($input['image_id']) : 0;
        $valid['name'] = (isset($input['name']) && !empty($input['name']) && ($input['name'] != get_bloginfo('name'))) ? sanitize_text_field($input['name']) : get_bloginfo('name');

        foreach ($input['address'] as $a){
            $a = sanitize_text_field($a);
        }
        $valid['address'] = $input['address'];
    
        foreach ($input['geo'] as $g){
            $g = sanitize_text_field($g);
        }
        $valid['geo'] = $input['geo'];

        $valid['phone'] = (isset($input['phone']) && !empty($input['phone'])) ? sanitize_text_field($input['phone']) : '';
        $valid['page_id'] = (isset($input['page_id']) && !empty($input['page_id'])) ? absint($input['page_id']) : 0;
        $valid['priceRange'] = (isset($input['priceRange']) && !empty($input['priceRange'])) ? absint($input['priceRange']) : "";
        
        $time_regex = "/([0-9]|[0-9]{2})\:[0-9]{2}/";
        $flag = false;
        $valid['opening'] = $input['opening'];

        foreach ($valid['opening'] as $day => $time){
            if($time['open'] && $time['close']){
                if ( (!$time['open'] && $time['close']) || ($time['open'] && !$time['close']) ) $flag = true;
                if ( str_replace(':','', $time['open']) > str_replace(':','', $time['close']) ) $flag = true;
                if ( !preg_match($time_regex, $time['open']) || !preg_match($time_regex, $time['close']) ) $flag = true;
            }
        }

        if ($flag){
            $valid['opening'] = $old_opt['opening'];
            add_settings_error(
                'opening',
                'opening_texterror',
                'Error: please enter a valid time',
                'error'
            );
        }
        return $valid;
    }
    /**
     *
     * admin/class-wp-cbf-admin.php
     *
    **/
    public function options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }
}
