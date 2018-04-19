<?php defined('_JEXEC') or die; 
/**
 * Control Panel
 * 
 * @package	Article Plus
 */
?>

<div id="cpanel">
	<div style="float:left;">
		<div class="icon">
		<a title="<?php echo JText::_('CONTENT1'); ?>" 
		href="index.php?option=com_articleplus&amp;action=prodkeys&amp;task=view" >
		<img src="components/com_articleplus/images/contents.png" 
		alt="<?php echo JText::_('CONTENT1');?>" /><br />
		
		<?php echo JText::_('CONTENT1'); ?></a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
		<a title="<?php echo JText::_('BLOCKED1'); ?>" 
		href="index.php?option=com_articleplus&amp;action=prodkeys&amp;task=blocked_words">
		<img src="components/com_articleplus/images/blocked.png" 
		alt="<?php echo JText::_('BLOCKED1');?>" /><br />
		<?php echo JText::_('BLOCKED1'); ?></a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
		<a title="<?php echo JText::_('CONFIGURATION1'); ?>" 
		href="index.php?option=com_articleplus&amp;action=prodkeys&amp;task=showconfig">
		<img src="components/com_articleplus/images/configuration.png" 
		alt="<?php echo JText::_('CONFIGURATION1');?>" /><br />
		<?php echo JText::_('CONFIGURATION1'); ?></a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
		<a title="<?php echo JText::_('SEARCH'); ?>" 
		href="index.php?option=com_articleplus&amp;action=prodkeys&amp;task=searchbykeyword">
		<img src="components/com_articleplus/images/search.png" 
		alt="<?php echo JText::_('SEARCH');?>" /><br />
		<?php echo JText::_('SEARCH'); ?></a>
		</div>
	</div>
</div>
