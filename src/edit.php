<?php defined('_JEXEC') or die; 
/**
 * Περιέχει κώδικα για την απόδοση λέξεων κλειδιών σε ένα άρθρο
 * ή για την αγνόηση κάποιων λέξεων
 * 
 * 
 * @package	Article Plus
 * @version 1.0
 */
?>

<script language="javascript">

function addKeyword(word) {
	var doc=document.getElementById("metakey").value;
	if (doc.length>0) {
		document.getElementById("metakey").value += "," + word;
	}
	else {
		document.getElementById("metakey").value = word;
	}
	return false;
}

function addAllKeywords(words) {
	var doc=document.getElementById("metakey").value;
	if (doc.length>0) {
		document.getElementById("metakey").value += "," + words;
	} else {
		document.getElementById("metakey").value = words;
	}
	return false;
}

function ignoreWord(word) {
	var doc=document.getElementById("ignoredWords").value;
	if (doc.length>0) {
		document.getElementById("ignoredWords").value += "," + word;
	} else {
		document.getElementById("ignoredWords").value = word;
	}
	return false;
}
</script>


<img align="center" src="components/com_articleplus/images/p1.png" alt="Article Plus" >

<p>
<h1>Title: <?php echo $this->data->content->title;?></h1>
<?php


$data=$this->data->content->introtext ." ".$this->data->content->fulltext;
$data=strip_tags($data);
$keyword = new autokeyword($data);

?>

<form name="adminForm" id="adminForm" method="post" action="index.php">
<div style="display: inline-block;">
<h3><?php echo JText::_('KEYWORDSINARTICLE'); ?>:</h3>
	
<textarea name="metakey" style="background-color:#60A0C1" cols="100" rows="5" id="metakey">
<?php echo $this->data->content->metakey;?>
</textarea>
</div>
<br />

<?php
echo "<h3>";
echo JText::_('KEYWORDSFOUND'); 
echo ":</h3>";
$keywords=$keyword->parse_words();

foreach ($keywords as $key=>$value) {
	if (trim($value))
	echo "<div title='$key' class='style1'>  ($value)$key<br>" .
			"<a href='#' onclick=\"addKeyword('$key');\">" .
			"Add</a>  - <a href='#' " .
			"onclick=\"ignoreWord('$key');\">Block</a></div>";
}
# Διαβάζουμε πλήθος λέξεων σε κάθε φράση
$config=new configuration();
$m=$config->get("phrases_length");
# Αν επιτρέπονται φράσεις τότε ψάχνουμε για να βρούμε αυτές που εμφανίζονται συχνά	
if($m>1){ 
	$keywords=$keyword->parse_multiplewords($m);

	foreach ($keywords as $key=>$value) {
		if (trim($value) )
		echo "<div title='$key' class='style1'>($value)$key<br><a href='#' onclick=\"addKeyword('$key');\">Add</a></div>";
	}
}

# Όλες οι λέξεις-κλειδιά που βρέθηκαν


?>
<br> 
<div style="display: inline-block;">
<h3><?php echo JText::_('BLOCKEDWORDS'); ?>:</h3>
<textarea name="ignoredWords" style="background-color:#60A0C1" id="ignoredWords" cols="100" rows="5" onchange="addcomma();">
</textarea
></div>


<br>
<h3><?php echo JText::_('TEXT'); ?>: </h3>
<?php
echo $data;

?>
<input type="hidden" name="id" value="<?php echo $this->data->content->id;?>" />
<input type="hidden" name="option" value="com_articleplus" />
<input type="hidden" name="action" value="prodkeys" />
<input type="hidden" name="task" value="" />

</form>

