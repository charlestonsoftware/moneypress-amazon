<?php

/**
 * We need the generic WPCSL plugin class, since that is the
 * foundation of much of our plugin.  So here we make sure that it has
 * not already been loaded by another plugin that may also be
 * installed, and if not then we load it.
 */
if (defined('MPAMZ_PLUGINDIR')) {
    if (class_exists('wpCSL_plugin__mpamz') === false) {
        require_once(MPAMZ_PLUGINDIR.'WPCSL-generic/classes/CSL-plugin.php');
    }
    
    //// SETTINGS ////////////////////////////////////////////////////////
    
    /**
     * This section defines the settings for the admin menu.
     */
    
    $prefix = 'mpamz';
    
    $mpamz_plugin = new wpCSL_plugin__mpamz(
        array(
            'use_obj_defaults'      => true,        
            'prefix'                => $prefix,
            'name'                  => 'MoneyPress : Amazon Edition',
            'url'                   => 'http://www.cybersprocket.com/products/moneypress-amazon/',
            'paypal_button_id'      => 'LUJK7AZN7MRDJ',
            'basefile'              => MPAMZ_BASENAME,
            'plugin_path'           => MPAMZ_PLUGINDIR,
            'plugin_url'            => MPAMZ_PLUGINURL,
            'cache_path'            => MPAMZ_PLUGINDIR . 'cache',
            'driver_type'           => 'Panhanlder',
            'driver_args'           => array(
                    'api_key'   => get_option($prefix.'-api_key'),
                    )
        )
    );    
}    
    
/**************************************
 ** function: csl_mpamz_setup_admin_interface
 **
 ** Builds the interface elements used by WPCSL-generic for the admin interface.
 **/
function csl_mpamz_setup_admin_interface() {
    global $mpamz_plugin;
    
    // Don't have what we need? Leave.
    if (!isset($mpamz_plugin)) { return; }

    // Already been here?  Get out.
    if (isset($mpamz_plugin->settings->sections['How to Use'])) { return; }
    
    
    //-------------------------
    // How to Use Section
    //-------------------------    
    $slplus_plugin->settings->add_section(
        array(
            'name' => 'How to Use',
            'description' => get_string_from_phpexec(MPAMZ_PLUGINDIR.'/how_to_use.txt')
        )
    );

    //-------------------------
    // General Settings
    //-------------------------    
    $slplus_plugin->settings->add_section(
        array(
            'name'        => 'Amazon Settings',
            'description' => 'These settings affect how we talk to Amazon.'.
                                '<br/><br/>'
        )
    );
    
    $slplus_plugin->settings->add_item(
        'Amazon Settings', 
        'Amazon API Key', 
        'api_key', 
        'text', 
        false,
        'Your Amazon API Key.  You will need to ' .
        '<a href="https://affiliate-program.amazon.com/">'.
        'go to Amazon</a> to get your API Key.'
    );
    
}

