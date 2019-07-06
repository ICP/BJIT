<?php
// no direct access
defined('_JEXEC') or die;
$user = JFactory::getUser();
?>
<section class="box comments comment-form">
	<header>
		<h2><?php echo JText::_('K2_LEAVE_A_COMMENT') ?></h2>
	</header>
	<div>
		<?php if ($this->params->get('commentsFormNotes')) { ?>
			<div class="comment-notes alert alert-warning" style="display: none;">
				<?php if ($this->params->get('commentsFormNotesText')) { ?>
					<?php echo nl2br($this->params->get('commentsFormNotesText')); ?>
				<?php } ?>
			</div>
		<?php } ?>
		<div class="comment-result alert" style="display: none"></div>
		<form action="<?php echo JURI::root(true); ?>/index.php" method="post" id="comment-form" class="form-validate form-horizontal">
			<div class="form-group">
				<?php if ($user->guest) { ?>
					<!--<div class="col-12">-->
						<input class="form-control" type="text" name="userName" id="userName" placeholder="<?php echo JText::_('K2_NAME'); ?>" required="required" />
					<!--</div>-->
				<?php } else { ?>
					<input type="hidden" name="userName" value="<?php echo $user->name; ?>" />
				<?php } ?>
			</div>
			<div class="form-group">
				<?php if ($user->guest) { ?>
					<!--<div class="col-12">-->
						<input class="form-control ltr" type="email" name="commentEmail" id="commentEmail" placeholder="<?php echo JText::_('K2_EMAIL'); ?>" required="required" />
					<!--</div>-->
				<?php } else { ?>
					<input type="hidden" name="commentEmail" value="<?php echo $user->email; ?>" />
				<?php } ?>
			</div>
			<div class="form-group">
				<!--<div class="col-12">-->
					<textarea rows="4" class="form-control" name="commentText" id="commentText" placeholder="<?php echo JText::_('K2_MESSAGE'); ?>" required="required"></textarea>
				<!--</div>-->
			</div>
			<div class="form-group">
				<!--<div class="col-12 col-sm-6">-->
					<div id="captcha" class="g-recaptcha required" data-sitekey="<?php echo $this->params->get('recaptcha_public_key'); ?>" data-theme="" data-size="normal"></div>
				<!--</div>-->
				<!--<div class="col-12 col-sm-6">-->
					<div class="pull-left">
						<button type="submit" class="btn btn-warning" id="submitCommentButton"><?php echo JText::_('K2_SUBMIT_COMMENT'); ?></button>
					</div>
				<!--</div>-->
			</div>
			<input type="hidden" name="commentURL" id="commentURL" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
			<input type="hidden" name="option" value="com_k2" />
			<input type="hidden" name="view" value="item" />
			<input type="hidden" name="task" value="comment" />
			<input type="hidden" name="itemID" value="<?php echo JRequest::getInt('id'); ?>" />
			<?php echo JHTML::_('form.token'); ?>
		</form>
	</div>
</section>