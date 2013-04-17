<?php
/**
 * Main project content area layout
 *
 * @uses $vars['ib_content']        HTML of main content area
 * @uses $vars['nav']            HTML of the content area nav (override)
 * @uses $vars['ib_guid']         GUID of the project
 */
/* //load the lightbox js
elgg_load_js('lightbox');
elgg_load_css('lightbox');
 */

$guid=$vars['ib_guid'];
$project = get_entity($guid);
$owner=$project->getOwnerEntity();
$owner_name=elgg_view('output/url',array('href'=>'/profile/'.$owner->username,'text'=>$owner->name.'/','style'=>'color:whitesmoke;font-size:2.2em'));

$title = elgg_view('output/url', array(
		'text' => $project->title,
		'href' => $project->getURL(),
		'is_trusted' => true,));

$private='';
$access=$project->access_id;
if($access==0){
	$public=elgg_view('output/url',array(
			'href'=>"action/projects/approve?project_guid={$project->guid}&action_type=activated",
			'text'=>"Publish",
			'is_action' => true,
			'class'=>'elgg-button elgg-button-submit plm prm '	
	));

	$private=<<<html
<div style="background: #e60;color:white;border-radius:10px;width:600px;padding:5px;margin-bottom:10px">
	You are in the private mode now, only you can view the content,if you are want to publish your project,you can simply click
	$public
	</div>
html;

}

if (isset($vars['ib_content'])) {
	$ibcontent=$vars['ib_content'];
}
//setting display or not
if (elgg_is_logged_in() && $project->canEdit()){
	$style="";
}else{
	$style="display:none;";
}

// menu tab

$ptabs=array(

		'Settings' => array(
				'text' => elgg_echo('project:tabs:settings'),
				'href' => 'projects/setting/help/'.$guid,
				'priority' => 800,
		),
	
		'Backers' => array(
				'text' => elgg_echo('project:tabs:backers'),
				'href' => 'projects/backers/'.$guid,
				'priority' => 500,
		),
		
		'Blogs' => array(
				'text' => elgg_echo('project:tabs:news'),
				'href' => 'projects/blogs/all/'.$guid,
				'priority' => 400,
		),

		'Home' => array(
				'text' =>elgg_echo('project:tabs:home'),
				'href' => $project->getURL(),
				'priority' => 200,

		),

);
if(elgg_is_active_plugin('wiki')&&is_project_member($guid, elgg_get_logged_in_user_guid())){
	$ptabs['wiki']=array(
			'text'=>elgg_echo('wiki'),
			'href'=>'wiki/project/'.$guid,
			'priority'=>'300'
			);
}


foreach ($ptabs as $name => $ptab) {
	$ptab['name'] = $name;

	elgg_register_menu_item('ptabs', $ptab);
}

$menu=elgg_view_menu('ptabs',array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));


$head_title = elgg_view('output/url', array(
		'text' => $project->title,
		'href' => $project->getURL(),
		'style'=>'color:white;font-size:2em',
		));
$tagline=$project->tagline;
$body =<<<HTML
<div class="container">
<div id="chead">
$private
<div class="mbm">
	
	$owner_name $head_title
	


<div class="fr">
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_sina_large' displayText='Sina'></span>
<span class='st_sharethis_large' displayText='ShareThis'></span>
</div>
</div>

	$menu

</div>
<div class="clearfloat"></div>
<div style="background-color:white;min-height:500px;overflow:hidden;border: 1px solid #ccc;" class="pam mbm">
$nav
$ibcontent
</div>
</div>
HTML;


echo $body;
?>

<style type="text/css">
li.elgg-menu-item-settings{
<?php echo $style ?>;
}
</style>


