<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Object mandat
 *
 */

$full = elgg_extract('full_view', $vars, FALSE);
$mandat = elgg_extract('entity', $vars, FALSE);

$candidats_count = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtypes' => 'candidat',
	'metadata_name' => 'mandat_guid',
	'metadata_value' => $mandat->guid,
	'limit' => 0,
	'count' => true
));
$candidats_string = elgg_view('output/url', array(
	'href' => "elections/mandat/{$mandat->guid}/{$mandat->title}",
	'text' => '<div>' . elgg_echo('groups_admins_elections:mandat:nbr_candidats', array('<span>' . $candidats_count . '</span>')) .'</div>',
	//'is_trusted' => true,
));

$current_elected = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtypes' => 'elected',
	'container_guid' => $mandat->container_guid,
	'metadata_name' => 'mandat_guid',
	'metadata_value' => $mandat->guid,
	'limit' => 1,
));
//global $fb; $fb->info($current_elected);
if (!$current_elected) {
	$mandat_next_election = elgg_echo('groups_admins_elections:mandat:not_enougth_candidats');
}
$mandat_duration = elgg_echo('groups_admins_elections:mandat:duration', array($mandat->duration));


if (!$mandat) {
	return;
} else if ($full === true) {
	
	$owner = $mandat->getOwnerEntity();

	$owner_link = elgg_view('output/url', array(
		'href' => "profile/$owner->username",
		'text' => $owner->name,
		'is_trusted' => true,
	));
	$author_text = elgg_echo('groups_admins_elections:mandat:created_by', array($owner_link));
	
	$date = elgg_view_friendly_time($mandat->time_created);
	
	$comments_count = $mandat->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $mandat->getURL() . '#comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
	
	$subtitle = "$author_text $date $comments_link";

	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'elections',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));

	$params = array(
		'entity' => $mandat,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'title' => false
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	$description = elgg_view('output/longtext', array('value' => $mandat->description, 'class' => 'pbs'));

	$body = <<<HTML
<ul class="mandat elgg-content">
	<li>$description</li>
	<li class="elgg-heading-basic mbs">$candidats_string $mandat_next_election $mandat_duration</li>
</ul>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $mandat,
		'summary' => $summary,
		'body' => $body,
	));

} else if ($full == 'in_group_profile') {

	$params = array(
		'text' => $mandat->title,
		'href' => $mandat->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);

	$body = <<<HTML
	<h3>$title_link<span class="elgg-river-timestamp">&nbsp;-&nbsp;$candidats_count</span></h3>
HTML;

	echo $body;

} else { // brief view

	$excerpt = elgg_get_excerpt($mandat->description);

	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'elections',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
	
	$params = array(
		'entity' => $mandat,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$body = <<<HTML
<ul class="mandat elgg-content">
	<li>$excerpt</li>
	<li class="elgg-heading-basic mbs">$mandat_info</li>
</ul>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $mandat,
		'summary' => $summary,
		'body' => $body,
	));
}