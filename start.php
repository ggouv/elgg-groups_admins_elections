<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 **/

elgg_register_event_handler('init', 'system', 'groups_admins_elections_init');

/**
 * Initialize elgg-groups_admins_elections plugin.
 */
function groups_admins_elections_init() {

	// register a library of helper functions
	$root = dirname(__FILE__);
	elgg_register_library('groups_admins_elections:utilities', "$root/lib/utilities.php");

	// register global menu

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('elections', 'groups_admins_elections_handler');

	// Register URL handler

	// Extend view
	elgg_extend_view('css/elgg', 'groups_admins_elections/css');
	elgg_extend_view('js/elgg', 'groups_admins_elections/js');

	elgg_extend_view('groups/profile/summary', 'groups_admins_elections/list_mandats');

	// add to groups

	// actions
	$action_base = "$root/actions/groups_admins_elections";
	elgg_register_action('elections/edit-mandat', "$action_base/edit-mandat.php");
	elgg_register_action('elections/edit-candidat', "$action_base/edit-candidat.php");
	elgg_register_action('elections/elect', "$action_base/elect.php");

	// Register entity type

	// Register a URL handler for mandat and candidat
	elgg_register_entity_url_handler('object', 'mandat', 'mandat_url');
	elgg_register_entity_url_handler('object', 'candidat', 'candidat_url');

	// Register entity menu

}

/**
 * Dispatcher for elgg-groups_admins_elections plugin.
 * URLs take the form of :
 *
 * @param array $page
 */
function groups_admins_elections_handler($page) {
	elgg_load_library('groups_admins_elections:utilities');
	
	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	//elgg_push_breadcrumb(elgg_echo('workflow'), 'workflow/all');

	$base_dir = dirname(__FILE__) . '/pages/groups_admins_elections';

	switch ($page[0]) {
		default:
		case 'all':
			include "$base_dir/world.php";
			break;
		case 'mandat':
			elgg_set_context($page[1]);
			set_input('guid', $page[2]);
			include "$base_dir/view_mandat.php";
			break;
		case 'candidat':
			set_input('guid', $page[1]);
			include "$base_dir/view_candidat.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			switch ($page[2]) {
				case 'mandats';
					include "$base_dir/mandats.php";
					break;
				case 'candidats';
					include "$base_dir/group.php";
					break;
			}
			break;
	}

	elgg_pop_context();

	return true;
}


/**
 * Populates the ->getUrl() method for mandat objects
 *
 * @param ElggEntity $entity The mandat object
 * @return string mandat item URL
 */
function mandat_url($entity) {
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return elgg_get_site_url() . "elections/mandat/view/" . $entity->getGUID() . "/" . $title;
}


/**
 * Populates the ->getUrl() method for candidat objects
 *
 * @param ElggEntity $entity The candidat object
 * @return string candidat item URL
 */
function candidat_url($entity) {
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return elgg_get_site_url() . "elections/candidat/" . $entity->getGUID() . "/" . $title;
}