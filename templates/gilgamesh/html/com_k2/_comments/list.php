<?php
// no direct access
defined('_JEXEC') or die;
?>
<section class="box comments comments-list" data-count="<?php echo $this->item->numOfComments; ?>">
	<header>
		<h2><?php echo ($this->item->numOfComments > 1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?></h2>
	</header>
	<div>
		<ul>
			<?php foreach ($this->item->comments as $key => $comment) { ?>
				<li class="<?php
				echo (!$this->item->created_by_alias && $comment->userID == $this->item->created_by) ? "response" : "";
				echo ($comment->published) ? '' : ' unpublished';
				?>" id="comment<?php echo $comment->id; ?>">
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
							<?php
							$response = '';
							if (stristr($comment->commentText, "&&&&")) {
								list($user_comment, $response) = explode("&&&&", $comment->commentText);
								$comment->commentText = $user_comment;
							}
							?>
						<p><?php echo $comment->commentText; ?></p>
						<?php if ($response) { ?>
						<blockquote><p><?php echo strip_tags($response); ?></p></blockquote>
						<?php } ?>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
	<footer>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</footer>
</section>