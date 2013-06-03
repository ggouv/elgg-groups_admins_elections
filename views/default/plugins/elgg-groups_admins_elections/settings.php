<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections settings
 *
 */

// set default value

$default_mandat_description_guid__string = elgg_echo('groups_admins_elections:mandat:default:description');
$default_mandat_description_guid__view = elgg_view('input/text', array(
	'name' => 'params[default_mandat_description_guid_]',
	'value' => $vars['entity']->default_mandat_description_guid_,
	'class' => 'elgg-input-thin',
));

$default_mandat_description_guid_localgroup_string = elgg_echo('groups_admins_elections:mandat:default:description') . ' localgroup';
$default_mandat_description_guid_localgroup_view = elgg_view('input/text', array(
	'name' => 'params[default_mandat_description_guid_localgroup]',
	'value' => $vars['entity']->default_mandat_description_guid_localgroup,
	'class' => 'elgg-input-thin',
));

$default_mandat_description_guid_metagroup_string = elgg_echo('groups_admins_elections:mandat:default:description') . ' metagroup';
$default_mandat_description_guid_metagroup_view = elgg_view('input/text', array(
	'name' => 'params[default_mandat_description_guid_metagroup]',
	'value' => $vars['entity']->default_mandat_description_guid_metagroup,
	'class' => 'elgg-input-thin',
));

$default_mandat_description_guid_typogroup_string = elgg_echo('groups_admins_elections:mandat:default:description') . ' typogroup';
$default_mandat_description_guid_typogroup_view = elgg_view('input/text', array(
	'name' => 'params[default_mandat_description_guid_typogroup]',
	'value' => $vars['entity']->default_mandat_description_guid_typogroup,
	'class' => 'elgg-input-thin',
));

// display html

echo <<<__HTML
<br />
<div><label>$default_mandat_description_guid__string</label><br />$default_mandat_description_guid__view</div>

<div><label>$default_mandat_description_guid_localgroup_string</label><br />$default_mandat_description_guid_localgroup_view</div>
<div><label>$default_mandat_description_guid_metagroup_string</label><br />$default_mandat_description_guid_metagroup_view</div>
<div><label>$default_mandat_description_guid_typogroup_string</label><br />$default_mandat_description_guid_typogroup_view</div>
__HTML;
