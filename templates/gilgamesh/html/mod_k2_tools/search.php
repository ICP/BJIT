<?php
// no direct access
defined('_JEXEC') or die;
?>
<aside id="search" class="box search">
	<form class="search-form" role="form" action="<?php echo JUri::root() . 'search'; ?>">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<input type="text" name="searchword" placeholder="<?php echo JText::_('K2_SEARCH'); ?>" class="form-control" />
						<button type="submit" class="btn btn-success"><?php echo JTEXT::_('K2_SEARCH'); ?></button>
						<button class="btn btn-link" data-toggle="toggle" data-target="#search">&times;</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="container">
		<section class="box highlights tiles latest grid search-results" style="display: none;"></section>
	</div>
</aside>