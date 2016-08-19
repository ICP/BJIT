<?php
// no direct access
defined('_JEXEC') or die;
?>
<?php if (count($comments)) { ?>
	<div class="page-tools">
		<ul class="list-inline">
			<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=login'); ?>" class="btn btn-default">ورود</a></li>
			<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=register'); ?>" class="btn btn-default">ثبت نام</a></li>
			<li><a href="<?php echo JUri::root() . 'club'; ?>" class="btn btn-warning">ارسال اثر</a></li>
		</ul>
	</div>
	<ul>
		<?php foreach ($comments as $key => $comment) { ?>
			<li>
				<?php if ($comment->userImage) { ?>
					<div class="avatar">
						<a href="<?php echo JFilterOutput::cleanText($comment->link); ?>" target="_blank" rel="nofollow">
							<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" />
						</a>
					</div>
				<?php } ?>
				<div class="comment-body">
					<div class="info">
						<div class="username">
							<a href="<?php echo JFilterOutput::cleanText($comment->link); ?>" target="_blank" rel="nofollow"><?php echo $comment->userName; ?></a>
						</div>
						<time><?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?></time>
					</div>
					<?php
					$response = '';
					if (stristr($comment->commentText, "&&&&")) {
						list($user_comment, $response) = explode("&&&&", $comment->commentText);
						$comment->commentText = $user_comment;
					}
					?>
					<p><?php echo $comment->commentText; ?></p>
				</div>
			</li>
		<?php } ?>
	</ul>
	<?php
}