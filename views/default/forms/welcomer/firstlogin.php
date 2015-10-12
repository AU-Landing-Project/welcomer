<?php

namespace AU\Welcomer;

$options = array(
  'name' => 'submit',
  'value' => elgg_echo('welcomer:firstlogin:continue'),
);

echo elgg_view('input/submit', $options);