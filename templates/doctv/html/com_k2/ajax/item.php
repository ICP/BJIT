<?php
/**
 * @version		$Id: item.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<article class="item" data-created="<?php echo JHTML::_('date', $this->item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>">
	<?php echo $this->item->event->BeforeDisplay; ?>
	<?php echo $this->item->event->K2BeforeDisplay; ?>
	<?php if ($this->item->params->get('itemTitle')) { ?>
		<header class="item-header">
			<h2 class="item-title"><?php echo $this->item->title; ?></h2>
			<?php if (JRequest::getVar('format', null) == "raw") { ?>
				<div class="link-ext">
					<a href="<?php echo $this->item->link; ?>" target="_blank" data-title="باز کردن این صفحه در تب جدید" data-toggle="tooltip" data-placement="top"><i class="icon-link-ext"></i></a>
				</div>
			<?php } ?>
		</header>
	<?php } ?>
	<?php echo $this->item->event->AfterDisplayTitle; ?>
	<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	<div class="item-body">
		<?php echo $this->item->event->BeforeDisplayContent; ?>
		<?php echo $this->item->event->K2BeforeDisplayContent; ?>
		<?php
		if ($this->item->params->get('itemImage') && !empty($this->item->image)) {
			$hasVideo = $videoFile = '';
			if ($this->item->params->get('itemVideo') && !empty($this->item->video)) {
				$hasVideo = ' has-video';
				$videoFile = ' data-video="' . $this->item->video . '"';
			}
			$gallery = ($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)) ? true : false;
			?>
			<div class="item-media<?php if ($gallery) { ?> item-gallery<?php } ?><?php echo $hasVideo; ?>"<?php if ($gallery) { ?> id="item-media"<?php } ?>>
				<div class="img<?php echo $hasVideo; ?>"<?php echo $videoFile; ?> <?php if (!$gallery) { ?> id="item-media"<?php } ?>>
					<img src="<?php echo $this->item->image; ?>" alt="<?php
					if (!empty($this->item->image_caption))
						echo K2HelperUtilities::cleanHtml($this->item->image_caption);
					else
						echo K2HelperUtilities::cleanHtml($this->item->title);
					?>" />
						 <?php if ($this->item->params->get('itemImageMainCaption') && !empty($this->item->image_caption)) { ?>
						<span class="image-caption"><?php echo $this->item->image_caption; ?></span>
					<?php } ?>
					<?php if ($this->item->params->get('itemImageMainCredits') && !empty($this->item->image_credits)) { ?>
						<span class="image-credits"><?php echo $this->item->image_credits; ?></span>
					<?php } ?>
				</div>
				<?php if ($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)) { ?>
				<?php echo $this->item->gallery; ?>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if ($this->item->created_by_alias) { ?>
			<div class="item-author">
				<strong><?php echo $this->item->created_by_alias; ?></strong>
			</div>
		<?php } ?>
		<?php if (!empty($this->item->fulltext)) { ?>
			<?php if ($this->item->params->get('itemIntroText')) { ?>
				<div class="item-introtext">
					<?php echo $this->item->introtext; ?>
				</div>
			<?php } ?>
			<?php if ($this->item->params->get('itemFullText')) { ?>
				<div class="item-fulltext">
					<?php echo $this->item->fulltext; ?>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="item-fulltext">
				<?php echo $this->item->introtext; ?>
			</div>
		<?php } ?>
		<div class="clearfix"></div>
		<?php if ($this->item->params->get('itemAttachments') && count($this->item->attachments)) { ?>
			<div class="item-attachments">
				<!--<h4>پیوست‌ها</h4>-->
				<?php foreach ($this->item->attachments as $attachment) { ?>
					<a class="btn btn-warning" title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>">
						<?php echo $attachment->title; ?> <i class="icon-download"></i>
					</a>
					<?php if ($this->item->params->get('itemAttachmentsCounter')) { ?>
							<!--<span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits == 1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>-->
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
		<div class="clearfix"></div>
		<?php if ($this->item->params->get('itemExtraFields') && count($this->item->extra_fields)) { ?>
			<div class="item-fields">
				<h3><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h3>
				<ul>
					<?php foreach ($this->item->extra_fields as $key => $extraField) { ?>
						<?php if ($extraField->value) { ?>
							<li class="<?php echo ($key % 2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
								<span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span>
								<span class="itemExtraFieldsValue"><?php echo $extraField->value; ?></span>
							</li>
						<?php } ?>
					<?php } ?>
				</ul>
				<div class="clearfix"></div>
			</div>
		<?php } ?>
		<?php echo $this->item->event->AfterDisplayContent; ?>
		<?php echo $this->item->event->K2AfterDisplayContent; ?>
		<div class="clearfix"></div>
	</div>
	<?php if (JRequest::getInt('print') == 1) { ?>
		   <a class="itemPrintThisPage" rel="nofollow" href="#" onclick="window.print();
	                   return false;">
			<span><?php echo JText::_('K2_PRINT_THIS_PAGE'); ?></span>
		</a>
	<?php } ?>
	<?php /*
	  <?php if ((JRequest::getInt('print') != 1) && ($this->item->params->get('itemTwitterButton', 1) || $this->item->params->get('itemFacebookButton', 1) || $this->item->params->get('itemGooglePlusOneButton', 1))) { ?>
	  <div class="item-sharings">
	  <?php if ($this->item->params->get('itemTwitterButton', 1)) { ?>
	  <div class="item-twitter">
	  <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal"<?php if ($this->item->params->get('twitterUsername')): ?> data-via="<?php echo $this->item->params->get('twitterUsername'); ?>"<?php endif; ?>><?php echo JText::_('K2_TWEET'); ?></a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
	  </div>
	  <?php } ?>
	  <?php if ($this->item->params->get('itemFacebookButton', 1)) { ?>
	  <div class="item-facebook">
	  <div id="fb-root"></div>
	  <script type="text/javascript">
	  (function (d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) {
	  return;
	  }
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	  }(document, 'script', 'facebook-jssdk'));
	  </script>
	  <div class="fb-like" data-send="false" data-width="200" data-show-faces="true"></div>
	  </div>
	  <?php } ?>
	  <?php if ($this->item->params->get('itemGooglePlusOneButton', 1)) { ?>
	  <div class="item-gplus">
	  <g:plusone annotation="inline" width="120"></g:plusone>
	  <script type="text/javascript">
	  (function () {
	  window.___gcfg = {lang: 'en'}; // Define button default language here
	  var po = document.createElement('script');
	  po.type = 'text/javascript';
	  po.async = true;
	  po.src = 'https://apis.google.com/js/plusone.js';
	  var s = document.getElementsByTagName('script')[0];
	  s.parentNode.insertBefore(po, s);
	  })();
	  </script>
	  </div>
	  <?php } ?>
	  <div class="clearfix"></div>
	  </div>
	  <?php } ?>
	 */ ?>
	<?php /*
	  <?php if ($this->item->params->get('itemCategory') || $this->item->params->get('itemTags') || $this->item->params->get('itemAttachments')) { ?>
	  <div class="item-links">
	  <?php if ($this->item->params->get('itemCategory')) { ?>
	  <div class="item-category">
	  <span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
	  <a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
	  </div>
	  <?php } ?>
	  <?php if ($this->item->params->get('itemAttachments') && count($this->item->attachments)) { ?>
	  <div class="item-attachments">
	  <span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
	  <ul>
	  <?php foreach ($this->item->attachments as $attachment) { ?>
	  <li>
	  <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
	  <?php if ($this->item->params->get('itemAttachmentsCounter')) { ?>
	  <span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits == 1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
	  <?php } ?>
	  </li>
	  <?php } ?>
	  </ul>
	  </div>
	  <?php } ?>
	  <div class="clearfix"></div>
	  </div>
	  <?php } */ ?>
	<?php /*
	<?php if ($this->item->params->get('itemRelated') && isset($this->relatedItems)) { ?>
		<div class="item-related">
			<h3><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h3>
			<ul>
				<?php foreach ($this->relatedItems as $key => $item) { ?>
					<li class="<?php echo ($key % 2) ? "odd" : "even"; ?>">
						<?php if ($this->item->params->get('itemRelatedTitle', 1)) { ?>
							<a class="itemRelTitle" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedCategory')) { ?>
							<div class="itemRelCat"><?php echo JText::_("K2_IN"); ?> <a href="<?php echo $item->category->link ?>"><?php echo $item->category->name; ?></a></div>
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedAuthor')) { ?>
							<div class="itemRelAuthor"><?php echo JText::_("K2_BY"); ?> <a rel="author" href="<?php echo $item->author->link; ?>"><?php echo $item->author->name; ?></a></div>
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedImageSize')) { ?>
							<img style="width:<?php echo $item->imageWidth; ?>px;height:auto;" class="itemRelImg" src="<?php echo $item->image; ?>" alt="<?php K2HelperUtilities::cleanHtml($item->title); ?>" />
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedIntrotext')) { ?>
							<div class="itemRelIntrotext"><?php echo $item->introtext; ?></div>
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedFulltext')) { ?>
							<div class="itemRelFulltext"><?php echo $item->fulltext; ?></div>
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedMedia')) { ?>
							<?php if ($item->videoType == 'embedded') { ?>
								<div class="item-related-embed"><?php echo $item->video; ?></div>
							<?php } else { ?>
								<div class="item-related-media"><?php echo $item->video; ?></div>
							<?php } ?>
						<?php } ?>
						<?php if ($this->item->params->get('itemRelatedImageGallery')) { ?>
							<div class="item-related-gallery"><?php echo $item->gallery; ?></div>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
			<div class="clearfix"></div>
		</div>
	<?php } ?>
	<?php if ($this->item->params->get('itemVideo') && !empty($this->item->video)) { ?>
		<div class="item-video">
			<h3><?php echo JText::_('K2_MEDIA'); ?></h3>
			<?php if ($this->item->videoType == 'embedded') { ?>
				<div class="item-video-embed">
					<?php echo $this->item->video; ?>
				</div>
			<?php } else { ?>
				<div class="mediaplayer"><?php echo $this->item->video; ?></div>
			<?php } ?>
			<?php if ($this->item->params->get('itemVideoCaption') && !empty($this->item->video_caption)) { ?>
				<span class="item-video-caption"><?php echo $this->item->video_caption; ?></span>
			<?php } ?>
			<?php if ($this->item->params->get('itemVideoCredits') && !empty($this->item->video_credits)) { ?>
				<span class="item-video-credits"><?php echo $this->item->video_credits; ?></span>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
	<?php } ?>
	<?php if ($this->item->params->get('itemImageGallery') && !empty($this->item->gallery)) { ?>
		<div class="item-gallery">
			<h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
			<?php echo $this->item->gallery; ?>
		</div>
	<?php } ?>
	<?php if ($this->item->params->get('itemNavigation') && !JRequest::getCmd('print') && (isset($this->item->nextLink) || isset($this->item->previousLink))) { ?>
		<div class="item-navigation">
			<span class="navigation-titles"><?php echo JText::_('K2_MORE_IN_THIS_CATEGORY'); ?></span>
			<?php if (isset($this->item->previousLink)) { ?>
				<a class="item-prev" href="<?php echo $this->item->previousLink; ?>">
					&laquo; <?php echo $this->item->previousTitle; ?>
				</a>
			<?php } ?>
			<?php if (isset($this->item->nextLink)) { ?>
				<a class="item-next" href="<?php echo $this->item->nextLink; ?>">
					<?php echo $this->item->nextTitle; ?> &raquo;
				</a>
			<?php } ?>
		</div>
	<?php } ?>
	*/ ?>
	<?php echo $this->item->event->AfterDisplay; ?>
	<?php echo $this->item->event->K2AfterDisplay; ?>
	<?php if ($this->item->params->get('itemComments') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))) { ?>
		<?php echo $this->item->event->K2CommentsBlock; ?>
	<?php } ?>
	<?php if ($this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)) { ?>
		<div class="box header-condensed list-unstyled list_border-top list_padding comments item-comments" id="comments">
			<?php if ($this->item->params->get('commentsFormPosition') == 'above' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))) { ?>
				<div class="comment-form">
					<?php echo $this->loadTemplate('comments_form'); ?>
				</div>
			<?php } ?>
			<?php if ($this->item->numOfComments > 0 && $this->item->params->get('itemComments') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2'))) { ?>
				<header>
					<h2 class="comments-counter"><?php echo ucfirst(JText::_('K2_COMMENTS')); ?></h2>
				</header>
				<section class="box-content">
					<ul class="comments-list">
						<?php foreach ($this->item->comments as $key => $comment) { ?>
							<li class="<?php
							echo ($key % 2) ? "odd" : "even";
							echo (!$this->item->created_by_alias && $comment->userID == $this->item->created_by) ? " authorResponse" : "";
							echo($comment->published) ? '' : ' unpublishedComment';
							?>">
								<div class="inner">
									<div class="contents">
										<div class="title">
											<div class="name">
												<?php if (!empty($comment->userLink)) { ?>
													<a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow">
														<?php echo $comment->userName; ?>
													</a>
												<?php } else { ?>
													<?php echo $comment->userName; ?>
												<?php } ?>
											</div>
											<div class="subtitle"><?php echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?></div>
										</div>
										<div class="text"><?php echo $comment->commentText; ?></div>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				</section>
				<div class="comments-pagination pagination pagination-centered">
					<?php echo $this->pagination->getPagesLinks(); ?>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
		</div>
		<?php if ($this->item->params->get('commentsFormPosition') == 'below' && $this->item->params->get('itemComments') && !JRequest::getInt('print') && ($this->item->params->get('comments') == '1' || ($this->item->params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))) { ?>
			<div class="box bg_gray header-condensed comment-form">
				<?php echo $this->loadTemplate('comments_form'); ?>
			</div>
		<?php } ?>
		<?php
		$user = JFactory::getUser();
		if ($this->item->params->get('comments') == '2' && $user->guest) {
			?>
			<div><?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS'); ?></div>
		<?php } ?>
	<?php } ?>
</article>