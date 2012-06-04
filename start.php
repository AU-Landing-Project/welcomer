<?php
// NOTE: kept poorly descriptive metadata names due to back compatibility

// plugin init
function welcomer_init(){
  //register plugin hooks
  if(elgg_is_logged_in()){
    elgg_register_page_handler('welcomer', 'welcomer_pagehandler');
    
    elgg_register_action('welcomer/firstlogin', elgg_get_plugins_path() . 'welcomer/actions/welcomer/firstlogin.php');
    elgg_register_action('welcomer/secondlogin', elgg_get_plugins_path() . 'welcomer/actions/welcomer/secondlogin.php');
    
    $firstlogin = elgg_get_plugin_setting('firstlogin', 'welcomer');
    $secondlogin = elgg_get_plugin_setting('secondlogin', 'welcomer');
    $welcome_url = elgg_get_site_url() . 'welcomer';
    $handler = get_input('handler');
    $allowed_handlers = array(
          'welcomer',
          'action',
          'css',
          'js',
          NULL
      );
  
    $id = elgg_get_site_entity()->guid;
    $firstlogin_usertag = "welcome_tag_".$id;
    $secondlogin_usertag = "welcome_message_tag_".$id;
    $user = elgg_get_logged_in_user_entity();
    
    // this is the users first time logging in, set up some metadata to track them
    if($user->prev_last_login == 0 && !$user->$firstlogin_usertag && $firstlogin == 'yes'){
      $user->welcomer_track_user = TRUE;
      $user->$firstlogin_usertag = FALSE;
      $user->$secondlogin_usertag = FALSE;
    }
    
    
    if($user->welcomer_track_user && !$user->$firstlogin_usertag && $firstlogin == 'yes'){
      $user->welcomer_first_login = $user->last_login;
      
      // remember where they were going to so we can continue there
      // after they have been welcomed
      if(empty($_SESSION['welcomer_return_url'])){
        $_SESSION['welcomer_return_url'] = current_page_url();
      }
      
      // forward if we're not on one of the approved page handlers
      // which is welcomer and the welcomer actions
      $redirect = TRUE;
      
      if(in_array($handler, $allowed_handlers)){
        $redirect = FALSE;
      }
      
      // handler is NULL for index and actions, allow actions
      // don't allow index
      if(current_page_url() == elgg_get_site_url()){
        $redirect = TRUE;
      }
      
      // send them to the welcomer page
      if($redirect){
        forward($welcome_url, 'welcomer');
      }
    }
    

    // we've passed the first login check
    // check for subsequent login
    // note session variable so that the second login welcome
    // isn't shown on the same session
    if($secondlogin == 'yes' && !$user->$secondlogin_usertag
            && $user->welcomer_track_user
            && !$_SESSION['welcomer_first_login']){
      // this is their second login
      if(empty($_SESSION['welcomer_return_url'])){
        $_SESSION['welcomer_return_url'] = current_page_url();
      }
    
      // forward if we're not on one of the approved pages
      // which is welcomer and the welcomer actions
      $redirect = TRUE;
      
      if(in_array($handler, $allowed_handlers)){
        $redirect = FALSE;
      }
      
      // handler is NULL for index and actions, allow actions
      // don't allow index
      if(current_page_url() == elgg_get_site_url()){
        $redirect = TRUE;
      }
      
      // send them to the welcomer page
      if($redirect){
        forward($welcome_url, 'welcomer');
      }
    }
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

elgg_register_event_handler('init', 'system', 'welcomer_init');
