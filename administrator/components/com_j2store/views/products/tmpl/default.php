<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
// No direct access to this file
defined('_JEXEC') or die;
JHTML::_('behavior.modal');

$sidebar = JHtmlSidebar::render();
$this->params = J2Store::config();
JHTML::_('behavior.modal');
$create_url = 'index.php?option=com_content&view=article&layout=edit';
?>
<?php if(!empty( $sidebar )): ?>
   <div id="j-sidebar-container" class="span2">
      <?php echo $sidebar ; ?>
   </div>
   <div id="j-main-container" class="span10">
 <?php else : ?>
	<div class="j2store">
  <?php endif;?>
  <script type="text/javascript">
  Joomla.submitbutton = function(pressbutton) {
		if(pressbutton == 'create') {
			window.open('<?php echo $create_url;?>')
			return false;
		}
		Joomla.submitform(pressbutton);
  }

  </script>

  	<div class="alert alert-block alert-info">
  		<strong>
		<?php echo JText::_('J2STORE_PRODUCTS_LIST_VIEW_HELP_TEXT');?>
		</strong>		
  	</div>
  	<?php echo J2Store::help()->watch_video_tutorials(); ?>

	<form action="index.php" method="post"	name="adminForm" id="adminForm">

				<?php echo J2Html::hidden('option','com_j2store');?>
				<?php echo J2Html::hidden('view','products');?>
				<?php echo J2Html::hidden('task','browse',array('id'=>'task'));?>
				<?php echo J2Html::hidden('boxchecked','0');?>
				<?php echo J2Html::hidden('filter_order',$this->state->filter_order);?>
				<?php echo J2Html::hidden('filter_order_Dir',$this->state->filter_order_Dir);?>
				<?php echo JHTML::_( 'form.token' ); ?>
				<div class="j2store-product-filters">
					<div class="j2store-alert-box" style="display:none;"></div>
					<!-- general Filters -->
					<?php  echo $this->loadTemplate('filters');?>
					<!-- advanced filters -->
					<?php  echo $this->loadTemplate('advancedfilters');?>
				</div>
				<div class="j2store-product-list">
					<!-- Products items -->
					<?php echo $this->loadTemplate('items');?>
				</div>
			</div>
		</div>
	</form>
<script type="text/javascript">


</script>