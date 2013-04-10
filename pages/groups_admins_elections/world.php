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

elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');

$title = elgg_echo('groups_admins_elections:mandats:all');

elgg_push_breadcrumb($title);

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'mandat',
	'limit' => 30,
	'full_view' => false,
	'pagination' => true
));

if (!$content) {
	$content = elgg_echo('groups_admins_elections:list:none');
}

$sidebar = elgg_view('groups_admins_elections/sidebar');

$params = array(
	'filter' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
