<?php
/**
 * @version     1.0.0
 * @package     com_radio
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */

// no direct access
defined('_JEXEC') or die;

$data = $this->createOutput();

?>
<script type="text/javascript" >
//var $s = jQuery.noConflict();
$(document).ready(function(){
	var h = $('#listen').find('.status').next().css('height');
	$('#listen .status').css('cursor','pointer');
	$('#listen .status').next().css('height','0px');
	$('#listen .status').live('click',function(){
		var n = $(this).next('.see_instead');
		if($(n).css('height') == '0px') {
			$(n).animate({
				'height' : h
			},300);
		} else {
			$(n).animate({
				'height' : '0px'
			},300);
		}
	});
});
</script>
<?php 
$tz = JRequest::getVar('tz');
if($data['live'] === true){
?>
<div class="status"><h3><?php echo JText::_('STREAMING_LIVE'); ?>&#58;&nbsp;</h3><br /><span><?php echo JText::_('LISTEN'); ?></span></div>
<div class="see_instead">
	<div>
		<ul>
			<li class="wmplayer first-li">
				<a onclick="window.open(this.href, this.target, 'width=340, height=200'); return false;" target="popup" href="<?php echo JURI::Base(); ?>components/com_radio/players/wmplayer.php?url=<?php echo urlencode($data['asx']); ?>"><?php echo JText::_('MEDIAPLAYER'); ?></a>
			</li>
			<li class="silverlight">
				<a onclick="window.open(this.href, this.target, 'width=340, height=200'); return false;" target="popup" href="<?php echo JURI::Base(); ?>components/com_radio/players/silverlight.php?url=<?php echo urlencode($data['url']); ?>"><?php echo JText::_('SILVERLIGHT'); ?></a>
			</li>
			<li class="link last-li">
				<a title="<?php echo JText::_('DIRECT_LINK'); ?>" href="<?php echo $data['asx']; ?>"><?php echo JText::_('DIRECT_LINK'); ?></a>
			</li>
		</ul>
		<div class="clear"></div>
	</div>
</div>
<?php
} else if ($data['live'] !== true && $data['showlinks'] === true){
?>
<div class="status">
	<h3><?php echo JText::_('NEXT_STREAMING'); ?>&#58;&nbsp;</h3>
	<span><?php echo $data['start']; ?>&nbsp;&ndash;&nbsp;<?php echo $data['end'] . " " . JText::_('TZ'); ?></span>
	<div class="clear"></div>
</div>
<?php if ($data['archive'] || $data['frequencies'] || $data['programs']){ ?>
<div class="see_instead">
	<div>
		<em><?php echo JText::_('SEE_INSTEAD'); ?>&#58;</em><br />
		<ul>
<?php } ?>
	<?php if ($data['archive']){ ?>
			<li class="archive" class="first-li"><a href="<?php echo $data['archive']; ?>"><?php echo JText::_('RADIO_ARCHIVE'); ?></a></li>
	<?php } ?>

	<?php if ($data['frequencies']){ ?>
			<li class="frequencies"><a href="<?php echo $data['frequencies']; ?>"><?php echo JText::_('FREQUENCIES'); ?></a></li>
	<?php } ?>

	<?php if ($data['programs']){ ?>
			<li class="schedule last-li"><a href="<?php echo $data['programs']; ?>"><?php echo JText::_('SCHEDULE'); ?></a></li>
	<?php } ?>
<?php if ($data['archive'] || $data['frequencies'] || $data['programs']){ ?>
		</ul>
		<div class="clear"></div>
	</div>
</div>
<?php } ?>
<?php
} else {
	echo '';
}

JFactory::getApplication()->close();