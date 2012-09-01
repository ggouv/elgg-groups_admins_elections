<?php
/**
 *	Elgg-groups_admins_elections plugin
 *	@package elgg-groups_admins_elections
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-groups_admins_elections
 *
 *	Elgg-groups_admins_elections candidat edit/add form
 *
 */

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()

$desc = elgg_extract('description', $vars, '');
$mandat_guid = elgg_extract('mandat_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
?>

<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>

<div class="elgg-foot">
	<?php
	
	echo elgg_view('input/hidden', array('name' => 'mandat_guid', 'value' => $mandat_guid));
	
	if ($guid) {
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
	}
	
	echo elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	?>
</div>