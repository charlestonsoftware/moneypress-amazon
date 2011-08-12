<?php

/**
 * We need the generic WPCSL plugin class, since that is the
 * foundation of much of our plugin.  So here we make sure that it has
 * not already been loaded by another plugin that may also be
 * installed, and if not then we load it.
 */
if (defined('MP_AMZ_PLUGINDIR')) {
    if (class_exists('wpCSL_plugin__mpamz') === false) {
        require_once(MPAMZ_PLUGINDIR.'WPCSL-generic/classes/CSL-plugin.php');
    }

    global $MP_amz_plugin;
   
    $MP_amz_plugin = new wpCSL_plugin__mpamz(
        array(
            'use_obj_defaults'      => true,        
            'prefix'                => MP_AMZ_PREFIX,
            'css_prefix'            => 'csl_themes',            
            'name'                  => 'MoneyPress : Amazon Edition',
            'url'                   => 'http://www.cybersprocket.com/products/moneypress-amazon/',
            'paypal_button_id'      => 'LUJK7AZN7MRDJ',
            'basefile'              => MP_AMZ_BASENAME,
            'plugin_path'           => MP_AMZ_PLUGINDIR,
            'plugin_url'            => MP_AMZ_PLUGINURL,
            'cache_path'            => MP_AMZ_PLUGINDIR . 'cache',
            'driver_name'           => 'Amazon',
            'driver_type'           => 'Panhandler',
            'driver_args'           => array(
                    'secret_access_key'   => get_option(MP_AMZ_PREFIX.'-secret_access_key'),
                    'wait_for'            => get_option(MP_AMZ_PREFIX.'-wait_for'),
                    'AWSAccessKeyId'      => get_option(MP_AMZ_PREFIX.'-AWSAccessKeyId'),
                    'associatetag'        => get_option(MP_AMZ_PREFIX.'-AssociateTag'),
                    'searchindex'         => get_option(MP_AMZ_PREFIX.'-SearchIndex'),
                    ),
            'shortcodes'            => array('mp-amz','MP-AMZ','mp-amazon')
        )
    );    
}    
    

