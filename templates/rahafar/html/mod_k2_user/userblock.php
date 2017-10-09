<?php
/**
 * @version		$Id$
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.modal');
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2UserBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

	<div class="k2UserBlockDetails">
	  <span class="ubName"><?php echo $user->name; ?></span>
	  <div class="clr"></div>
	</div>

  <ul class="k2UserBlockActions">
		<?php if(is_object($user->profile) && isset($user->profile->addLink)): ?>
		<li>
			<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $user->profile->addLink; ?>"><?php echo JText::_('K2_ADD_NEW_ITEM'); ?></a>
		</li>
		<?php endif; ?>
	</ul>
	
	<ul class="k2UserBlockRenderedMenu">
		<?php $level = 1; foreach($menu as $key => $link): $level++; ?>
		<li class="linkItemId<?php echo $link->id; ?>">
			<?php if($link->type=='url' && $link->browserNav==0): ?>
			<a href="<?php echo $link->route; ?>"><?php echo $link->name; ?></a>
			<?php elseif(strpos($link->link,'option=com_k2&view=item&layout=itemform') || $link->browserNav==2): ?>
			<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $link->route; ?>"><?php echo $link->name; ?></a>
			<?php else: ?>
			<a href="<?php echo $link->route; ?>"<?php if($link->browserNav==1) echo ' target="_blank"'; ?>><?php echo $link->name; ?></a>
			<?php endif; ?>
	
			<?php if(isset($menu[$key+1]) && $menu[$key]->level < $menu[$key+1]->level): ?>
			<ul>
			<?php endif; ?>
	
			<?php if(isset($menu[$key+1]) && $menu[$key]->level > $menu[$key+1]->level): ?>
			<?php echo str_repeat('</li></ul>', $menu[$key]->level - $menu[$key+1]->level); ?>
			<?php endif; ?>
	
		<?php if(isset($menu[$key+1]) && $menu[$key]->level == $menu[$key+1]->level): ?>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
  </ul>

  <form action="/index.php" method="post">
	<input type="submit" name="Submit" class="btn button ubLogout" value="<?php echo JText::_('K2_LOGOUT'); ?>" />
    <input type="hidden" name="option" value="<?php echo (K2_JVERSION=='16')?'com_users':'com_user'?>" />
    <input type="hidden" name="task" value="<?php echo (K2_JVERSION=='16')?'user.logout':'logout'?>" />
    <input type="hidden" name="return" value="<?php echo $return; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
  </form>
</div>
