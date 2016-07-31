<?php
defined('_JEXEC') or die;

$user = JFactory::getUser();
?>
<div class="box-wrapper club">
	<div class="page-tools">
		<ul class="list-unstyled list-inline order-style">
			<?php if ($user->guest) { ?>
				<li class="has-btn">
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=login'); ?>" class="btn btn-default" data-toggle="toggle" data-target=".login-container">ورود</a>
					<div class="login-container">
						<?php
						jimport('joomla.application.module.helper');
						// this is where you want to load your module position
						$modules = JModuleHelper::getModules('user-login');
						foreach ($modules as $module) {
							echo JModuleHelper::renderModule($module);
						}
						?>
					</div>
				</li>
				<li class="has-btn"><a href="<?php echo JRoute::_('index.php?option=com_users&view=register'); ?>" class="btn btn-default">ثبت نام</a></li>
			<?php } else { ?>
				<li class="title">سلام <span><?php echo $user->name; ?>! </span></li>
				<li class="has-btn">
					<form action="<?php echo JRoute::_('index.php?option=com_users&view=login&task=user.logout'); ?>" method="post">
						<input type="hidden" name="return" value="<?php echo base64_encode(JURI::current()); ?>" />
						<?php echo JHtml::_('form.token'); ?>
						<button type="submit" class="btn btn-default">خروج</submit>
					</form>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php
	jimport('joomla.application.module.helper');
// this is where you want to load your module position
	$modules = JModuleHelper::getModules('multimedia_carousels');
	?>
	<?php
	foreach ($modules as $module) {
		echo JModuleHelper::renderModule($module, array('style' => 'default'));
	}
	?>
</div>
