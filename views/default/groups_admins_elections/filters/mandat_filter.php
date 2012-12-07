<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Filter for mandat view
 *
 */

$mandat = elgg_extract('mandat', $vars, false);
$filter_context = elgg_get_context();

$tabs = array(
	'view' => array(
		'text' => elgg_echo('groups_admins_elections:mandat'),
		'href' => "elections/mandat/view/{$mandat->guid}/{$mandat->title}",
		'selected' => ($filter_context == 'view'),
		'priority' => 200,
	),
	'candidats' => array(
		'text' => elgg_echo('groups_admins_elections:candidats'),
		'href' => "elections/mandat/candidats/{$mandat->guid}/{$mandat->title}",
		'selected' => ($filter_context == 'candidats'),
		'priority' => 300,
	),
	'history' => array(
		'text' => elgg_echo('groups_admins_elections:mandat:history'),
		'href' => "elections/mandat/history/{$mandat->guid}/{$mandat->title}",
		'selected' => ($filter_context == 'history'),
		'priority' => 400,
	),
);

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;
	
	elgg_register_menu_item('filter', $tab);
}

echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
