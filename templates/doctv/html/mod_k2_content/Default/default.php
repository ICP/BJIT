<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>
	<?php if(count($items)): ?>
	<ul id="news">
		<?php foreach ($items as $key=>$item):	?>
		<li>
		  <?php if($params->get('itemDateCreated')): ?>
		   &nbsp;-&nbsp;<span class="moduleItemDateCreated"><?php echo JHTML::_('date', $item->created, 'Y-m-d'); ?></span>
		  <?php endif; ?>
			<?php if($params->get('itemAuthor')): ?>
		  <div class="moduleItemAuthor">
			  <?php echo K2HelperUtilities::writtenBy($item->authorGender); ?>
					<?php if(isset($item->authorLink)): ?>
					<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a>
					<?php else: ?>
					<?php echo $item->author; ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>
		  <?php if($params->get('itemImage') || $params->get('itemIntroText')): ?>
		  <div class="moduleItemIntrotext">
			  <?php if($params->get('itemImage') && isset($item->image)): ?>
			  <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
				<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
			  </a>
			  <?php endif; ?>
		  <?php if($params->get('itemTitle')): ?>
		  <h4><a class="moduleItemTitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h4>
		  <?php endif; ?>
			<?php if($params->get('itemIntroText')): ?>
			<p><?php echo $item->introtext; ?></p>
			<?php endif; ?>
				<?php if($params->get('itemReadMore')) : ?>
				<a class="readmore" href="<?php echo $item->link; ?>">
					<?php echo JText::_('K2_READ_MORE'); ?>
				</a>
				<?php endif; ?>
		  </div>
		  <?php endif; ?>
		  <?php if($params->get('itemExtraFields') && count($item->extra_fields)): ?>
		  <div class="moduleItemExtraFields">
			  <b><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></b>
			  <ul>
				<?php foreach ($item->extra_fields as $extraField): ?>
						<?php if($extraField->value): ?>
						<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
							<span class="moduleItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
							<span class="moduleItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
							<div class="clr"></div>
						</li>
						<?php endif; ?>
				<?php endforeach; ?>
			  </ul>
		  </div>
		  <?php endif; ?>
		  <div class="clr"></div>
		  <?php if($params->get('itemVideo')): ?>
		  <div class="moduleItemVideo">
			<?php echo $item->video ; ?>
			<span class="moduleItemVideoCaption"><?php echo $item->video_caption ; ?></span>
			<span class="moduleItemVideoCredits"><?php echo $item->video_credits ; ?></span>
		  </div>
		  <?php endif; ?>
		  <div class="clr"></div>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	
	<?php if($params->get('itemCustomLink')): ?>
	<a class="moduleCustomLink" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
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
