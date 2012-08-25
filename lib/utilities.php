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