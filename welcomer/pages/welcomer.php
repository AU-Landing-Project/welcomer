<?php

$firstlogin = elgg_get_plugin_setting('firstlogin', 'welcomer');
$secondlogin = elgg_get_plugin_setting('secondlogin', 'welcomer');
  
$id = elgg_get_site_entity()->guid;
$firstlogin_usertag = "welcome_tag_".$id;
$secondlogin_usertag = "welcome_message_tag_".$id;
$user = elgg_get_logged_in_user_entity();

// determine which view to use
if($firstlogin == 'yes' && !$user->$firstlogin_usertag && $user->welcomer_track_user){
  $firstlogin_content = elgg_get_plugin_setting('firstlogincontent', 'welcomer');
  $content = elgg_view('output/longtext', array('value' => $firstlogin_content));
  $content .= "<br><br>";
  $content .= elgg_echo('welcomer:continue:destination') . "<br>";
  $content .= elgg_view_form('welcomer/firstlogin');
}
elseif($secondlogin == 'yes' && !$user->$secondlogin_usertag && $user->welcomer_track_user){
  $secondlogin_content = elgg_get_plugin_setting('secondlogincontent', 'welcomer');
  $content = elgg_view('output/longtext', array('value' => $secondlogin_content));
  $content .= "<br><br>";
  $content .= elgg_echo('welcomer:continue:destination') . "<br>";
  $content .= elgg_view_form('welcomer/secondlogin');
}
else{
  // something's wrong
  $content = "An unidentified error occurred";
  //forward();
}


$body = elgg_view_layout('one_column', array('content' => $content));

echo elgg_view_page(elgg_echo('welcomer'), $body);
