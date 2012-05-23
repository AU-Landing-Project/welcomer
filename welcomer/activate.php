<?php

// inherit settings from old 1.7 welcomer
$first = elgg_get_plugin_setting('firstlogincontent', 'welcomer');
$second = elgg_get_plugin_setting('secondlogincontent', 'welcomer');

if(!$first && !$second){
  $id = elgg_get_site_entity()->guid;
  
  // first login content
  $options = array(
      'guid' => $id,
      'metadata_name' => "welcomer_welcome_".$id,
      'limit' => 0
  );
  $metadata = elgg_get_metadata($options);
  
  if($metadata[0]->value){
    // nothing is currently set for the current installation
    // we have existing info from 1.7, so we'll import it
    elgg_set_plugin_setting('firstlogincontent', $metadata[0]->value, 'welcomer');
  }
  
  // first login enable
  $options = array(
      'guid' => $id,
      'metadata_name' => "welcomer_switcher_".$id,
      'limit' => 0
  );
  $metadata = elgg_get_metadata($options);
  
  if($metadata[0]->value){
    elgg_set_plugin_setting('firstlogin', 'yes', 'welcomer');
  }
  else{
    elgg_set_plugin_setting('firstlogin', 'no', 'welcomer');
  }

  
  // second login content
  $options = array(
      'guid' => $id,
      'metadata_name' => "welcomer_message_".$id,
      'limit' => 0
  );
  $metadata = elgg_get_metadata($options);
  
  if($metadata[0]->value){
    // nothing is currently set for the current installation
    // we have existing info from 1.7, so we'll import it
    elgg_set_plugin_setting('secondlogincontent', $metadata[0]->value, 'welcomer');
  }
  
  // second login enable
  $options = array(
      'guid' => $id,
      'metadata_name' => "welcomer_switcher_message_".$id,
      'limit' => 0
  );
  $metadata = elgg_get_metadata($options);
  
  if($metadata[0]->value){
    elgg_set_plugin_setting('secondlogin', 'yes', 'welcomer');
  }
  else{
    elgg_set_plugin_setting('secondlogin', 'no', 'welcomer');
  }
}

