<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections group mandats view
 *
 */

// access check for closed groups
group_gatekeeper();

$group_guid = get_input('guid', elgg_get_page_owner_entity());
$group = get_entity($group_guid);
$user = elgg_get_logged_in_user_entity();

if (!$group || $group->type != 'group') {
	register_error(elgg_echo('groups_admins_elections:mandats:failed'));
	forward(REFERER);
}

elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');
elgg_push_breadcrumb($group->name);

if ($group->canEdit()) {
	elgg_register_menu_item('title', array(
		'name' => 'groups_admins_elections_mandats_add',
		'href' => "elections/add/$group->guid",
		'text' => elgg_echo('groups_admins_elections:mandats:add'),
		'link_class' => 'elgg-button elgg-button-action group_admin_only gwfb',
	));
}

$title = elgg_echo('groups_admins_elections:mandats', array($group->name));

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'mandat',
	'container_guid' => $group->guid,
	'limit' => 0,
	'full_view' => false
));

if (!$content) {
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
