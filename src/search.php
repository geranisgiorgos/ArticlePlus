<script language="javascript">

function activate_search() {
	var kword = document.getElementById('kw').value;
	window.location.href ="index.php?option=com_articleplus&action=prodkeys&task=show_results&key="+kword;
}

function runScript(e) {
	
    if (e.which == 13 || e.keyCode == 13) {
		alert("Type keywords and press Search button");
    }
}
 
</script>
<?php
/**
 * Αναζήτηση άρθρων με βάση λέξεις κλειδιά
 * 
 * @package		Article Plus
 * 
 */

 defined('_JEXEC') or die; 
 
$keyword="γκάλης"; 
 
?>

<form name="adminForm" method="post" id="adminForm" >

Keyword: <input type="text" name="keyword" id="kw" onkeypress="runScript(event)" >
<!--<a href="index.php?option=com_articleplus&amp;action=prodkeys&amp;task=show_results&amp;key=<?php echo $keyword?>">Search</a>
-->
<input type="button" name="submit1" value='<?php echo JText::_("SEARCH");?>' onclick="activate_search();" />

</form>



