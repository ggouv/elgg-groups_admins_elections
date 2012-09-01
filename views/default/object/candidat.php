<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Object candidat
 *
 */

$full = elgg_extract('full_view', $vars, FALSE);
$candidat = elgg_extract('entity', $vars, FALSE);

if (!$candidat) {
	return;
}

$owner = $candidat->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'medium');
$container = $candidat->getContainerEntity();

$description = elgg_view('output/longtext', array('value' => $candidat->description, 'class' => 'pbs'));

$owner_link = elgg_view('output/url', array(
	'href' => "profile/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('groups_admins_elections:candidat:created_by', array($owner_link));

$date = elgg_view_friendly_time($candidat->time_created);

$comments_count = $candidat->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $candidat->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'elections',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full === true) {
	$params = array(
		'entity' => $candidat,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$body = <<<HTML
<div class="candidat elgg-content">
	$description
</div>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $candidat,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

} else if ($full == 'in_group_profile') {
	$params = array(
		'text' => $candidat->title,
		'href' => $candidat->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);

	$body = <<<HTML
<h3>$title_link</h3>
HTML;

	echo $body;
} else {
	// brief view
	$excerpt = elgg_get_excerpt($candidat->description);
	if ($excerpt) {
		$excerpt = " - $excerpt";
	}

	$link = elgg_view('output/url', array(
		'href' => $candidat->getURL(),
		'text' => $display_text,
	));

	$content = $excerpt;

	$params = array(
		'entity' => $candidat,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($owner_icon, $body);
}
