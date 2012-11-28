<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections elected river view
 *
 */
$item = $vars['item'];

$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();
$mandat = get_entity($object->mandat_guid);

$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
	'href' => $object->getURL(),
	'text' => elgg_echo('river_elected'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$mandat_link = elgg_view('output/url', array(
	'href' => $mandat->getURL(),
	'text' => $mandat->title,
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$container = $object->getContainerEntity();
if ($container instanceof ElggGroup) {
	$params = array(
		'href' => $container->getURL(),
		'text' => $container->name,
		'is_trusted' => true,
	);
	$group_link = elgg_view('output/url', $params);
	$group_string = elgg_echo('river:ingroup', array($group_link));
}

$summary = elgg_echo('river:create:object:elected', array($subject_link, $object_link, $mandat_link, $group_string));

$elected = get_entity($object->owner_guid);

$message = elgg_echo('river_elected_message', array('@' . $elected->name, $object->nbr_candidats));
if ($object->more_message) $message .= $more_message;

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'summary' => $summary,
	'message' => $message,
));