<?php
/**
 * Layout for main column with one sidebar
 *
 * @package Creabator
 *
 * @uses $vars['content'] Content HTML for the main column
 * @uses $vars['sidebar'] Optional content that is displayed in the sidebar
 * @uses $vars['class']   Additional class to apply to layout
 * @uses $vars['nav']     HTML of the page nav (override) (default: breadcrumbs)
 */

$class = 'elgg-layout grey clearfix brs pas mtl';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// navigation defaults to breadcrumbs
$nav = elgg_extract('nav', $vars, elgg_view('navigation/breadcrumbs'));

$user=elgg_get_logged_in_user_entity();
$user_icon=elgg_view_entity_icon($user,'medium');
$user_name=elgg_view('output/url',array('href'=>$user->getURL(),'text'=>$user->name));

?>
<div class="container">
<div class="<?php echo $class; ?>">
	<div class="elgg-col-1of6 fl grey">
		
		<div class="pas center mtm dashed">
			<?php echo $user_icon  ?>
			<h4><?php echo $user_name ?></h4>
			
			
		</div>
	
<?php 
$sidebar_tabs=array(
		'home' => array(
				'text' => elgg_echo('menu:activity'),
				'href' => 'activity',
				'priority' => 200,
		),		
	
			'setting' => array(
				'text' => elgg_echo('settings'),
				'href' =>'settings/user/'.$user->username,
				'priority' => 600,
		),
		'invite' => array(
				'text' => elgg_echo('friends:invite'),
				'href' => 'invite/'.$user->username,
				'priority' => 1100,
		),
		
	);


if(elgg_is_active_plugin('projects')){
	// my projects
	$sidebar_tabs['own'] = array(
			'text' => elgg_echo('projects:own'),
			'href' => 'projects/owner/'.$user->username,
			'priority' => 300,
	);
}

if(elgg_is_active_plugin('ib_bank')){
	$sidebar_tabs['deposit'] = array(
			'text' => elgg_echo('Deposit'),
			'href' => 'bank/deposit/'.$user->username,
			'priority' => 1000,
	);
}


foreach ($sidebar_tabs as $name => $sidebar_tab) {
	$sidebar_tab['name'] = $name;

	elgg_register_menu_item('sidebar_tabs', $sidebar_tab);
}
$menu=elgg_view_menu('sidebar_tabs',array('sort_by' => 'priority', 'class' => 'elgg-menu-hz sidebar-menu center'));
echo $menu;
echo "<div class='dashed mtm'></div>"
?>	
	
	
	<?php if (isset($vars['sidebar'])) {
				echo $vars['sidebar'];
			}?>	
	<?php
	// add the recent active user links
     // list members
	$members=elgg_get_entities_from_metadata(array('type'=>'user','metadata_names'=>'icontime','limit'=>18));
	if($members){
		$memberlist="<h4 class='center'>Recent Users</h4>";
		$memberlist.="<ul>";
		foreach ($members as $member){
			
			$m_icon=elgg_view_entity_icon($member,'small');
			$memberlist.="<li class='inline-block pas'>{$m_icon}</li>";
		
		}
		$memberlist.="</ul>";
		echo $memberlist;
	}

	?>
</div>
	<div class="elgg-col-5of6 fl bgwhite">
		<div class="elgg-main">
		<?php
			echo $nav;
			
			if (isset($vars['title'])) {
				echo "<h2 class='dashed mbm'>";
				echo $vars['title'];
				echo "</h2>";
			}
		
			if (isset($vars['content'])) {
				echo $vars['content'];
			}
		?>
		</div>
		
	</div>
</div>
</div>