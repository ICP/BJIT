<?php
// no direct access
defined('_JEXEC') or die;
?>

<div id="module-<?php echo $module->id; ?>" class="comments-list<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<?php if(count($comments)): ?>
	<ul>
		<?php foreach ($comments as $key=>$comment):	?>
		<li class="<?php echo ($key%2) ? "odd" : "even"; if(count($comments)==$key+1) echo ' lastItem'; ?>">
			<?php if($comment->userImage): ?>
			<a class="k2Avatar lcAvatar" href="<?php echo $comment->link; ?>" title="<?php echo K2HelperUtilities::cleanHtml($comment->commentText); ?>">
				<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" style="width:<?php echo $lcAvatarWidth; ?>px;height:auto;" />
			</a>
			<?php endif; ?>
			
			<?php echo $comment->userName; ?>
			<?php echo $comment->commentDate; ?>
			درباره 
			<?php echo $comment->title; ?>
			نوشت: 
			
			
			<?php /* if($params->get('commentDate')): ?>
			<span class="date">
				<?php if($params->get('commentDateFormat') == 'relative'): ?>
				<?php echo $comment->commentDate; ?>
				<?php else: ?>
				<?php echo JText::_('K2_ON'); ?> <?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?>
				<?php endif; ?>
			</span>
			<?php endif; */ ?>
			<?php if($params->get('commentLink')): ?>
			<a href="<?php echo $comment->link; ?>"><span class="text"><?php echo $comment->commentText; ?></span></a>
			<?php else: ?>
			<span class="text"><?php echo $comment->commentText; ?></span>
			<?php endif; ?>
			<?php /* if($params->get('commenterName')): ?>
			<span class="name"><i class="icon-comment-alt"></i><?php echo JText::_('K2_WRITTEN_BY'); ?>
				<?php echo $comment->userName; ?>
			</span>
			<?php endif; */ ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

</div>
