<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections candidat edit/add action
 *
 */

gatekeeper();

elgg_make_sticky_form('candidat');

$description = get_input('description');
$guid = (int)get_input('guid');
$mandat_guid = (int)get_input('mandat_guid');

$user_guid = elgg_get_logged_in_user_guid();

if (!$mandat_guid) {
	register_error(elgg_echo('groups_admins_elections:candidat:save:fail'));
	forward(REFERER);
}
$mandat = get_entity($mandat_guid);
$group = get_entity($mandat->container_guid);

if (!$group || !$group->canWritetoContainer()) {
	register_error(elgg_echo('groups_admins_elections:candidat:group:fail'));
	forward(REFERER);
}

$candidated = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'candidat',
	'owner_guid' => $user_guid,
	'metadata_name' => 'mandat_guid',
	'metadata_value' => $mandat->guid,
	'limit' => 0,
	'count' => true
));

if ($candidats_count >= 1) {
	register_error(elgg_echo('groups_admins_elections:candidat:already_candidat'));
	forward(REFERER);
}

if (!$description ) {
	register_error(elgg_echo('groups_admins_elections:candidat:save:empty'));
	forward(REFERER);
}

if (!$guid) {
	$candidat = new ElggObject;
	$candidat->subtype = 'candidat';
	$candidat->container_guid = $mandat->container_guid;
	$candidat->mandat_guid = $mandat->guid;
	$candidat->access_id = $group->access_id;
	$new = true;
} else {
	$candidat = get_entity($guid);
}

$candidat->description = $description;

if ($candidat->save()) {

	elgg_clear_sticky_form('candidat');

	system_message(elgg_echo('groups_admins_elections:candidat:save:success'));

	if ($new) {
		add_to_river('river/object/candidat/create','create', $user_guid, $candidat->getGUID());
	}
	
	forward($candidat->getURL());
} else {
	register_error(elgg_echo('groups_admins_elections:candidat:save:fail'));
	forward(REFERER);
}
