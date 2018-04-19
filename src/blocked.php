<?php
/**
 * Πληροφορίες σχετικά με τις μπλοκαρισμένες σελίδες
 * 
 * @package		Article Plus
 * 
 */

 defined('_JEXEC') or die; 
echo "<h1>";
echo JText::_("BLOCKED_KEYWORDS"); 
echo ":</h1>";
foreach($this->data->rejects as $key=>$value) {
	if (trim($value) )
	echo "<div class='style1'>$value <a href='index.php?option=com_articleplus&action=prodkeys&task=unblock&kw=$value' onclick='parent.window.location.reload(true);'><br>Unblock</a></div>";
}
?>

<form name="adminForm" id="adminForm">
<input type="hidden" name="option" value="com_articleplus" />
<input type="hidden" name="action" value="prodkeys" />
<input type="hidden" name="task" value="" />
</form>