<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Page mandat view
 *
 */

$mandat_guid = (int)get_input('guid');
$mandat = get_entity($mandat_guid);

elgg_set_page_owner_guid($mandat->container_guid);
$container = elgg_get_page_owner_entity();
$filter_context = elgg_get_context();

$user_guid = elgg_get_logged_in_user_guid();

if (!$user_guid || !$mandat || !$container || !in_array($filter_context, array('view', 'candidats', 'history'))) {
	register_error(elgg_echo('groups_admins_elections:view:error'));
	forward(REFERER);
}

$title = $mandat->title;

elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandats'), 'elections/all');
elgg_push_breadcrumb($container->name, "elections/mandats/{$container->guid}/{$container->name}");

$candidated = gae_check_user_can_candidate($mandat, $user_guid);

if ($container->canWritetoContainer() && $candidated === true) {
	elgg_register_menu_item('title', array(
		'name' => 'groups_admins_elections_candidats_add',
		'href' => "elections/add/$mandat_guid",
		'text' => elgg_echo('groups_admins_elections:candidats:add'),
		'link_class' => 'elgg-button elgg-button-action gwfb',
	));
} else if ($container->canWritetoContainer() && $candidated) {
	elgg_register_menu_item('title', array(
		'name' => 'groups_admins_elections_candidat_mine',
		'href' => $candidated->getURL() . $candidated->getOwnerEntity()->name,
		'text' => elgg_echo('groups_admins_elections:candidat:mine'),
		'link_class' => 'elgg-button elgg-button-action gwfb',
	));
}

if ($container->canEdit() && gae_get_candidats($mandat->guid, true) >= 3) {
	elgg_register_menu_item('title', array(
		'name' => 'groups_admins_elections_mandats_elect',
		'href' => elgg_add_action_tokens_to_url("action/elections/elect?guid=$mandat_guid"),
		'text' => elgg_echo('groups_admins_elections:mandats:elect'),
		'confirm' => elgg_echo('groups_admins_elections:mandats:do_elect'),
		'link_class' => 'elgg-button elgg-button-action group_admin_only gwfb',
	));
}

if ($filter_context == 'view') {

	elgg_push_breadcrumb($title);

	$content = elgg_view_entity($mandat, array('full_view' => true));
	$content .= elgg_view_comments($mandat);

} else if ($filter_context == 'candidats') {
	
	elgg_push_breadcrumb($mandat->title, "elections/mandat/view/{$mandat->guid}/{$mandat->title}");
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:candidats'));
	
	$content = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => 'candidat',
		'metadata_name' => 'mandat_guid',
		'metadata_value' => $mandat->guid,
		'limit' => 30,
		'full_view' => false,
		'pagination' => true
	));
	if (!$content) $content = elgg_echo('groups_admins_elections:candidats:none');
} else if ($filter_context == 'history') {

	elgg_push_breadcrumb($mandat->title, "elections/mandat/view/{$mandat->guid}/{$mandat->title}");
	elgg_push_breadcrumb(elgg_echo('groups_admins_elections:mandat:history'));
	
	$content = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => 'elected',
		'metadata_name' => 'mandat_guid',
		'metadata_value' => $mandat->guid,
		'order_by' => 'time_updated desc',
		'limit' => 30,
		'full_view' => false,
		'pagination' => true
	));
	if (!$content) $content = elgg_echo('groups_admins_elections:elected:none');
} else {
	register_error(elgg_echo('groups_admins_elections:view:error'));
	forward(REFERER);
}

$body = elgg_view_layout('content', array(
	'filter_override' => elgg_view('groups_admins_elections/filters/mandat_filter', array('mandat' => $mandat)),
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('groups_admins_elections/sidebar'),
));

echo elgg_view_page($title, $body);
