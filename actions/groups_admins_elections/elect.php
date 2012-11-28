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

elgg_load_library('groups_admins_elections:utilities');
$elected = gae_perform_election($mandat, 'random', $user_guid, false);

if ($elected) {
	$user_elected = get_entity($elected->owner_guid);
	system_message(elgg_echo('groups_admins_elections:elect:success', array($user_elected->name)));
	
	add_to_river('river/object/elected/create','create', $user_guid, $elected->guid);

	forward($elected->getURL());
} else {
	forward(REFERER);
}