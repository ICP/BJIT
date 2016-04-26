<?php
/**
 * @version    2.7.x
 * @package    K2
 * @author     JoomlaWorks http://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2016 JoomlaWorks Ltd. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<?php if (JRequest::getInt('print') == 1) { ?>
	<a class="btn btn-block" rel="nofollow" href="#" onclick="window.print();">
		<?php echo JText::_('K2_PRINT_THIS_PAGE'); ?>
	</a>
<?php } ?>
<article id="item" class="item news<?php echo ($this->item->featured) ? ' featured' : ''; ?><?php if ($this->item->params->get('pageclass_sfx')) echo ' ' . $this->item->params->get('pageclass_sfx'); ?>" data-hits="<?php echo $this->item->hits; ?>" data-hits="<?php if ($this->item->params->get('itemDateModified') && intval($this->item->modified) != 0) { ?><?php echo JHTML::_('date', $this->item->modified, JText::_('K2_DATE_FORMAT_LC2')); ?><?php } ?>">
	<?php echo $this->item->event->BeforeDisplay; ?>
	<?php echo $this->item->event->K2BeforeDisplay; ?>
	<header class="item-header">
		<div class="row">
			<div class="col-xs-6  col-md-3 item-tools">
				<ul class="list-inline list-unstyled">
					<?php if ($this->item->params->get('itemPrintButton') && !JRequest::getInt('print')) { ?>
						<li>
						   <a rel="nofollow" href="<?php echo $this->item->printLink; ?>" onclick="window.open(this.href, 'printWindow', 'width=900,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes');
	                                   return false;">
								<i class="icon-print"></i>
							</a>
						</li>
					<?php } ?>
					<li><a href="#"><i class="icon-facebook"></i></a></li>
					<li><a href="#"><i class="icon-twitter"></i></a></li>
					<li><a href="#"><i class="icon-gplus"></i></a></li>
				</ul>
			</div>
			<?php if ($this->item->params->get('itemDateCreated')) { ?>
				<div class="col-xs-6 col-md-9 item-date">
					<time><?php echo JHTML::_('date', $this->item->created, JText::_('K2_DATE_FORMAT_LC2')); ?></time>
				</div>
			<?php } ?>
		</div>
		<?php if ($this->item->params->get('itemTitle')) { ?>
			<div class="page-title">
				<h2 class="item-title">
					<?php echo $this->item->title; ?>
				</h2>
			</div>
		<?php } ?>
		<?php if ($this->item->params->get('itemAuthor')) { ?>
			<div class="item-author">
				<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?>
				<?php if (empty($this->item->created_by_alias)) { ?>
					<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
				<?php } else { ?>
					<?php echo $this->item->author->name; ?>
				<?php } ?>
			</div>
		<?php } ?>
	</header>
	<?php echo $this->item->event->AfterDisplayTitle; ?>
	<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	<div class="item-body">
		<?php echo $this->item->event->BeforeDisplayContent; ?>
		<?php echo $this->item->event->K2BeforeDisplayContent; ?>
		<?php if ($this->item->params->get('itemImage') && !empty($this->item->image)) { ?>
			<?php $video = ($this->item->params->get('itemVideo') && !empty($this->item->video)) ? $this->item->video : null; ?>
			<figure id="item-media" class="item-image"<?php echo ($video) ? ' data-video=' . $video : '' ?>>
				<a href="<?php echo $this->item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>">
					<img src="<?php echo $this->item->image; ?>" alt="<?php
					if (!empty($this->item->image_caption))
						echo K2HelperUtilities::cleanHtml($this->item->image_caption);
					else
						echo K2HelperUtilities::cleanHtml($this->item->title);
					?>" />
				</a>
				<?php if (!empty($this->item->image_caption) || !empty($this->item->image_credits)) { ?>
					<figcaption>
						<?php if ($this->item->params->get('itemImageMainCaption') && !empty($this->item->image_caption)) { ?>
							<div class="img-caption"><?php echo $this->item->image_caption; ?></div>
						<?php } ?>
						<?php if ($this->item->params->get('itemImageMainCredits') && !empty($this->item->image_credits)) { ?>
							<div class="img-credits"><?php echo $this->item->image_credits; ?></div>
						<?php } ?>
					</figcaption>
				<?php } ?>
			</figure>
		<?php } ?>
		<?php if ($this->item->params->get('itemExtraFields') && count($this->item->extra_fields)) { ?>
			<?php foreach ($this->item->extra_fields as $key => $extraField) { ?>
				<?php if ($extraField->alias == "embed" && $extraField->value != '') { ?>
					<div class="item-fields" data-type="<?php echo $extraField->name; ?>">
						<?php echo $extraField->value; ?>
					</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		<?php if (!empty($this->item->fulltext)) { ?>
			<?php if ($this->item->params->get('itemIntroText')) { ?>
				<div class="summary">
					<?php echo $this->item->introtext; ?>
				</div>
			<?php } ?>
			<?php if ($this->item->params->get('itemFullText')) { ?>
				<div class="item-text">
					<?php echo $this->item->fulltext; ?>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="item-text">
				<?php echo $this->item->introtext; ?>
			</div>
		<?php } ?>
		<?php /* if ($this->item->params->get('itemExtraFields') && count($this->item->extra_fields)) { ?>
		  <div class="item-fields">
		  <h3><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h3>
		  <dl class="dl-horizontal">
		  <?php foreach ($this->item->extra_fields as $key => $extraField) { ?>
		  <?php if ($extraField->value != '') { ?>
		  <dt class="field-label type<?php echo $extraField->type; ?> group<?php echo $extraField->group; ?>">
		  <?php if ($extraField->type == 'header') { ?>
		  <h4 class="field-title"><?php echo $extraField->name; ?></h4>
		  <?php } else { ?>
		  <?php echo $extraField->name; ?>
		  <?php } ?>
		  </dt>
		  <dd class="field-value"><?php echo $extraField->value; ?></dd>
		  <?php } ?>
		  <?php } ?>
		  </dl>
		  </div>
		  <?php } */ ?>
		<?php echo $this->item->event->AfterDisplayContent; ?>
		<?php echo $this->item->event->K2AfterDisplayContent; ?>
	</div>
	<?php /* if ($this->item->params->get('itemAuthorBlock') && empty($this->item->created_by_alias)) { ?>
	  <div class="itemAuthorBlock">
	  <?php if ($this->item->params->get('itemAuthorImage') && !empty($this->item->author->avatar)) { ?>
	  <img class="itemAuthorAvatar" src="<?php echo $this->item->author->avatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($this->item->author->name); ?>" />
	  <?php } ?>
	  <div class="itemAuthorDetails">
	  <h3 class="itemAuthorName">
	  <a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
	  </h3>
	  <?php if ($this->item->params->get('itemAuthorDescription') && !empty($this->item->author->profile->description)) { ?>
	  <p><?php echo $this->item->author->profile->description; ?></p>
	  <?php } ?>
	  <?php if ($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url)) { ?>
	  <span class="itemAuthorUrl"><i class="k2icon-globe"></i> <a rel="me" href="<?php echo $this->item->author->profile->url; ?>" target="_blank"><?php echo str_replace('http://', '', $this->item->author->profile->url); ?></a></span>
	  <?php } ?>

	  <?php if ($this->item->params->get('itemAuthorURL') && !empty($this->item->author->profile->url) && $this->item->params->get('itemAuthorEmail')) { ?>
	  <span class="k2HorizontalSep">|</span>
	  <?php } ?>

	  <?php if ($this->item->params->get('itemAuthorEmail')) { ?>
	  <span class="itemAuthorEmail"><i class="k2icon-envelope"></i> <?php echo JHTML::_('Email.cloak', $this->item->author->email); ?></span>
	  <?php } ?>
	  <div class="clr"></div>

	  <?php echo $this->item->event->K2UserDisplay; ?>
	  <div class="clr"></div>
	  </div>
	  <div class="clr"></div>
	  </div>
	  <?php } ?>
	  <?php if ($this->item->params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)) { ?>
	  <div class="itemAuthorLatest">
	  <h3><?php echo JText::_('K2_LATEST_FROM'); ?> <?php echo $this->item->author->name; ?></h3>
	  <ul>
	  <?php foreach ($this->authorLatestItems as $key => $item) { ?>
	  <li class="<?php echo ($key % 2) ? "odd" : "even"; ?>">
	  <a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
	  </li>
	  <?php } ?>
	  </ul>
	  <div class="clr"></div>
	  </div>
	  <?php } */ ?>
	<div class="item-boxes">
		<?php if ($this->item->params->get('itemRelated') && isset($this->relatedItems)) { ?>
			<section class="box list">
				<header><h2><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h2></header>
				<div>
					<ul>
						<?php foreach ($this->relatedItems as $key => $item) { ?>
							<li>
								<?php if ($this->item->params->get('itemRelatedTitle', 1)) { ?>
									<h3><a class="itemRelTitle" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a></h3>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				</div>
			</section>
		<?php } ?>
		<?php if ($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)) { ?>
			<section class="box gallery">
				<header><h2>گالری</h2></header>
				<?php echo $this->item->gallery; ?>
			</section>
		<?php } ?>
	</div>
	<?php echo $this->item->event->AfterDisplay; ?>
	<?php echo $this->item->event->K2AfterDisplay; ?>
	<?php
	if (
			$this->item->params->get('itemComments') &&
			(($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))
	) {
		?>

		<?php echo $this->item->event->K2CommentsBlock; ?>
	<?php } ?>
	<?php
	if (
			$this->item->params->get('itemComments') &&
			($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)
	) {
		?>

		<div class="item-comments">
			<?php if ($this->item->params->get('commentsFormPosition') == 'above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))) { ?>

				<div class="itemCommentsForm">
					<?php echo $this->loadTemplate('comments_form'); ?>
				</div>
			<?php } ?>
			<?php if ($this->item->numOfComments > 0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))) { ?>

				<h3 class="itemCommentsCounter">
					<span><?php echo $this->item->numOfComments; ?></span> <?php echo ($this->item->numOfComments > 1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
				</h3>
				<ul class="itemCommentsList">
					<?php foreach ($this->item->comments as $key => $comment) { ?>
						<li class="<?php
						echo ($key % 2) ? "odd" : "even";
						echo (!$this->item->created_by_alias && $comment->userID == $this->item->created_by) ? " authorResponse" : "";
						echo($comment->published) ? '' : ' unpublishedComment';
						?>">
							<span class="commentLink">
								<a href="<?php echo $this->item->link; ?>#comment<?php echo $comment->id; ?>" name="comment<?php echo $comment->id; ?>" id="comment<?php echo $comment->id; ?>">
									<?php echo JText::_('K2_COMMENT_LINK'); ?>
								</a>
							</span>
							<?php if ($comment->userImage) { ?>
								<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo $this->item->params->get('commenterImgWidth'); ?>" />
							<?php } ?>
							<span class="commentDate"><?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?></span>
							<span class="commentAuthorName">
								<?php echo JText::_('K2_POSTED_BY'); ?>
								<?php if (!empty($comment->userLink)) { ?>
									<a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow"><?php echo $comment->userName; ?></a>
								<?php } else { ?>
									<?php echo $comment->userName; ?>
								<?php } ?>
							</span>
							<p><?php echo $comment->commentText; ?></p>
							<?php
							if (
									$this->inlineCommentsModeration ||
									($comment->published && ($this->params->get('commentsReporting') == '1' || ($this->params->get('commentsReporting') == '2' && !$this->user->guest)))
							) {
								?>
								<span class="commentToolbar">
									<?php if ($this->inlineCommentsModeration) { ?>
										<?php if (!$comment->published) { ?>
											<a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID=' . $comment->id . '&format=raw') ?>"><?php echo JText::_('K2_APPROVE') ?></a>
										<?php } ?>
										<a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID=' . $comment->id . '&format=raw') ?>"><?php echo JText::_('K2_REMOVE') ?></a>
									<?php } ?>
									<?php if ($comment->published && ($this->params->get('commentsReporting') == '1' || ($this->params->get('commentsReporting') == '2' && !$this->user->guest))) { ?>
										<a data-k2-modal="iframe" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID=' . $comment->id) ?>"><?php echo JText::_('K2_REPORT') ?></a>
									<?php } ?>
									<?php if ($comment->reportUserLink) { ?>
										<a class="k2ReportUserButton" href="<?php echo $comment->reportUserLink; ?>"><?php echo JText::_('K2_FLAG_AS_SPAMMER'); ?></a>
									<?php } ?>
								</span>
							<?php } ?>
							<div class="clr"></div>
						</li>
					<?php } ?>
				</ul>

				<div class="itemCommentsPagination">
					<?php echo $this->pagination->getPagesLinks(); ?>
					<div class="clr"></div>
				</div>
			<?php } ?>
			<?php
			if (
					$this->item->params->get('commentsFormPosition') == 'below' &&
					$this->item->params->get('itemComments') &&
					!JRequest::getInt('print') &&
					($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))
			) {
				?>

				<div class="itemCommentsForm">
					<?php echo $this->loadTemplate('comments_form'); ?>
				</div>
			<?php } ?>
			<?php
			$user = JFactory::getUser();
			if ($this->item->params->get('comments') == '2' && $user->guest) {
				?>
				<div class="itemCommentsLoginFirst"><?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS'); ?></div>
			<?php } ?>
		</div>
	<?php } ?>
</article>