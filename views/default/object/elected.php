<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections Object elected
 *
 */
$full = elgg_extract('full_view', $vars, false);
$elected = elgg_extract('entity', $vars, false);

if (!$elected) {
	return;
}

$owner = $elected->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'small');
$container = $elected->getContainerEntity();

$description = elgg_view('output/longtext', array('value' => $elected->description, 'class' => 'pbs'));

$owner_link = elgg_view('output/url', array(
	'href' => "profile/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));

$date = elgg_view_friendly_time($elected->time_updated);

$comments_count = $elected->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $elected->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $elected,
	'handler' => 'elections',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link";

if ($full) {
	$params = array(
		'entity' => $elected,
		//'metadata' => $metadata,
		'subtitle' => $subtitle,
		'title' => $owner_link
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	$body = <<<HTML
<div class="elected elgg-content">
	$description
</div>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $elected,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

} else {
	// brief view
	//$excerpt = elgg_get_excerpt($elected->description);
	$excerpt = elgg_view('output/longtext', array(
		'value' => elgg_echo('river_elected_message:' . $elected->mode, array($owner->name, $elected->nbr_candidats)) . ' ' . $elected->more_message
	));
	
/*	$message = elgg_echo('river_elected_message:' . $mode, array($user_elected->name, $count_candidats));
	if ($more_message) $message .= $more_message;
	$description = $message . '<br/>' . $elected->description;
	$description = sanitise_string($description);*/
	
	if ($elected->time_updated == $elected->last_action) {
		$title = elgg_echo('groups_admins_elections:elected:is') . lcfirst(elgg_echo('groups_admins_elections:elected_now:title', array(strftime(elgg_echo('groups_admins_elections:elected:date'), $elected->time_updated))));
	} else {
		$title = elgg_echo('groups_admins_elections:elected:fromto') . lcfirst(elgg_echo('groups_admins_elections:elected:title', array(strftime(elgg_echo('groups_admins_elections:elected:date'), $elected->time_updated), strftime(elgg_echo('groups_admins_elections:elected:date'), $elected->last_action))));
	}
	
	$title_link = elgg_view('output/url', array(
		'text' => $title,
		'href' => $elected->getURL(),
		'is_trusted' => true,
	));

	$params = array(
		'entity' => $elected,
		//'metadata' => $metadata,
		'title' => $owner_link . $title_link,
		'subtitle' => $date . '&nbsp;' . $comments_link,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	$body = <<<HTML
<div class="elected elgg-content">
	$excerpt
</div>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $elected,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

}