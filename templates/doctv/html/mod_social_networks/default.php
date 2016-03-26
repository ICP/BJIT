<?php
/**
 * Joomla! 1.6 module mod_social_networks
 * @author Farid roshan
 * @package Joomla
 * @subpackage Social_networks
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 * This module structure created by Yajuvendra.
 */
// no direct access
defined('_JEXEC') or die; 

$count = count($links);

$direction = ' ' . $params->get('direction', 'vertical');
?>
<ul id="social-networks">
<?php
for($i = 0; $i < $count; $i++){
?>
	<li class="social-item<?php echo $direction; ?>">
		<a class="social-icon icon-<?php echo $links[$i]['type']; ?>" href="<?php echo $links[$i]['link']; ?>" title="<?php echo $links[$i]['title']; ?>">
			<span></span><?php echo $links[$i]['title']; ?>
		</a>
		<?php /*
		<a class="social-link" href="<?php echo $links[$i]['link']; ?>" title="<?php echo $links[$i]['title']; ?>">
			<?php echo $links[$i]['title']; ?>
		</a>
		*/ ?>
	</li>
<?php
}
?>
</ul>