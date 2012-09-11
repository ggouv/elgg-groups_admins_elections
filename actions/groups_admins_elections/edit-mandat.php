<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections mandat edit/add action
 *
 */

gatekeeper();

elgg_make_sticky_form('mandat');

$title = strip_tags(get_input('title'));
$description = get_input('description');
$duration = (int)get_input('duration');
$guid = (int)get_input('guid');
$container_guid = (int)get_input('container_guid', elgg_get_page_owner_guid());

$user_guid = elgg_get_logged_in_user_guid();

if (!$container_guid) {
	register_error(elgg_echo('groups_admins_elections:mandat:save:fail'));
	forward(REFERER);
}

$group = get_entity($container_guid);

if (!$group || !$group->canEdit()) {
	register_error(elgg_echo('groups_admins_elections:mandat:save:fail'));
	forward(REFERER);
}

if (!$title || !$description ) {
	register_error(elgg_echo('groups_admins_elections:mandat:save:empty'));
	forward(REFERER);
}

if (!$guid) {
	$mandat = new ElggObject;
	$mandat->subtype = 'mandat';
	$mandat->container_guid = $container_guid;
	$new = true;
} else {
	$mandat = get_entity($guid);
}

$mandat->title = $title;
$mandat->description = $description;
$mandat->container_guid = $container_guid;
$mandat->access_id = $group->access_id;
$mandat->duration = $duration;

if ($mandat->save()) {

	elgg_clear_sticky_form('mandat');

	system_message(elgg_echo('groups_admins_elections:mandat:save:success'));

	add_to_river('river/object/mandat/create','create', $user_guid, $mandat->getGUID());

	forward($mandat->getURL());
} else {
	register_error(elgg_echo('groups_admins_elections:mandat:save:fail'));
	forward(REFERER);
}
