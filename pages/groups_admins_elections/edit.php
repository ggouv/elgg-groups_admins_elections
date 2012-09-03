<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections edit view
 *
 */

// access check for closed groups
group_gatekeeper();

$entity_guid = (int)get_input('guid');
$group = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();

$entity = get_entity($entity_guid);

if (!$group || $group->type != 'group') {
	register_error(elgg_echo('groups_admins_elections:group:failed'));
	forward(REFERER);
}

if (!$group->canEdit()) {
	register_error(elgg_echo('groups_admins_elections:edit:failed1'));
	forward(REFERER);
}

if (!$entity) {
	register_error(elgg_echo('groups_admins_elections:edit:failed2'));
	forward(REFERER);
} else if ($entity->subtype == get_subtype_id('object', 'mandat')) {
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');
	elgg_push_breadcrumb($group->name, "elections/group/{$group->guid}/mandats");
	elgg_push_breadcrumb($entity->title, "elections/mandat/view/{$entity->guid}/{$entity->title}");
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandat:edit'));
	
	$title = elgg_echo('groups_admins_elections:mandat:title:edit', array($entity->title));

	$vars = mandat_prepare_form_vars($entity);
	$content = elgg_view_form('elections/edit-mandat', array(), $vars);
} else if ($entity->subtype == get_subtype_id('object', 'candidat')) {
	$mandat = get_entity($entity->mandat_guid);
	$owner = get_entity($entity->owner_guid);
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');
	elgg_push_breadcrumb($group->name, "elections/group/{$group->guid}/mandats");
	elgg_push_breadcrumb($mandat->title, "elections/mandat/view/{$entity->mandat_guid}/{$mandat->title}");
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:candidats'), "elections/mandat/candidats/{$entity->mandat_guid}/{$mandat->title}");
	elgg_push_breadcrumb($owner->name, $entity->getURL());
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:candidat:edit'));
	
	$title = elgg_echo('groups_admins_elections:candidat:title:edit', array($owner->name));
	
	$vars = candidat_prepare_form_vars($entity);
	$content = elgg_view_form('elections/edit-candidat', array(), $vars);
} else {
	register_error(elgg_echo('groups_admins_elections:edit:failed3'));
	forward(REFERER);
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);