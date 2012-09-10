<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Object elected view
 *
 */

$elected_guid = (int)get_input('guid');
$elected = get_entity($elected_guid);

elgg_set_page_owner_guid($elected->container_guid);
$container = elgg_get_page_owner_entity();
$mandat = get_entity($elected->mandat_guid);
$elected_user = get_entity($elected->owner_guid);

if (!$elected || !$container) {
	register_error(elgg_echo('groups_admins_elections:view:error'));
	forward(REFERER);
}

$elected_now = gae_get_elected($mandat->guid);
if ($elected == $elected_now) {
	$title = elgg_echo('groups_admins_elections:elected_now:title', array(strftime(elgg_echo('groups_admins_elections:elected:date'), $elected->time_created)));
} else {
	$title = elgg_echo('groups_admins_elections:elected:title', array(strftime(elgg_echo('groups_admins_elections:elected:date'), $elected->time_created), strftime(elgg_echo('groups_admins_elections:elected:date'), $elected->time_updated)));
}

elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');
elgg_push_breadcrumb($container->name, "elections/mandats/{$container->guid}/{$container->name}");
elgg_push_breadcrumb($mandat->title, "elections/mandat/view/{$mandat->guid}/{$mandat->title}");
elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandat:history'), "elections/mandat/history/{$mandat->guid}/{$mandat->title}");
elgg_push_breadcrumb($elected_user->name);

$content = elgg_view_entity($elected, array('full_view' => true));
$content .= elgg_view_comments($elected);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => 'auie' . elgg_view('groups_admins_elections/sidebar'),
));

echo elgg_view_page($title, $body);
