<?php defined('_JEXEC') or die; 
/**
 * Η κύρια σελίδα του περιεχομένου
 * 
 * @package	Article Plus
 */
?>
<img align="center" src="components/com_articleplus/images/p1.png" alt="Article Plus" >

<p>
<form name="adminForm" method="post" id="adminForm">
<table class="adminform">
<tr><td><?php echo JText::_("CATEGORY");?>:
<select name="catid">
	<option value=""><?php echo JText::_("ALL");?></option>
	<?php
	$catigoria=JRequest::getVar("catid");
	foreach ($this->data->catlist as $i) {
		echo "<option value='$i->id'".($catigoria==$i->id?" selected":"").">$i->title</option>";
	}
	?>
</select>
<input type="button" name="submit1" value='<?php echo JText::_("FILTER");?>' onclick="document.adminForm.submit();" /></td></tr>
</table>
<table class="adminlist">
<tr>
<th style="width:20px;">id</th><th><?php echo JText::_("TITLE");?></th>
<th><?php echo JText::_("PUBLISHED");?></th>
<th><?php echo JText::_("KEYWORDS");?></th>
</tr>
<?php
	foreach($this->data->contentlist as $j) {
		echo "<tr><td>$j->id";
		echo "</td><td><a href='index.php?option=com_articleplus&action=prodkeys&task=addkeys&cid=$j->id'>";
		echo $j->title;
		echo "</a></td><td>$j->publish_up</td><td>";
		$word=$j->metakey;
		if($word == "")
			echo 0;
		else
			echo count(explode(",", $word));
		echo "</td></tr>";
	}
?>
</table>
<input type="hidden" name="option" value="com_articleplus" />
<input type="hidden" name="action" value="prodkeys" />
<input type="hidden" name="task" value="view" />
</form>