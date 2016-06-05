<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$config = new stdClass();
$config->url = $params->get('feed');
$config->count = $params->get('count');
$config->tmpl = 'tmpl' . $module->id;
$config->carousel = true;
?>
<div class="feed-holder" data-conf='<?php echo json_encode($config); ?>'>
	<script class="<?php echo $config->tmpl; ?>">
		var box_<?php echo $config->tmpl; ?> = '<section class="box tourism carousel"><div class="container"><header><h2><a target="_blank" href="{site.url}" class="">{site.name}</a></h2></header><div class="items"><ul>{items}</ul></div></div></section>';
		var items_<?php echo $config->tmpl; ?> = '<li><figure><a target="_blank" href="{site.url}{category.link}{item.link}"><img src="{site.url}{item.imageSmall}" alt="{item.title}"/></a></figure><div class="desc"><h3><a target="_blank" href="{site.url}{category.link}{item.link}">{item.title}</a></h3></div></li>';
	</script>
</div>