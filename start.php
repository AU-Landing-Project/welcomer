<?php

namespace AU\Welcomer;

const PLUGIN_ID = 'welcomer';

// NOTE: kept poorly descriptive metadata names due to back compatibility

require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/functions.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

// plugin init
function init() {

	// add our css
	elgg_extend_view('css/admin', 'css/welcomer');

	//register plugin hooks
	if (elgg_is_logged_in()) {
		elgg_register_page_handler('welcomer', __NAMESPACE__ . '\\welcomer_pagehandler');

		elgg_register_action('welcomer/firstlogin', __DIR__ . '/actions/welcomer/firstlogin.php');
		elgg_register_action('welcomer/secondlogin', __DIR__ . '/actions/welcomer/secondlogin.php');
		elgg_register_action('welcomer/settings/save', __DIR__ . '/actions/welcomer/settings/save.php', 'admin');

		// first handle notifications
		// note that this will allow a notification on the very first login concurrent with the welcome page
		if (elgg_is_active_plugin('messages') && elgg_get_plugin_setting('nextlogin_notification', PLUGIN_ID) == 'yes') {
			$timestamp = elgg_get_plugin_setting('nextlogin_notification_timestamp', PLUGIN_ID);
			if (!empty($timestamp)) {
				$metadata = 'nextlogin_notification_' . $timestamp;

				if (!elgg_get_logged_in_user_entity()->$metadata) {
					// they haven't received this notification yet
					// set flag
					$subject = elgg_get_plugin_setting('nextlogin_notification_subject', PLUGIN_ID);
					$content = elgg_get_plugin_setting('nextlogin_notification_content', PLUGIN_ID);

					elgg_get_logged_in_user_entity()->$metadata = true;
					$ia = elgg_set_ignore_access(true);
					$admin = elgg_get_admins(array('limit' => 1));
					if ($admin[0]->guid != elgg_get_logged_in_user_guid()) {
						messages_send($subject, $content, elgg_get_logged_in_user_guid(), $admin[0]->guid);
					}
					elgg_set_ignore_access($ia);
				}
			}
		}

		elgg_register_plugin_hook_handler('route', 'all', __NAMESPACE__ . '\\route_all', 0);
		elgg_register_plugin_hook_handler('allowed_handlers', 'welcomer', __NAMESPACE__ . '\\allowed_handlers');
	}
}

//
// page handler function
function welcomer_pagehandler($page) {
	$content = elgg_view('resources/welcomer/welcome');

	if ($content) {
		echo $content;
		return true;
	}
	
	return false;
}
