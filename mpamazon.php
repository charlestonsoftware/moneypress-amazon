<?php
/*
Plugin Name: MoneyPress Amazon Edition
Plugin URI: http://www.cybersprocket.com/products/moneypress-amazon/
Description: Put Amazon product listings on your posts and pages using a simple short code.  Great for earning affiliate revenue or adding content.     
Version: 0.1
http://www.cybersprocket.com
License: GPL3

=====================

	Copyright 2010  Cyber Sprocket Labs (info@cybersprocket.com)

        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 3 of the License, or
        (at your option) any later version.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**/


// Define our paths 
//
if (defined('MPAMZ_PLUGINDIR') === false) {
    define('MPAMZ_PLUGINDIR', plugin_dir_path(__FILE__));
}
if (defined('MPAMZ_PLUGINURL') === false) {
    define('MPAMZ_PLUGINURL', plugins_url('',__FILE__));
}
if (defined('MPAMZ_BASENAME') === false) {
    define('MPAMZ_BASENAME', plugin_basename(__FILE__));
}

if (defined('MPAMZ_PREFIX') === false) {
    define('MPAMZ_PREFIX', 'mpamz');
}

include_once(MPAMZ_PLUGINDIR.'/include/config.php');

add_action('admin_init','csl_mpamz_setup_admin_interface',10);

load_plugin_textdomain(MPAMZ_PREFIX, false, MPAMZ_PLUGINDIR . '/languages/');

add_action('wp_print_styles', 'add_mpamz_css');

//// FUNCTIONS ///////////////////////////////////////////////////////

/**
 * Adds our user CSS to the page.
 */
function add_mpamz_css() {
    $myStyleUrl  = MPAMZ_PLUGINURL . '/css/'.MPAMZ_PREFIX.'_style.css';
    $myStyleFile = MPAMZ_PLUGINDIR . '/css/'.MPAMZ_PREFIX.'_style.css';
    if ( file_exists($myStyleFile) ) {
    wp_register_style(MPAMZ_PREFIX.'_css', $myStyleUrl);
    wp_enqueue_style( MPAMZ_PREFIX.'_css');
    }
}



