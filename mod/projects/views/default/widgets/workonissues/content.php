<?php
/**
 * Elgg  done issues widget
 *
 * @package projects
 */

$max = (int) $vars['entity']->num_display;

//get all the issues that the user contribute to
$annotations=elgg_get_annotations(array(
	'annotation_owner_guid'=>$vars['entity']->owner_guid,
	'limit' => $max,
	'annotation_name'=>'workon'
	));
if($annotations){
	$content="<ul>";
	foreach ($annotations as $annotation) {
		$issue=get_entity($annotation->entity_guid);
		if($issue->done!=1){
			$issuelink=elgg_get_site_url().'projects/issues/view/'.$issue->guid;
			$content.="<li><a href='{$issuelink}'>{$issue->title}</a></li>";
		}	
	}
	$content.="</ul>";

	echo $content;
} else {
	echo elgg_echo('projects:issue:none');
}
