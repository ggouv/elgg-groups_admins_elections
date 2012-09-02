<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Extend groups profile summary view file
 *
 **/

$group_guid = elgg_get_page_owner_guid();

/*echo "<a href='" . elgg_get_site_url() . "elections/group/$container_guid/mandats' class='elgg-button elgg-button-action'>admins page</a>";*/

$list_mandats = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'mandat',
	'container_guid' => $group_guid,
));

foreach ($list_mandats as $item) {
	$html .= "<li id=\"elgg-{$item->getType()}-{$item->getGUID()}\" class='mandats'>";
	$html .= elgg_view_list_item($item, array('full_view' => 'in_group_profile'));
	$html .= '</li>';
}
echo $html;
