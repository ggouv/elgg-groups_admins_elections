<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections candidat/mandat delete action
 *
 */

$entity_guid = get_input('guid');

$entity = get_entity($entity_guid);

if (!$entity) {
	system_message(elgg_echo('groups_admins_elections:delete:failed'));
	forward(REFERRER);
}

if ($entity->canEdit()) {

	delete_entity($entity_guid);
	
	system_message(elgg_echo('groups_admins_elections:delete:success'));
	forward(REFERER);
}

register_error(elgg_echo('groups_admins_elections:delete:failed'));
forward(REFERER);
