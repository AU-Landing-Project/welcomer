<?php
/**
 * Saves plugin settings.
 *
 * we're registering this custom action to log when the 'next login' notification
 * has changed.  When that happens we flag the timestamp so we know when the next-login is
 */

$params = get_input('params');
$plugin_id = get_input('plugin_id');
$plugin = elgg_get_plugin_from_id($plugin_id);

if (!($plugin instanceof ElggPlugin)) {
	register_error(elgg_echo('plugins:settings:save:fail', array($plugin_id)));
	forward(REFERER);
}

$plugin_name = $plugin->getManifest()->getName();

$result = false;

// determine if the notification email has been updated and if so, we're setting our flag
$content = elgg_get_plugin_setting('nextlogin_notification_content', 'welcomer');

if($content != $params['nextlogin_notification_content']){
  // the notification content is different
  // so we need to reset the flag
  elgg_set_plugin_setting('nextlogin_notification_timestamp', time(), 'welcomer');
}

foreach ($params as $k => $v) {
	$result = $plugin->setSetting($k, $v);
	if (!$result) {
		register_error(elgg_echo('plugins:settings:save:fail', array($plugin_name)));
		forward(REFERER);
		exit;
	}
}

system_message(elgg_echo('plugins:settings:save:ok', array($plugin_name)));
forward(REFERER);
