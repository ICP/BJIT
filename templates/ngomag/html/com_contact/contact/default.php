<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');
$tparams = $this->item->params;
//var_dump($this->contact);
?>

<div id="item" class="item misc contact<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Person">
	<?php echo $this->item->event->beforeDisplayContent; ?>
	<div class="item-body">
		<figure id="item-media" class="item-image">
			<iframe src="http://maps.google.com/maps?q=<?php echo $this->contact->con_position; ?>&z=15&output=embed" width="100%" height="460" frameborder="0" style="border:0"></iframe>
<!--			<a href="<?php echo $this->contact->image; ?>">
			<?php echo JHtml::_('image', $this->contact->image, $this->contact->name, array('align' => 'middle', 'itemprop' => 'image')); ?>
			</a>-->
		</figure>
		<div class="item-boxes">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<?php if ($tparams->get('allow_vcard')) : ?>
						<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS'); ?>
						<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id=' . $this->contact->id . '&amp;format=vcf'); ?>">
							<?php echo JText::_('COM_CONTACT_VCARD'); ?></a>
					<?php endif; ?>
					<?php echo $this->loadTemplate('address'); ?>
				</div>
				<div class="col-xs-12 col-md-6">
					<?php if ($tparams->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
						<?php echo $this->loadTemplate('form'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
