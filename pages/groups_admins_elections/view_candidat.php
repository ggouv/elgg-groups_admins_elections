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

$candidat_guid = (int)get_input('guid');
$candidat = get_entity($candidat_guid);

elgg_set_page_owner_guid($candidat->container_guid);
$container = elgg_get_page_owner_entity();
$mandat = get_entity($candidat->mandat_guid);
$candidat_user = get_entity($candidat->owner_guid);

if (!$candidat || !$container) {
	register_error(elgg_echo('groups_admins_elections:view:error'));
	forward(REFERER);
}

$title = elgg_echo('groups_admins_elections:candidat:title', array($candidat_user->name));

elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');
elgg_push_breadcrumb($container->name, "elections/group/{$container->guid}/mandats");
elgg_push_breadcrumb($mandat->title, "elections/mandat/view/{$mandat->guid}/{$mandat->title}");
elgg_push_breadcrumb(elgg_echo('groups_admins_elections:candidats'), "elections/mandat/candidats/{$mandat->guid}/{$mandat->title}");
elgg_push_breadcrumb($candidat_user->name);

$content = elgg_view_entity($candidat, array('full_view' => true));
$content .= elgg_view_comments($candidat);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => 'auie' . elgg_view('groups_admins_elections/sidebar'),
));

echo elgg_view_page($title, $body);
