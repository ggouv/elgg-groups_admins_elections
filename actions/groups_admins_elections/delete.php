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
$group = get_entity($entity->container_guid);

if (!$entity) {
	system_message(elgg_echo('groups_admins_elections:delete:failed'));
	forward(REFERRER);
}

if ($entity->canEdit()) {

	if ($entity->subtype == get_subtype_id('object', 'mandat')) { // if mandat is deleted, delete all candidats for this mandat
		$candidats = elgg_get_entities_from_metadata(array(
			'type' => 'object',
			'subtypes' => 'candidat',
			'metadata_name' => 'mandat_guid',
			'metadata_value' => $entity_guid
		));
		foreach ($candidats as $candidat) {
			delete_entity($candidat->guid);
		}
	}
	delete_entity($entity_guid);
	
	system_message(elgg_echo('groups_admins_elections:delete:success'));
	forward($group->getURL());
}

register_error(elgg_echo('groups_admins_elections:delete:failed'));
forward(REFERER);
