<?php
/**
* @version		1.0.0
* @package		AcePolls
* @subpackage	AcePolls
* @copyright	2009-2011 JoomAce LLC, www.joomace.net
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*
* Based on Apoll Component
* @copyright (C) 2009 - 2011 Hristo Genev All rights reserved
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @link http://www.afactory.org
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
 
$document =& JFactory::getDocument();	 
$document->addStyleDeclaration("div#poll_loading_".$poll->id." {
	background: url(media/system/images/mootree_loader.gif) 0% 50% no-repeat;
	width:100%;
	height:20px; 
	padding: 4px 0 0 20px; 
}
");
?>

<div class="poll<?php echo $params->get('moduleclass_sfx'); ?>" style="border:none; padding:1px;">

<?php if ($params->get('show_poll_title')) : ?>
    <h4><?php echo $poll->title; ?></h4>
<?php endif; ?>

<div id="polldiv_<?php echo $poll->id;?>">

<?php if ($display_poll || !$display_poll) { ?>
<?php //if (true) { ?>
<form action="<?php echo JRoute::_('index.php');?>" method="post" name="poll_vote_<?php echo $poll->id;?>" id="poll_vote_<?php echo $poll->id;?>">
<?php for ($i = 0, $n = count($options); $i < $n; $i ++) { ?>
	<label for="mod_voteid<?php echo $options[$i]->id;?>" class="<?php echo $tabclass_arr[$tabcnt].$params->get('moduleclass_sfx'); ?>" style="display:block; padding:2px;">
		<input type="radio" name="voteid" id="mod_voteid<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" <?php echo $disabled; ?> />
			<?php echo $options[$i]->text; ?>
	</label>
	<?php $tabcnt = 1 - $tabcnt; } 
			
			//show messages box
			if($params->get('show_msg')) : 
				echo '<div id="mod_poll_messages_'.$poll->id.'" style="margin:5px;">'.JText::_($msg);
				if($params->get('show_detailed_msg')) echo " ".$details;
				echo '</div>';
			endif;
	?>
	<div class="readon" style="padding:2px;" id="poll_buttons_<?php echo $poll->id;?>" >	
	<input type="submit" id="submit_vote_<?php echo $poll->id; ?>" name="task_button" class="button" value="<?php echo JText::_('MOD_ACEPOLLS_VOTE'); ?>" <?php echo $disabled; ?> />
	</div>	
	<div id="poll_loading_<?php echo $poll->id;?>" style="display:none;"><?php echo JText::_('MOD_ACEPOLLS_PROCESSING'); ?>
	</div>		

	<input type="hidden" name="option" value="com_acepolls" />
	<input type="hidden" name="id" value="<?php echo $poll->id;?>" />
	<?php if ($params->get('ajax')) { ?>
    <input type="hidden" name="format" value="raw" />
    <input type="hidden" name="view" value="poll" />
	<?php } else { ?>
	<input type="hidden" name="task" value="vote" />
	<?php }; 
	echo "<div>".JHTML::_('form.token')."</div>";  ?>
</form>

<?php if($params->get('ajax')) {
// add mootools
//JHTML::_('behavior.mootools');

$updateValue = '';
$poll_bars_color = $params->get('poll_bars_color');

for ($i = 0; $i < count($results); $i++) {
	if ($params->get('only_one_color')) {
		$background_color = $poll_bars_color;
	}
	else {
		$background_color = "' + options.eq($i).attr('color') + '";	
	}

	$updateValue .= "<div style=\"width:100%\"><div style=\"padding: 3px;\">' + text.eq($i).text() + ' - ' + options.eq($i).attr('percentage') + '%</div><div class=\"poll_module_bar_holder\" id=\"poll_module_bar_holder".$i."\" style=\"width: 98%; height: 14px; margin: 0 0 4px 0; padding:0px; border-radius: 2px 0 0 2px; border:0px solid #".$params->get('poll_bars_border_color')."; color: #ddd\"><div class=\"poll-bar\" id=\"poll_module_bar'+options.eq($i).attr('id')+'\" style=\"background:#$background_color; width:' + options.eq($i).attr('percentage') + '%; \"></div></div></div>";
}

if ($params->get('show_total')) {
	$updateValue .= "<br /><b>".JText::_('MOD_ACEPOLLS_TOTAL_VOTES')."</b>: ' + voters.eq(0).text() + '";
}

$js = "$(document).ready(function(){
	$('#poll_vote_".$poll->id."').submit(function(e) {
		var options = $('#poll_vote_".$poll->id." [name=voteid]');

		var nothing_selected = 1;
		options.each(function(index){
			if($(this).is(':checked')) {
				 nothing_selected = 0;
			}
		});
		
		if (nothing_selected) {
			alert('Please select an option');
			return false;
		} else {
			$('submit_vote_".$poll->id."').attr('disabled', 'disabled');
			$('poll_loading_".$poll->id."').css('display', '');

			$.ajax({
			type: \"POST\",
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: 'xml',
			success: function(xml){
				$(xml).find('option')
				var options = $(xml).find('option')
				var text    = $(xml).find('text')
				var voters  = $(xml).find('voters');
				var oldHeight = $('#polldiv_".$poll->id."').height();
				$('#polldiv_".$poll->id."').fadeTo('slow', 0.001, function(){
					$('#polldiv_".$poll->id."').html('".$updateValue."');
					
					
					var bar_lenghts = new Array();
					for(i=1; i<=options.length; i++){
						bar_lenghts[i] = $('#poll_module_bar'+i).css('width');
						$('#poll_module_bar'+i).css('width', '0px');
					}
					
					var newHeight = $('#polldiv_".$poll->id."').height();
					$('#polldiv_".$poll->id."').css('height', oldHeight);
					$('#polldiv_".$poll->id."').animate({height:newHeight},{ queue: false, duration: 500 });
					$('#polldiv_".$poll->id."').fadeTo({ queue: false, duration: 500 }, 1);
					
					for(i=1; i<=options.length; i++){
						$('#poll_module_bar'+i).delay(250).animate({width:bar_lenghts[i]}, 'slow');
					}
					});
			}
			});
		}
		return false;
	});  
});";

//$document->addScriptDeclaration($js);

?>
<script type="text/javascript">
<?php
echo $js;
?>
</script>
<?php
}
//If user has voted 
	} else { 
	
		foreach ($results as $row) :
			$percent = ($row->votes)? round((100*$row->hits)/$row->votes, 1):0;
			$width = ($percent)? $percent:2; 
			if($params->get('only_one_color')) 
				$background_color = $params->get('poll_bars_color');
			else 
				$background_color = $row->color; ?>
			
			<div>
				<div style="padding:3px;"><?php echo $row->text." - ".$percent; ?>%</div>
				<div style="height:14px; margin: 0 0 4px 0; padding:1px; border-radius: 2px 0 0 2px; border:0px solid #<?php echo $params->get('poll_bars_border_color'); ?>;">
					<div style="width: <?php echo $width; ?>%; height:14px; border-radius: 2px 0 0 2px; background:#<?php echo $background_color; ?>;"></div>
				</div>
			</div>
<?php  endforeach;
			if($params->get('show_total')) 
				echo "<br /><b>".JText::_('MOD_ACEPOLLS_TOTAL_VOTES')."</b>: ".$row->votes;
			
			if($params->get('show_msg')) : 
				echo '<div id="mod_poll_messages_'.$poll->id.'" style="margin:5px;">'.JText::_($msg);
				if($params->get('show_detailed_msg')) { 
					echo " ".$details;
				}
				echo '</div>';
			endif;
 } ?>
<!-- End of #polldiv -->
</div>
<?php if (($params->get('show_view_details')) || ($params->get('rel_article_window'))) { ?>
<div id="poll_links" style="padding-top:5px; ">

	<?php if ($params->get('show_view_details')) : ?>
	<a class="poll_result_link" href="<?php echo JRoute::_('index.php?option=com_acepolls&view=poll&id='.$slug.$itemid); ?>"><?php echo JText::_('MOD_ACEPOLLS_VIEW_DETAILS'); ?></a><br />
	<?php endif; ?>
	
	<?php if ($params->get('show_rel_article')) : ?>
	<a class="poll_result_link" target="<?php echo $params->get('rel_article_window'); ?>" href="<?php echo JRoute::_($params->get('rel_article')); ?>">
		<?php echo JText::_('MOD_ACEPOLLS_READ_RELATED_ARTICLE'); ?> >></a>
	<?php endif; ?>
<?php } ?>

</div>
</div>