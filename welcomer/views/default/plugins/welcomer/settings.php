<?php

// toggle first login page
$options = array(
    'name' => 'params[firstlogin]',
    'value' => $vars['entity']->firstlogin ? $vars['entity']->firstlogin : 'no',
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    ),
);
echo elgg_echo('welcomer:activate:firstlogin') . "<br>";
echo elgg_view('input/dropdown', $options) . "<br><br>";


// first login page content
$options = array(
    'name' => 'params[firstlogincontent]',
    'value' => $vars['entity']->firstlogincontent,
);
echo elgg_echo('welcomer:firstlogin:content') . "<br>";
echo elgg_view('input/longtext', $options) . "<br><br>";


// toggle second login page
$options = array(
    'name' => 'params[secondlogin]',
    'value' => $vars['entity']->secondlogin ? $vars['entity']->secondlogin : 'no',
    'options_values' => array(
        'yes' => elgg_echo('option:yes'),
        'no' => elgg_echo('option:no')
    ),
);
echo elgg_echo('welcomer:activate:secondlogin') . "<br>";
echo elgg_view('input/dropdown', $options) . "<br><br>";


// second login page content
$options = array(
    'name' => 'params[secondlogincontent]',
    'value' => $vars['entity']->secondlogincontent,
);
echo elgg_echo('welcomer:secondlogin:content') . "<br>";
echo elgg_view('input/longtext', $options) . "<br><br>";