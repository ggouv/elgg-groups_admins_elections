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

if (!$mandat) {
	return;
}

$current_elected = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtypes' => 'elected',
	'metadata_name' => 'mandat_guid',
	'metadata_value' => $mandat->guid,
	'limit' => 1,
));

$mandat_next_election_string = elgg_echo('groups_admins_elections:mandat:next_election');

if (!$current_elected) {
	$mandat_next_election = elgg_echo('groups_admins_elections:mandat:not_enougth_candidats');
	$owner_elected_icon = '<span class="elgg-river-timestamp">' . elgg_echo('groups_admins_elections:mandat:not_elected') . '</span>';
} else {
	$owner_elected = get_entity($current_elected[0]->owner_guid);
	$owner_elected_icon = elgg_view_entity_icon($owner_elected, 'small', array('class' => 'float mrs'));
	$owner_elected_view = elgg_view('output/url', array(
				'text' => $owner_elected->name,
				'value' => $owner_elected->getURL(),
				'is_trusted' => true,
			));
	$mandat_occuby_by = '<div class="mbs">' . elgg_echo('groups_admins_elections:mandat:occupy_by') . '</div>' . $owner_elected_icon . $owner_elected_view;
}

if ($full === 'in_group_profile') {

	$params = array(
		'text' => $mandat->title,
		'href' => $mandat->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);

	$body = <<<HTML
	<h3 class="mbs">$title_link</h3>
	$owner_elected_icon $owner_elected_view
HTML;

	echo $body;

} else {

	if ($current_elected) {
		$user = elgg_get_logged_in_user_entity();
		setlocale(LC_TIME, $user->language, strtolower($user->language) . '_' . strtoupper($user->language));
		$mandat_next_election = strftime(elgg_echo('groups_admins_elections:mandat:next_election_date'), $current_elected[0]->end_mandat);
	}
	
	$candidats_count = elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'subtypes' => 'candidat',
		'metadata_name' => 'mandat_guid',
		'metadata_value' => $mandat->guid,
		'limit' => 0,
		'count' => true
	));
	$candidats_count_string = elgg_echo('groups_admins_elections:mandat:nbr_candidats', array('<span>' . $candidats_count . '</span>'));
	$candidats_count_url = elgg_view('output/url', array(
		'href' => "elections/mandat/candidats/{$mandat->guid}/{$mandat->title}",
		'text' => $candidats_count_string,
		'is_trusted' => true,
	));
	
	$mandat_duration_string = elgg_echo('groups_admins_elections:mandat:duration');
	$mandat_duration = elgg_echo('groups_admins_elections:mandat:duration:day', array($mandat->duration));
	
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

	if ($full === true) {

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
	<ul class="mandat elgg-content row-fluid">
		<li class="span8">$description</li>
		<li class="elgg-heading-basic pam mtm span4">
			<p>$candidats_count_url</p>
			<p>$mandat_duration_string<br/>$mandat_duration</p>
			<p>$mandat_next_election_string<br/>$mandat_next_election</p>
			$mandat_occuby_by
		</li>
	</ul>
HTML;
	
		echo elgg_view('object/elements/full', array(
			'entity' => $mandat,
			'summary' => $summary,
			'body' => $body,
		));
	
	} else { // brief view
	
		$excerpt = elgg_get_excerpt($mandat->description);
		
		$params = array(
			'entity' => $mandat,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
		);
		$params = $params + $vars;
		$summary = elgg_view('object/elements/summary', $params);
	
		$body = <<<HTML
	<ul class="mandat elgg-content row-fluid">
		<li class="span8">$excerpt</li>
		<li class="elgg-heading-basic pam span4">$candidats_count_string<br/>$mandat_duration<br/>$mandat_next_election<br/>$owner_elected_view</li>
	</ul>
HTML;
	
		echo elgg_view('object/elements/full', array(
			'entity' => $mandat,
			'summary' => $summary,
			'body' => $body,
		));
	}
}