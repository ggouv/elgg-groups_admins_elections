<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Object mandat view
 *
 */

$mandat_guid = (int)get_input('guid');
$mandat = get_entity($mandat_guid);

$container = elgg_get_page_owner_entity();

if (!$mandat || !$container) {
	register_error(elgg_echo('groups_admins_elections:view:error'));
	forward(REFERER);
}

$title = $mandat->title;

elgg_push_breadcrumb('groups_admins_elections:mandats', 'elections/all');
elgg_push_breadcrumb($container->name, "elections/group/{$container->guid}/mandats");
elgg_push_breadcrumb($title);

if ($container->canWritetoContainer()) {
	elgg_register_menu_item('title', array(
		'name' => 'groups_admins_elections_candidats_add',
		'href' => "elections/candidats/add/$mandat_guid",
		'text' => elgg_echo('groups_admins_elections:candidats:add'),
		'link_class' => 'elgg-button elgg-button-action gwfb',
	));
}

$content = elgg_view_entity($mandat, array('full_view' => true));
$content .= elgg_view_comments($mandat);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => 'auie' . elgg_view('groups_admins_elections/sidebar'),
));

echo elgg_view_page($title, $body);
