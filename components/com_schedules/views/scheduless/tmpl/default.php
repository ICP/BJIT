<?php
/**
 * @version     1.0.0
 * @package     com_schedules
 * @copyright   Copyright (C) 2012,  Pooya TV. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid Roshan <faridv@gmail.com> - http://www.faridr.ir
 */


// no direct access
defined('_JEXEC') or die;

header('Location: ' . JRoute::_('index.php?option=com_schedules&view=schedules'));
?>

<?php if($this->items) : ?>

    <div class="items">

        <ul class="items_list">

            <?php foreach ($this->items as $item) :?>

                
				<li><a href="<?php echo JRoute::_('index.php?option=com_schedules&view=schedules&id=' . (int)$item->id); ?>"><?php echo $item->occassion; ?></a></li>

            <?php endforeach; ?>

        </ul>

    </div>

     <div class="pagination">
        <p class="counter">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
    <?php if(JFactory::getUser()->authorise('core.create', 'com_schedules.schedules')): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_schedules&task=schedules.edit&id=0'); ?>">Add</a>
	<?php endif; ?>
<?php else: ?>
    
    There are no items in the list

<?php endif; ?>