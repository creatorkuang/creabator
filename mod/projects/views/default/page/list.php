<?php
/**

 * @uses $vars['title'] The page title
 * @uses $vars['body'] The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

$js = elgg_get_loaded_js('head');
$css = elgg_get_loaded_css();
$title = elgg_get_config('sitename');
$version = get_version();
$release = get_version(true);

// Set the content type
header("Content-type: text/html; charset=UTF-8");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" ng-app>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="ElggRelease" content="<?php echo $release; ?>" />
	<meta name="ElggVersion" content="<?php echo $version; ?>" />
	<title><?php echo $title; ?></title>
	<?php echo elgg_view('page/elements/shortcut_icon', $vars); ?>

<?php foreach ($css as $link) { ?>
	<link rel="stylesheet" href="<?php echo $link; ?>" type="text/css" />
<?php } ?>

<?php foreach ($js as $script) { ?>
	<script type="text/javascript" src="<?php echo $script; ?>" ></script>
<?php } ?>

<?php
	$ie_url = elgg_get_simplecache_url('css', 'ie');
	$ie7_url = elgg_get_simplecache_url('css', 'ie7');
	$ie6_url = elgg_get_simplecache_url('css', 'ie6');
?>
	<!--[if gt IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie_url; ?>" />
	<![endif]-->
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie7_url; ?>" />
	<![endif]-->
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie6_url; ?>" />
	<![endif]-->



</head>
<body>

	<div class="elgg-page-messages">
		<?php echo elgg_view('page/elements/messages', array('object' => $vars['sysmessages'])); ?>
	</div>


	<div class="elgg-page-header">
		 <div class="wrapper">
		       <?php echo elgg_view('page/elements/header', $vars); ?>
		 </div>
		 </div>


			<div class="wrapper">
		      	<?php echo elgg_view('page/elements/body', $vars); ?>
 			</div>






<div class="footer">
		     <?php echo elgg_view('page/elements/footer', $vars); ?>
			
	



<script type="text/javascript" >
	<?php echo elgg_view('js/initialize_elgg'); ?>
</script>

	<?php echo elgg_view('page/elements/foot'); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36410646-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</div>
</body>
</html>