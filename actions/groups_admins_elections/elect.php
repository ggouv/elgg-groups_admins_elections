<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections mandat elect action
 *
 */

gatekeeper();

$mandat_guid = (int)get_input('guid');
$mandat = get_entity($mandat_guid);

$user_guid = elgg_get_logged_in_user_guid();

if (!$mandat) {
	register_error(elgg_echo('groups_admins_elections:elect:fail'));
	forward(REFERER);
}

$group = get_entity($mandat->container_guid);

if (!$group || !$group->canEdit()) {
	register_error(elgg_echo('groups_admins_elections:elect:fail'));
	forward(REFERER);
}

$candidats = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtypes' => 'candidat',
	'metadata_name' => 'mandat_guid',
	'metadata_value' => $mandat->guid,
	'limit' => 0,
));

if (count($candidats) < 3) { // @todo put in settings ?
	register_error(elgg_echo('groups_admins_elections:mandat:not_enougth_candidats'));
	forward(REFERER);
}

// make sorted election
shuffle($candidats); // randomizes the order of the elements in the array
$elected_now = $candidats[mt_rand(0, count($candidats)-1)]; // get a random item


$elected = new ElggObject;
$elected->subtype = 'elected';
$elected->container_guid = $group->guid;
$elected->owner_guid = $elected_now->owner_guid;
$elected->mandat_guid = $mandat->guid;
$elected->access_id = $group->access_id;
$elected->end_mandat = time() + ($mandat->duration * 24 * 60 * 60);
$elected->description = $elected_now->description;
$elected->nbr_candidats = count($candidats);
$elected->election_triggered_by = $user_guid;

if ($elected->save()) {

	delete_entity($elected_now->guid);

	$user_elected = get_entity($elected->owner_guid);
	system_message(elgg_echo('groups_admins_elections:elect:success', array($user_elected->name)));
	
	add_to_river('river/object/elected/create','create', $elected->owner_guid, $elected->getGUID());
	
	forward("elections/mandat/history/{$mandat->guid}/{$mandat->title}");
} else {
	register_error(elgg_echo('groups_admins_elections:elect:fail'));
	forward(REFERER);
}

/*
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

	forward(elgg_get_site_url() . "elections/group/$container_guid/mandats");
} else {
	register_error(elgg_echo('groups_admins_elections:mandat:save:fail'));
	forward(REFERER);
}*/
