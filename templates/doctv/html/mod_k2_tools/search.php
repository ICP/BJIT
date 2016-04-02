<?php
// no direct access
defined('_JEXEC') or die;
?>
<aside id="search" class="box search">
	<form class="search-form" role="form">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<input type="text" name="q" placeholder="برای جستجو بنویسید" class="form-control" />
						<button type="submit" class="btn btn-success"><?php echo JTEXT::_('K2_SEARCH'); ?></button>
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
				</div>
			</div>
		</div>

	</form>
	<?php if ($params->get('liveSearch')) { ?>
		<div class="hide search-resluts"></div>
	<?php } ?>
</aside>