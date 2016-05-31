<?php
// no direct access
defined('_JEXEC') or die;
?>
<?php if (count($comments)) { ?>
	<ul>
		<?php foreach ($comments as $key => $comment) { ?>
			<li>
				<?php if ($comment->userImage) { ?>
					<div class="avatar">
						<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" />
					</div>
				<?php } ?>
				<div class="comment-body">
					<div class="info">
						<div class="username">
							<?php if (!empty($comment->userLink)) { ?>
								<a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow"><?php echo $comment->userName; ?></a>
							<?php } else { ?>
								<?php echo $comment->userName; ?>
							<?php } ?>
						</div>
						<time><?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?></time>
					</div>
					<p><?php echo $comment->commentText; ?></p>
				</div>
			</li>
		<?php } ?>
	</ul>
<?php } ?>
