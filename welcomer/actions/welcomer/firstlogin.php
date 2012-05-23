<?php

$user = elgg_get_logged_in_user_entity();

// sanity check
if(!$user){
  forward();
}

$id = elgg_get_site_entity()->guid;
$firstlogin_usertag = "welcome_tag_".$id;

// remember that the user has seen the first welcome message
$_SESSION['welcomer_first_login'] = TRUE;
$user->$firstlogin_usertag = TRUE;

// send them to their original destination
$url = $_SESSION['welcomer_return_url'];
unset($_SESSION['welcomer_return_url']);

forward($url, 'welcomer_read_first_message');
