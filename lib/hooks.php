<?php

namespace AU\Welcomer;

/**
 * redirect to the welcome page if not in the allowed handler whitelist
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return type
 */
function route_all($hook, $type, $return, $params) {

	// allow some handlers by default
	$allow = elgg_trigger_plugin_hook('allowed_handlers', 'welcomer', array(), array());

	if (in_array($type, $allow)) {
		return $return;
	}

	welcomer_redirect();
}

/**
 * build the allowed handler whitelist
 * 
 * @param type $hook
 * @param type $type
 * @param array $return
 * @param type $params
 * @return type
 */
function allowed_handlers($hook, $type, $return, $params) {
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
		'cache'
	);

	return array_merge($return, $allowed);
}
