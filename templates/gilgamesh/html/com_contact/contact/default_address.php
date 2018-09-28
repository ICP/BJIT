<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<section class="box contact-details">
	<header>
		<h2><?php echo JText::_('COM_CONTACT_DETAILS'); ?></h2>
	</header>
	<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
		<ul class="contacts">
			<li class="email" itemprop="email">
				<?php echo JText::_('COM_CONTACT_EMAIL_LABEL'); ?>
				<span>
					<a href="mailto:<?php echo $this->contact->email_to; ?>"><?php echo $this->contact->email_to; ?></a>
				</span>
			</li>
			<li class="tel" itemprop="telephone">
				<?php echo JText::_('COM_CONTACT_TELEPHONE'); ?>
				<span><?php echo $this->contact->telephone; ?></span>
			</li>
			<?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
				<li class="fax" itemprop="faxNumber">
					<?php echo JText::_('COM_CONTACT_FAX'); ?>
					<span><?php echo $this->contact->fax; ?></span>
				</li>
			<?php endif; ?>
			<?php if ($this->contact->mobile && $this->params->get('show_mobile')) : ?>
				<li class="sms" itemprop="telephone">
					<?php echo JText::_('COM_CONTACT_CONTACT_ENTER_MESSAGE_LABEL'); ?>
					<span><?php echo $this->contact->mobile; ?></span>
				</li>
			<?php endif; ?>
			<?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
				<li class="website">
					<?php echo JText::_('WEBSITE'); ?>
					<span>
						<a href="<?php echo $this->contact->webpage; ?>" target="_blank" rel="noopener noreferrer" itemprop="url">
							<?php echo JStringPunycode::urlToUTF8($this->contact->webpage); ?></a>
					</span>
				</li>
			<?php endif; ?>
			<li class="address">
				<?php echo JText::_('COM_CONTACT_ADDRESS'); ?>
				<span><?php echo $this->contact->address; ?></span>
			</li>
			<?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
			<li class="email">
				<?php echo JText::_('POSTCODE'); ?>
				<span><?php echo $this->contact->postcode; ?></span>
			</li>
			<?php endif; ?>
		</ul>
	</div>
</section>