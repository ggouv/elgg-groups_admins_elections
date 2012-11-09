<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections lib
 *
 */

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $mandat A mandat object.
 * @return array
 */
function mandat_prepare_form_vars($mandat = null) {
	$user = elgg_get_logged_in_user_guid();
	
	$values = array(
		'title' => get_input('title', ''),
		'description' => '',
		'duration' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
	);

	if ($mandat) {
		foreach (array_keys($values) as $field) {
			if (isset($mandat->$field)) {
				$values[$field] = $mandat->$field;
			}
		}
	}

	if (elgg_is_sticky_form('mandat')) {
		$sticky_values = elgg_get_sticky_values('mandat');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('mandat');

	return $values;
}


/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $mandat A candidat object.
 * @return array
 */
function candidat_prepare_form_vars($candidat = null) {

	$values = array(
		'description' => '',
		'mandat_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
	);

	if ($candidat) {
		foreach (array_keys($values) as $field) {
			if (isset($candidat->$field)) {
				$values[$field] = $candidat->$field;
			}
		}
	}

	if (elgg_is_sticky_form('candidat')) {
		$sticky_values = elgg_get_sticky_values('candidat');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('candidat');

	return $values;
}


/**
 * Prepare date for output
 *
 * @param integer $date timestamp of metadata "end_mandat" of Object mandat 
 * @return array
 */
function gae_get_date_next_election($date, $echo = 'groups_admins_elections:mandat:next_election_date') {
	$mandat_next_election = strftime(elgg_echo($echo), $date);
		
	if ($date < time()) {
		return '<span class="election-overdue">' . $mandat_next_election . '</span>';
	} else {
		return $mandat_next_election;
	}
}


/**
 * Get all candidats for a mandat
 *
 * @param int $mandat_guid GUID of the mandat 
 * @return array(ElggUsers) candidats
 */
function gae_get_candidats($mandat_guid, $count = false) {
	return elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => 'candidat',
		'metadata_name' => 'mandat_guid',
		'metadata_value' => $mandat_guid,
		'limit' => 0,
		'count' => $count ? true : false,
	));
}


/**
 * Get current elected for a mandat
 *
 * @param int $mandat_guid GUID of the mandat 
 * @return array(ElggObject) elected
 */
function gae_get_elected($mandat_guid) {
	$current_elected = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => 'elected',
		'metadata_name' => 'mandat_guid',
		'metadata_value' => $mandat_guid,
		'order_by' => 'time_updated desc',
		'limit' => 1,
	));
	if ($current_elected) {
		return $current_elected[0];
	} else {
		return false;
	}
}


/**
 * Check if an user can be candidat
 *
 * @param ElggObject $mandat the mandat
 * @param int $user_guid GUID of the user (default logged in user)
 * @return array(ElggUser) candidated or true if can or false if already mandated
 */
function gae_check_user_can_candidate($mandat, $user_guid = null) {
	if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();
	
	// is mandated in the group ?
	if (check_entity_relationship($user_guid, 'elected_in', $mandat->container_guid)) {
		return false;
	}
	// Already candidat ?
	$candidated = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'candidat',
		'owner_guid' => $user_guid,
		'metadata_name' => 'mandat_guid',
		'metadata_value' => $mandat->guid,
		'limit' => 0,
	));
	if (is_array($candidated) && count($candidated) >= 1) return $candidated[0];
	
	return true;
}


/**
 * Perform election
 *
 * @param ElggObject $mandat mandat to perform election
 * @param int $triggered_by GUID of user who perform election
 * @param bool $first_election (default false) set true if this is the first election for this mandat
 * @return ElggUser candidat elected
 */
function gae_perform_election($mandat, $triggered_by, $first_election = false) {
	global $CONFIG;
	
	$group = get_entity($mandat->container_guid);
	
	$candidats = gae_get_candidats($mandat->guid);

	$count_candidats = count($candidats);
	if ($count_candidats < 3) { // @todo put in settings ?
		return false;
	}
	
	$current_elected = gae_get_elected($mandat->guid);
	
	// make sorted election
	shuffle($candidats); // randomizes the order of the elements in the array
	$elected = $candidats[mt_rand(0, $count_candidats-1)]; // get a random item
	
	$subtype_id = add_subtype('object', 'elected');
	$time = time();
	
	$user_elected = get_entity($elected->owner_guid);
	$message = elgg_echo('river_elected_message', array('@' . $user_elected->name, $count_candidats));
	if ($first_election) $message .= '<span class="elgg-subtext">&nbsp;' . elgg_echo('river_elected_message:first_election') . '</span>';
	$description = $message . $elected->description;
	
	$result = update_data("UPDATE {$CONFIG->dbprefix}entities
							SET subtype = '$subtype_id', time_updated = $time, last_action = $time
							WHERE {$CONFIG->dbprefix}entities.guid = {$elected->guid}");
	
	$result2 = update_data("UPDATE {$CONFIG->dbprefix}objects_entity
							SET description = '$description'
							WHERE {$CONFIG->dbprefix}objects_entity.guid = {$elected->guid}");
	
	if ($result && $result2) {
		create_metadata($elected->guid, 'end_mandat', $time + ($mandat->duration * 24 * 60 * 60), 'integer', $elected->owner_guid, 2);
		create_metadata($elected->guid, 'nbr_candidats', $count_candidats, 'integer', $elected->owner_guid, 2);
		if ($first_election) create_metadata($elected->guid, 'first_election', true, $elected->owner_guid, 2);
		$elected->addRelationship($triggered_by, 'election_triggered_by');
		
		remove_entity_relationship($current_elected->owner_guid, 'elected_in', $group->guid);
		$user_elected->addRelationship($group->guid, 'elected_in');
	
		return $elected;
	} else {
		register_error(elgg_echo('groups_admins_elections:elect:fail'));
		return false;
	}
}