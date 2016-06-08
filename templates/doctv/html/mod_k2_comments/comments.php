<?php
// no direct access
defined('_JEXEC') or die;
?>
<?php if (count($comments)) { ?>
	<div class="nano">
		<div class="nano-content">
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
							<p><?php echo $comment->commentText; ?></p>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php
}