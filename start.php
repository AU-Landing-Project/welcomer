<?php
// NOTE: kept poorly descriptive metadata names due to back compatibility

require_once 'lib/hooks.php';

// plugin init
function welcomer_init() {
  // add our css
  elgg_extend_view('css/admin', 'welcomer/css');
  
  //register plugin hooks
  if (elgg_is_logged_in()) {
    elgg_register_page_handler('welcomer', 'welcomer_pagehandler');
    
    elgg_register_action('welcomer/firstlogin', elgg_get_plugins_path() . 'welcomer/actions/welcomer/firstlogin.php');
    elgg_register_action('welcomer/secondlogin', elgg_get_plugins_path() . 'welcomer/actions/welcomer/secondlogin.php');
    elgg_register_action('welcomer/settings/save', elgg_get_plugins_path() . 'welcomer/actions/welcomer/settings/save.php');
    
    // first handle notifications
    // note that this will allow a notification on the very first login concurrent with the welcome page
    if (elgg_is_active_plugin('notifications') && elgg_get_plugin_setting('nextlogin_notification', 'welcomer') == 'yes') {
      $timestamp = elgg_get_plugin_setting('nextlogin_notification_timestamp', 'welcomer');
      
      if (!empty($timestamp)) {
        $metadata = 'nextlogin_notification_' . $timestamp;
      
        if (!elgg_get_logged_in_user_entity()->$metadata) {
          // they haven't received this notification yet
          // set flag
          $subject = elgg_get_plugin_setting('nextlogin_notification_subject', 'welcomer');
          $content = elgg_get_plugin_setting('nextlogin_notification_content', 'welcomer');
          
          elgg_get_logged_in_user_entity()->$metadata = TRUE;
          
          notify_user(
                  elgg_get_logged_in_user_guid(),
                  elgg_get_site_entity()->guid,
                  $subject,
                  $content,
                  NULL,
                  'site'
                  );
        }
      }
    }
    
    elgg_register_plugin_hook_handler('route', 'all', 'welcomer_router', 0);
    elgg_register_plugin_hook_handler('index', 'system', 'welcomer_index', 0);
    elgg_register_plugin_hook_handler('allowed_handlers', 'welcomer', 'welcomer_allowed_handlers');
  }
}


//
// page handler function
function welcomer_pagehandler($page){
  if(include('pages/welcomer.php')){
    return TRUE;
  }
  
  return FALSE;
}

function welcomer_redirect() {
    $firstlogin = elgg_get_plugin_setting('firstlogin', 'welcomer');
    $secondlogin = elgg_get_plugin_setting('secondlogin', 'welcomer');
    $welcome_url = elgg_get_site_url() . 'welcomer';

  
    $id = elgg_get_site_entity()->guid;
    $firstlogin_usertag = "welcome_tag_".$id;
    $secondlogin_usertag = "welcome_message_tag_".$id;
    $user = elgg_get_logged_in_user_entity();
    
    // this is the users first time logging in, set up some metadata to track them
    if ($user->prev_last_login == 0 && !$user->$firstlogin_usertag && $firstlogin == 'yes') {
      $user->welcomer_track_user = TRUE;
      $user->$firstlogin_usertag = FALSE;
      $user->$secondlogin_usertag = FALSE;
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
    if ($secondlogin == 'yes' && !$user->$secondlogin_usertag
            && $user->welcomer_track_user
            && !$_SESSION['welcomer_first_login']) {
        
      // this is their second login
      if(empty($_SESSION['welcomer_return_url'])){
        $_SESSION['welcomer_return_url'] = current_page_url();
      }
      
      // send them to the welcomer page
      forward($welcome_url, 'welcomer');
    }
}

elgg_register_event_handler('init', 'system', 'welcomer_init');
