<?php
/**
 * Elgg friends page
 *
 * @package Elgg.Core
 * @subpackage Social.Friends
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	// unknown user so send away (@todo some sort of 404 error)
	forward('activity');
}

$title = elgg_echo("friends:owned", array($owner->name));

$options = array(
	'relationship' => 'friend',
	'relationship_guid' => $owner->getGUID(),
	'inverse_relationship' => FALSE,
	'type' => 'user',
	'full_view' => FALSE,
	'item_class'=>'elgg-col-1of4 fl',
);
$content = elgg_list_entities_from_relationship($options);
if (!$content) {
	$content = elgg_echo('friends:none');
}

$params = array(
	'content' => $content,
	'title' => $title,
);
$body = elgg_view_layout('home_two_column', $params);

echo elgg_view_page($title, $body);
