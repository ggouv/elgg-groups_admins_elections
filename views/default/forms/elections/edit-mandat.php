<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections mandat edit/add form
 *
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()

$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$duration = elgg_extract('duration', $vars, 15);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
global $fb; $fb->info($title, 'ép');
?>

<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>

<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>

<div>
	<label><?php echo elgg_echo('groups_admins_elections:mandat:form:duration'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'duration', 'value' => $duration)); ?>
</div>

<div class="elgg-foot">
	<?php
	
	echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
	
	if ($guid) {
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
	}
	
	echo elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	?>
</div>