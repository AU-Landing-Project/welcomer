<?php

namespace AU\Welcomer;

/**
 * redirect the new user to a page if necessary
 */
function welcomer_redirect() {
	$firstlogin = elgg_get_plugin_setting('firstlogin', PLUGIN_ID);
	$secondlogin = elgg_get_plugin_setting('secondlogin', PLUGIN_ID);
	$welcome_url = elgg_get_site_url() . 'welcomer';


	$id = elgg_get_site_entity()->guid;
	$firstlogin_usertag = "welcome_tag_" . $id;
	$secondlogin_usertag = "welcome_message_tag_" . $id;
	$user = elgg_get_logged_in_user_entity();

	// this is the users first time logging in, set up some metadata to track them
	if ($user->prev_last_login == 0 && !$user->$firstlogin_usertag && $firstlogin == 'yes') {
		$user->welcomer_track_user = true;
		$user->$firstlogin_usertag = false;
		$user->$secondlogin_usertag = false;
	}


	if ($user->welcomer_track_user && !$user->$firstlogin_usertag && $firstlogin == 'yes') {
		$user->welcomer_first_login = $user->last_login;

		// remember where they were going to so we can continue there
		// after they have been welcomed
		if (empty($_SESSION['welcomer_return_url'])) {
			$_SESSION['welcomer_return_url'] = current_page_url();
		}

		forward($welcome_url, 'welcomer');
	}


	// we've passed the first login check
	// check for subsequent login
	// note session variable so that the second login welcome
	// isn't shown on the same session
	if ($secondlogin == 'yes' && !$user->$secondlogin_usertag && $user->welcomer_track_user && !$_SESSION['welcomer_first_login']) {

		// this is their second login
		if (empty($_SESSION['welcomer_return_url'])) {
			$_SESSION['welcomer_return_url'] = current_page_url();
		}

		// send them to the welcomer page
		forward($welcome_url, 'welcomer');
	}
}
