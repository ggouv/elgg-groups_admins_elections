<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections group view
 *
 */

$group = elgg_get_page_owner_entity();
$user_guid = elgg_get_logged_in_user_guid();

if (!$group || $group->type != 'group') {
	forward(REFERER);
}

// access check for closed groups
group_gatekeeper();

elgg_push_breadcrumb('groups_admins_elections:mandats');
elgg_push_breadcrumb($group->name);

elgg_register_title_button();

$title = elgg_echo('groups_admins_elections:owner', array($group->name));

$boards = elgg_get_entities(array(
	'type' => 'object',
	'subtypes' => 'mandat',
	'container_guid' => $group->guid,
	'limit' => 0
));


if (!$boards) {
	$content = elgg_echo('groups_admins_elections:list:none');
}

$sidebar .= elgg_view('groups_admins_elections/sidebar');

$params = array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
