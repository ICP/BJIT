<?php
// no direct access
defined('_JEXEC') or die;
?>

<div class="search">
	<form class="" role="form">
		<div class="form-group">
			<input type="text" name="q" placeholder="" class="form-control" />
			<button type="submit" class="btn btn-success"><i class="icon-search"></i></button>
			<input type="hidden" name="categories" value="<?php echo $categoryFilter; ?>" />
			<?php if (!$app->getCfg('sef')) { ?>
				<input type="hidden" name="option" value="com_k2" />
				<input type="hidden" name="view" value="itemlist" />
				<input type="hidden" name="task" value="search" />
			<?php } ?>
			<?php if ($params->get('liveSearch')) { ?>
				<input type="hidden" name="format" value="html" />
				<input type="hidden" name="t" value="" />
				<input type="hidden" name="tpl" value="search" />
			<?php } ?>
		</div>
	</form>
	<?php if ($params->get('liveSearch')) { ?>
		<div class="search-resluts"></div>
	<?php } ?>
</div>