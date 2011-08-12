<?php
/****************************************************************************
 ** file: plus.php
 **
 ** Things that are not part of the LE product
 ***************************************************************************/

 
/**************************************
 ** function: csl_mpamz_add_settings()
 ** 
 ** Add the plus settings to the settings interface.
 **
 **/
function csl_mpamz_add_settings() {
    global $MP_amz_plugin;
    
    
    // The Themes
    // No themes? Force the default at least
    //
    $themeArray = get_option(MP_AMZ_PREFIX.'-theme_array');
    if (count($themeArray, COUNT_RECURSIVE) <= 2) {
        $themeArray = array('Off-White Single Column' => 'mp-offwhite');
    }    

    // Check for theme files
    //
    $lastNewThemeDate = get_option(MP_AMZ_PREFIX.'-theme_lastupdated');
    $newEntry = array();
    if ($dh = opendir(MP_AMZ_COREDIR.'css/')) {
        while (($file = readdir($dh)) !== false) {
            
            // If not a hidden file
            //
            if (!preg_match('/^\./',$file)) {                
                $thisFileModTime = filemtime(MP_AMZ_COREDIR.'css/'.$file);
                
                // We have a new theme file possibly...
                //
                if ($thisFileModTime > $lastNewThemeDate) {
                    $newEntry = csl_mpamz_GetThemeInfo(MP_AMZ_COREDIR.'css/'.$file);
                    $themeArray = array_merge($themeArray, array($newEntry['label'] => $newEntry['file']));                                        
                    update_option(MP_AMZ_PREFIX.'-theme_lastupdated', $thisFileModTime);
                }
            }
        }
        closedir($dh);
    }
    
    // We added at least one new theme
    //
    if (count($newEntry, COUNT_RECURSIVE) > 1) {
        update_option(MP_AMZ_PREFIX.'-theme_array',$themeArray);
    }  
        
    $MP_amz_plugin->settings->add_item(
        'Product Display', 
        'Select A Theme',   
        'theme',    
        'list', 
        false, 
        'How should the plugin UI elements look?',
        $themeArray
    );
}

/**************************************
 ** function: csl_mpamz_GetThemeInfo
 ** 
 ** Extract the label & key from a CSS file header.
 **
 **/
function csl_mpamz_GetThemeInfo ($filename) {    
    $dataBack = array();
    if ($filename != '') {
       $default_headers = array(
            'label' => 'label',
            'file' => 'file',
            'columns' => 'columns'
           );
        
       $dataBack = get_file_data($filename,$default_headers,'');
       $dataBack['file'] = preg_replace('/.css$/','',$dataBack['file']);       
    }
    
    return $dataBack;
 }
 
 
/**************************************
 ** function: csl_mpamz_configure_theme
 ** 
 ** Configure the plugin theme drivers based on the theme file meta data.
 **
 **/
 function csl_mpamz_configure_theme($themeFile) {
    global $MP_amz_plugin;
    
    $newEntry = csl_mpamz_GetThemeInfo(MP_AMZ_COREDIR.$themeFile);
    $MP_amz_plugin->products->columns = $newEntry['columns'];
 }
