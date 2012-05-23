<?php

$user = elgg_get_logged_in_user_entity();

// sanity check
if(!$user){
  forward();
}

$id = elgg_get_site_entity()->guid;
$secondlogin_usertag = "welcome_message_tag_".$id;

// remember that the user has seen the first welcome message
$user->$secondlogin_usertag = TRUE;

// send them to their original destination
$url = $_SESSION['welcomer_return_url'];
unset($_SESSION['welcomer_return_url']);

forward($url, 'welcomer_read_second_message');
