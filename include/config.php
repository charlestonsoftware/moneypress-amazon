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
    $mpamz_plugin = new wpCSL_plugin__mpamz(
        array(
            'use_obj_defaults'      => true,        
            'prefix'                => MPAMZ_PREFIX,
            'name'                  => 'MoneyPress : Amazon Edition',
            'url'                   => 'http://www.cybersprocket.com/products/moneypress-amazon/',
            'paypal_button_id'      => 'LUJK7AZN7MRDJ',
            'basefile'              => MPAMZ_BASENAME,
            'plugin_path'           => MPAMZ_PLUGINDIR,
            'plugin_url'            => MPAMZ_PLUGINURL,
            'cache_path'            => MPAMZ_PLUGINDIR . 'cache',
            'driver_name'           => 'Amazon',
            'driver_type'           => 'Panhandler',
            'driver_args'           => array(
                    'secret_access_key'   => get_option(MPAMZ_PREFIX.'-secret_access_key'),
                    'wait_for'            => get_option(MPAMZ_PREFIX.'-wait_for'),
                    ),
            'shortcodes'            => array('mp-amz','MP-AMZ','mp-amazon')
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
    if (!isset($mpamz_plugin)) {
        print 'no base class instantiated<br/>';
        return; 
    }

    // Already been here?  Get out.
    if (isset($mpamz_plugin->settings->sections['How to Use'])) { return; }
    
    
    //-------------------------
    // How to Use Section
    //-------------------------    
    $mpamz_plugin->settings->add_section(
        array(
            'name' => 'How to Use',
            'description' => get_string_from_phpexec(MPAMZ_PLUGINDIR.'/how_to_use.txt')
        )
    );

    //-------------------------
    // Amazon Settings Section
    //-------------------------    
    $section    = __('Amazon Settings', MPAMZ_PREFIX);
    
    $mpamz_plugin->settings->add_section(
        array(
            'name'        => $section,
            'description' => 'These settings affect how we talk to Amazon.'.
                                '<br/><br/>'
        )
    );
    
    $label      = __('Secret Access Key',MPAMZ_PREFIX);
    $hint       = __(
        'Your Amazon Secret Access Key.  You will need to ' .
        '<a href="https://affiliate-program.amazon.com/">'.
        'go to Amazon</a> to get your Key.',                
        MPAMZ_PREFIX);
    $mpamz_plugin->settings->add_item(
        $section,$label, 
        'secret_access_key','text',true,
        $hint
    );
    

    $label      = __('Amazon Site',MPAMZ_PREFIX);
    $hint       = __('Select the Amazon site to pull data from.',MPAMZ_PREFIX);
    $mpamz_plugin->settings->add_item(
        $section,$label, 
        'amazon_site', 'list', false, 
        $hint,
        array(
            'United States' =>  'ecs.amazonaws.com',
            'Canada'        =>  'ecs.amazonaws.ca',
            'Denmark'       =>  'ecs.amazonaws.de',
            'France'        =>  'ecs.amazonaws.fr',
            'Japan'         =>  'ecs.amazonaws.jp',
            'United Kingdom'=>  'ecs.amazonaws.co.uk',
            )
    );
    
    $label      = __('Request Timeout',MPAMZ_PREFIX);
    $hint       = __('How long, in seconds, do we wait to hear back from Amazon. (default:30)',MPAMZ_PREFIX);
    $mpamz_plugin->settings->add_item(
        $section,$label, 
        'wait_for', 'text', false, 
        $hint
    );    
    
}

