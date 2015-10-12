<?php

namespace AU\Welcomer;

// toggle first login page
echo '<div class="welcomer_fieldset">';
$options = array(
	'name' => 'params[firstlogin]',
	'value' => $vars['entity']->firstlogin ? $vars['entity']->firstlogin : 'no',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
);
echo elgg_echo('welcomer:activate:firstlogin') . "<br>";
echo elgg_view('input/select', $options) . "<br><br>";


// first login page content
$options = array(
	'name' => 'params[firstlogincontent]',
	'value' => $vars['entity']->firstlogincontent,
);
echo elgg_echo('welcomer:firstlogin:content') . "<br>";
echo elgg_view('input/longtext', $options) . "<br><br>";
echo "</div>";


// toggle second login page
echo '<div class="welcomer_fieldset">';
$options = array(
	'name' => 'params[secondlogin]',
	'value' => $vars['entity']->secondlogin ? $vars['entity']->secondlogin : 'no',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
);
echo elgg_echo('welcomer:activate:secondlogin') . "<br>";
echo elgg_view('input/select', $options) . "<br><br>";


// second login page content
$options = array(
	'name' => 'params[secondlogincontent]',
	'value' => $vars['entity']->secondlogincontent,
);
echo elgg_echo('welcomer:secondlogin:content') . "<br>";
echo elgg_view('input/longtext', $options) . "<br><br>";
echo "</div>";


if (elgg_is_active_plugin('notifications')) {
	echo '<div class="welcomer_fieldset">';
	echo elgg_echo('nextlogin_notifications:description') . "<br><br>";

	// toggle next login notification
	$options = array(
		'name' => 'params[nextlogin_notification]',
		'value' => $vars['entity']->nextlogin_notification ? $vars['entity']->nextlogin_notification : 'no',
		'options_values' => array(
			'yes' => elgg_echo('option:yes'),
			'no' => elgg_echo('option:no')
		),
	);
	echo elgg_echo('welcomer:activate:nextlogin_notification') . "<br>";
	echo elgg_view('input/select', $options) . "<br><br>";

	// next login notification subject
	$options = array(
		'name' => 'params[nextlogin_notification_subject]',
		'value' => $vars['entity']->nextlogin_notification_subject,
	);
	echo elgg_echo('welcomer:nextlogin_notification_content:subject') . "<br>";
	echo elgg_view('input/text', $options) . "<br><br>";


	// next login notification content
	$options = array(
		'name' => 'params[nextlogin_notification_content]',
		'value' => $vars['entity']->nextlogin_notification_content,
	);
	echo elgg_echo('welcomer:nextlogin_notification_content:content') . "<br>";
	echo elgg_view('input/longtext', $options) . "<br><br>";
	echo "</div>";
}