<?php

function welcomer_router($hook, $type, $return, $params) {
    
    // allow some handlers by default
    $allow = elgg_trigger_plugin_hook('allowed_handlers', 'welcomer', array(), array());
    
    if (in_array($type, $allow)) {
        return $return;
    }
    
    welcomer_redirect();
}


function welcomer_allowed_handlers($hook, $type, $return, $params) {
    if (!is_array($return)) {
        $return = array();
    }
    
    $allowed = array(
          'welcomer',
          'action',
          'css',
          'js',
          'terms',
          'privacy',
          NULL
    );    
    
    return array_merge($return, $allowed);
}


function welcomer_index($hook, $type, $return, $params) {
    if (elgg_is_logged_in()) {
        welcomer_redirect();
    }
}