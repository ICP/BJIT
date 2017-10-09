<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$other_languages = $links['text'];
unset($links['text']);
?>
<ul class="languages">
<?php foreach ($links as $link){ ?>
	<li><a href="<?php echo $link['link']; ?>" title="<?php echo $link['title']; ?>"><?php echo $link['name']; ?></a></li>
<?php } ?>
</ul>
<div class="worldservice">
	<a href="http://worldservice.irib.ir" title="<?php echo $other_languages; ?>"><?php echo $other_languages; ?></a>
</div>