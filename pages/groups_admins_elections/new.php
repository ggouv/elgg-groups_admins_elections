<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections new view
 *
 */

// access check for closed groups
group_gatekeeper();

$entity_guid = (int)get_input('guid');
$container = elgg_get_page_owner_entity();

$user = elgg_get_logged_in_user_entity();
$entity = get_entity($entity_guid);

if (!$entity) {

	register_error(elgg_echo('groups_admins_elections:edit:failed'));
	forward(REFERER);
	
} else if ($entity->type == 'group') {

	if (!$container || $container->type != 'group') {
		register_error(elgg_echo('groups_admins_elections:group:failed'));
		forward(REFERER);
	}
	
	if (!$container->canEdit()) {
		register_error(elgg_echo('groups_admins_elections:edit:failed'));
		forward(REFERER);
	}

	elgg_push_breadcrumb('groups_admins_elections:mandats');
	elgg_push_breadcrumb($container->name, "elections/group/{$container->guid}/mandats");
	elgg_push_breadcrumb('groups_admins_elections:mandat:new');
	
	$title = elgg_echo('groups_admins_elections:mandat:title:new');
	
	$vars = mandat_prepare_form_vars();
	$content = elgg_view_form('groups_admins_elections/edit-mandat', array(), $vars);
	
} else if ($entity->subtype == get_subtype_id('object', 'mandat')) {

	$group = get_entity($entity->container_guid);
	
	if (!$group || $group->type != 'group') {
		register_error(elgg_echo('groups_admins_elections:group:failedbbb'));
		forward(REFERER);
	}
	
	if (!$group->canWritetoContainer()) {
		register_error(elgg_echo('groups_admins_elections:edit:failed'));
		forward(REFERER);
	}
	
	elgg_push_breadcrumb('groups_admins_elections:candidats');
	elgg_push_breadcrumb($entity->title, $entity->getURL());
	elgg_push_breadcrumb('groups_admins_elections:candidat:new');
	
	$title = elgg_echo('groups_admins_elections:candidat:title:new');
	
	$vars = candidat_prepare_form_vars();
	$content = elgg_view_form('groups_admins_elections/edit-candidat', array(), $vars);

} else {

	register_error(elgg_echo('groups_admins_elections:edit:failed'));
	forward(REFERER);
	
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);