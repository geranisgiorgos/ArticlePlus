<?php
/**
 * @package		Article Plus
 */

defined('_JEXEC') or die;

# Συνάρτηση η οποία περιέχει μεθόδους για την παραγωγή λέξεων-κλειδιών
class prodkeys {
	var $data;
	# Συνάρτηση για την εμφάνιση της σελίδας
	function view() {
		$contlist=new acontent();
		$this->data->contentlist=$contlist->getlist();
		$catigories=new categories();
		$this->data->catlist=$catigories->getlist();
		JToolBarHelper::title(JText::_('COM_ARTICLEPLUS'));
		JToolBarHelper::custom('back', 'back.png', 'back_f2.png', 'Main', false, false);
		require_once(JPATH_COMPONENT_ADMINISTRATOR."/main.php");
	}
	
	# Συνάρτηση για την επιλογή και προσθήκη λέξεων κλειδιών στο άρθρο
	function addkeys() {
		$content=new acontent();
		$content->load(JRequest::getVar("cid"));
		$this->data->content=$content;
		JHTML::stylesheet( 'articleplus.css', 'administrator/components/com_articleplus/' );
		JToolBarHelper::title(JText::_('COM_ARTICLEPLUS_EDIT'));
		JToolBarHelper::custom('back', 'back.png', 'back_f2.png', 'Main', false, false);
		JToolBarHelper::custom('cancel', 'cancel.png', 'cancel_f2.png', 'Cancel', false, false);
		JToolBarHelper::custom('saveKeywords', 'save.png', 'save_f2.png', 'Save', false, false);
		require_once(JPATH_COMPONENT_ADMINISTRATOR."/edit.php");
	}
	
	# Ακύρωση
	function cancel() {
		$this->view();
	}
	
	# Αποθήκευση λέξεων κλειδιών
	function saveKeywords () {
		$acontent=new acontent();
		$acontent->saveKeywords();
		$keywords=new key_words();
		$keywords->saveKeywords();
		$mainframe=JFactory::getApplication();
		$mainframe->redirect("index.php?option=com_articleplus", JText::_("PROCESSED_KEYWORDS"));
	}

	# Αναζήτηση άρθρων
	function searchbykeyword() {
		JHTML::stylesheet( 'articleplus.css', 'administrator/components/com_articleplus/' );
		JToolBarHelper::title(JText::_('SEARCHKEYWORD'));
		JToolBarHelper::custom('back', 'back.png', 'back_f2.png', 'Main', false, false);
		require_once(JPATH_COMPONENT_ADMINISTRATOR."/search.php");
	}
	
	# Εμφανίζει τα αποτελέσματα της αναζήτησης με βάση μία λέξη-κλειδί
	function show_results(){
		JHTML::stylesheet( 'articleplus.css', 'administrator/components/com_articleplus/' );
		JToolBarHelper::title(JText::_('RESULTS'));
		JToolBarHelper::custom('back', 'back.png', 'back_f2.png', 'Main', false, false);
		
		$keyword=JRequest::getVar('key');
		echo "<div title='$keyword' class='style1'> Keyword=$keyword</div>";
		$contlist=new acontent();
		$this->data->contentlist=$contlist->getlist();
		echo "<br /> <br />";
		echo '<table class="adminlist">';
		echo "<tr>";
		echo "<th style='width:20px;'>id</th><th>";
		echo JText::_("TITLE");
		echo "</th><th>";
		echo JText::_("PUBLISHED");
		echo "</th><th>";
		echo JText::_("KEYWORDS");
		echo "</th></tr>";
 		foreach($this->data->contentlist as $j){
 			$pos=strpos($j->metakey, $keyword);
 			if($pos!==false){ 
 				echo "<tr><td>$j->id";
				echo "</td><td><a href='index.php?option=com_articleplus&action=prodkeys&task=addkeys&cid=$j->id'>";
				echo $j->title;
				echo "</a></td><td>$j->publish_up</td><td>";
				$word=$j->metakey;
				echo count(explode(",", $word));
				echo "</td></tr>";
 			}
 		}
	echo "</table>";
		
	}


	# Εμφάνιση λίστας μπλοκαρισμένων λέξεων
	function blocked_words() {
		$blocked=new key_words();
		$this->data->rejects=$blocked->getlist();
		JHTML::stylesheet( 'articleplus.css', 'administrator/components/com_articleplus/' );
		JToolBarHelper::title(JText::_('BLOCKED'));
		JToolBarHelper::custom('back', 'back.png', 'back_f2.png', 'Main', false, false);
		require_once(JPATH_COMPONENT_ADMINISTRATOR."/blocked.php");
	}
	
	# Ξεμπλοκάρει μία μπλοκαρισμένη λέξη
	function unblock() {
		$word=JRequest::getVar("kw");
		$blocked=new key_words();
		$blocked->remove($word);
		$window=JFactory::getApplication();
		$window->redirect("index.php?option=com_articleplus&action=prodkeys&task=blocked_words", JText::_("UNBLOCKED"));
	}
	
	// Εμφάνιση ρυθμίσεων
	function showconfig() {
		JHTML::stylesheet( 'articleplus.css', 'administrator/components/com_articleplus/' );
		JToolBarHelper::title(JText::_('CONFIGURATION'));
		JToolBarHelper::custom('back', 'back.png', 'back_f2.png', 'Main', false, false);
		JToolBarHelper::custom('cancelconfig', 'cancel.png', 'cancel_f2.png', 'Cancel', false, false);
		JToolBarHelper::custom('saveconfig', 'save.png', 'save_f2.png', 'Save', false, false);
		$config=new configuration();
		$config->view();
	}
	
	# Κύριο παράθυρο
	function main(){
		JHTML::stylesheet( 'articleplus.css', 'administrator/components/com_articleplus/' );
		JToolBarHelper::title(JText::_('COM_ARTICLEPLUS_CONTROL_PANEL'));
		require_once(JPATH_COMPONENT_ADMINISTRATOR."/controlpanel.php");
	}
	
	# Αποθήκευση ρυθμίσεων
	function saveconfig() {
		$config=new configuration();
		$config->setAll();
		$window=JFactory::getApplication();
		$window->redirect("index.php?option=com_articleplus&action=prodkeys&task=showconfig", JText::_("CONFIGURATION_SAVED"));
	}
	
	# επιστροφή στο προηγούμενο παράθυρο
	function back() {
		$this->main();
	}
}

# Κλάση που προσφέρει μεθόδους για την ανάγνωση των λέξεων-κλειδιών
class key_words extends JTable {
	var $id;
	var $keyword;

	# Κατασκευαστής
	# Σύνδεση με τη βάση δεδομένων
	function key_words() {
		$database	=& JFactory::getDBO();
	   	$this->__construct( '#__articleplus_blocked', 'id', $database );
	}
		
	# Διαγραφή λέξης-κλειδιού
	function remove($word) {
		$q="select `id` from `$this->_tbl` where `keyword`='$word' limit 1; ";
		$this->_db->setQuery($q);
		$id=$this->_db->loadResult();
		$this->delete($id);
	}
	
	# Αποθήκευση λέξεων-κλειδιών
	function saveKeywords() {
		#Διαβάζουμε μπλοκαρισμένες λέξεις
		$s=JRequest::getVar("ignoredWords");
		# χρήση του κόμα σαν δαιχωριστικού
		$a=explode(",", $s);
		# διαγραφή διπλοεγγραφών
		$a=array_unique($a); 
		foreach ($a as $key=>$value) {
			$this->id=null;
			$this->keyword=trim($value);
			$this->store();
		}
	}
	
	# παίρνει τη λίστα των λέξεων-κλειδιών από τη βάση
	function getlist() {
		# Ερώτημα επιλογής λέξεων κλειδιών
		$q="select `keyword` from `$this->_tbl` order by `keyword` asc ";
		$this->_db->setQuery($q);
		# παίρνουμε αποτελέσματα
		$lst=$this->_db->loadResultArray();
		return $lst;
	}	

}


# Κλάση με μεθόδους για τις κατηγορίες των άρθρων
class categories extends JTable {
	var $id;
	var $title;
	
	# Κατασκευαστής
	function categories() {
		$db	=& JFactory::getDBO();
	   	$this->__construct( '#__categories', 'id', $db );
	}
	
	# Μέθοδος που παίρνει τη λίστα των κατηγοριών
	function getlist() {
		$q="SELECT DISTINCT #__categories.id, #__categories.title, #__content.catid FROM #__categories INNER JOIN #__content ON #__categories.id = #__content.catid ";
		$this->_db->setQuery($q);
		$list=$this->_db->loadObjectList();
		return $list;
	}	
	
}

# κλάση για το περιεχόμενο του Joomla
class acontent extends JTable {
	# πεδία που κρατάει το Joomla για κάθε περιεχόμενο 
	var $id, $asset_id, $title, $alias, $title_alias; 
	var $introtext, $fulltext, $state, $sectionid, $mask; 
	var $catid, $created, $created_by, $created_by_alias; 
	var $modified, $modified_by, $checked_out, $checked_out_time; 
	var $publish_up, $publish_down, $images, $urls, $attribs; 
	var $version, $parentid, $ordering, $metakey, $metadesc; 
	var $access, $hits, $metadata, $featured, $xreference;
	
	#Κατασκευαστής
	function acontent() {
		$db	=& JFactory::getDBO();
	   	$this->__construct( '#__content', 'id', $db );
	}
	
	# Λίστα με το περιεχόμενο
	function getlist() {
		$catid=JRequest::getVar("catid");
		$q="select * from `$this->_tbl` ";
		if ($catid) {
			$q .= " where `catid`='$catid' ";	
			$q .= " and `state` >=0 ";
		} else  $q .= " where `state` >=0 ";
		
		$q .= " order by `publish_up` DESC ";
		$this->_db->setQuery($q);
		$list=$this->_db->loadObjectList();
		return $list;
	}
	
	# Αποθήκευση λέξεων κλειδιών στο πεδίο metakey
	function saveKeywords() {
		$this->bind($_REQUEST);
		$s=JRequest::getVar("metakey");
		$a=explode(",", $s);
		$a=array_unique($a); // remove any duplicates
		arsort($a);
		$this->metakey=implode(",", $a);
		$this->store();
	}	
}

class autokeyword {
	var $contents, $encoding, $keywords, $wordLengthMin, $wordOccuredMin;
	var $minWordPhraseLength, $phraseMinFreq, $maxPhraseLength;
	
	// Κατασκευαστής
	function autokeyword($data, $encoding="UTF-8"){
		// Αντικείμενο που περιέχει τις ρυθμίσεις
		$config=new configuration();
		$this->encoding = $encoding;
		mb_internal_encoding($encoding);
		$this->contents = $this->replace_chars($data);

		# Ελάχιστο μήκος και πλήθος για μία λέξη-κλειδί
		$this->wordLengthMin = $config->get("min_word_length");
		$this->wordOccuredMin = $config->get("min_word_freq");
		$this->maxPhraseLength=$config->get("phrases_length");
		$this->minWordPhraseLength = $config->get("min_words_length_phrases");
		$this->phraseMinFreq = $config->get("min_phrase_freq");
	}

	
	# Απαλοιφή σημείων στίξης
	function replace_chars($content) {
		$content = mb_strtolower($content);
		$content = strip_tags($content);
		$punctuations = array(',', ')', '(', '.', "'", '"',
		'<', '>', '!', '?', '/', '-',
		'_', '[', ']', ':', '+', '=', '#',
		'$', '&quot;', '&copy;', '&gt;', '&lt;', 
		'&nbsp;', '&trade;', '&reg;', ';', 
		chr(10), chr(13), chr(9));
		$content = str_replace($punctuations, " ", $content);
		$content = preg_replace('/ {2,}/si', " ", $content);
		return $content;
	}

	//Ανάλυση κειμένου για την εύρεση λέξεων κλειδιών
	function parse_words(){
		# παίρνουμε τη λίστα των λέξεων κλειδιών
		$c=new key_words();
		$common=$c->getlist();
		$s = explode(" ", $this->contents); 
		$k = array();
		//διαπέραση πίνακα
		foreach( $s as $key=>$value ) {
			//διαγραφή μικρών λέξεων
			if(mb_strlen(trim($value)) >= $this->wordLengthMin  && !in_array(trim($value), $common)  && !is_numeric(trim($value))) {
				$k[] = trim($value);
			}
		}
		# μέτρηση λέξεων
		$k = array_count_values($k);
		# ταξινόμηση λέξεων
		$occur_filtered = $this->filter_keywords($k, $this->wordOccuredMin);
		arsort($occur_filtered);
		return $occur_filtered;
	}

	function parse_multiplewords($n){
		$x = explode(" ", $this->contents);

		for ($i=0; $i < count($x)-$n+1; $i++) {
			$ok=1;
			for ($j=0; $j < $n; $j++){
				if(mb_strlen(trim($x[$i+$j])) < $this->minWordPhraseLength)
					$ok=0;
			}
			
			if($ok){
				$y[$i]="";
				for ($j=0; $j < $n; $j++){

					$y[$i]=$y[$i]." ".trim($x[$i+$j]);	
				}
			}
		}
		$y = array_count_values($y);
		$occur_filtered = $this->filter_keywords($y, $this->phraseMinFreq);
		arsort($occur_filtered);
		return $occur_filtered;
	}

	# αγνόηση λέξεων που εμφανίστηκαν λίγες φορές
	function filter_keywords($array_count_values, $min) {
		# πίνακας συχνοτήτων
		$freq = array();
		foreach ($array_count_values as $word => $i) {
			if ($i >= $min) {
				$freq[$word] = $i;
			}
		}
		return $freq;
	}
}

class config_key extends JTable {
    var $id,$keyword,$description,$setting;
    var $type,$pagename;
     
    function config_key() {
		$db	=& JFactory::getDBO();
	   	$this->__construct( '#__articleplus_params', 'id', $db );
    }
}

# Κλάση με τις ρυθμίσεις 
class configuration{
	// Κατασκευαστής
	function configuration() {			
	}
	
	function get($word) {
		$db	=& JFactory::getDBO();
		$q="select setting from #__articleplus_params where keyword='$word'";
		$db->setQuery($q);
		return trim($db->loadResult());
	}

	function getAll() {
		$db	=& JFactory::getDBO();
		$q="select * from #__articleplus_params order by pagename";
		$db->setQuery($q);
		return $db->loadObjectList();
	}
    
    function saveconfig(){
        $this->setAll();
    }

	function setAll() {
		$db	=& JFactory::getDBO();
		$req=array();
		$req=$_REQUEST;
		foreach ($req as $key=>$value) {
			if (substr($key, 0, 3)=="edt") {
				$cfg=new config_key();
				$setting=substr($key,3,32);
				$q="UPDATE #__articleplus_params SET `setting`='$value' WHERE keyword='$setting' LIMIT 1;";
				$db->setQuery($q);
				$r=$db->query();
			}
		}
	}
	
	function view() {
		$cfg=$this->getAll();
		?>
		<form method="post" name="adminForm" action="index.php">
		<?php
			$currentpage='';
			$i=0;
			foreach ($cfg as $conf) {
				if ($currentpage<>$conf->pagename) {
					if ($currentpage) {
						echo "</tbody></table></fieldset>\n";
					}
					echo "<fieldset class='adminform'>";
					$currentpage=$conf->pagename;
					echo "<legend>".JText::_($currentpage)."</legend>";
					echo "\n<table class='admintable' cellspacing='1'><tbody>";
					$i++;
				}

				echo "\n<tr><td class='configkey'>".JText::_($conf->description)."</td>";
				switch ($conf->type) {
				case "text": 	echo "<td><input type=\"text\" name=\"edt$conf->keyword\" value=\"$conf->setting\" size=\"$conf->sh\">";
							echo "</td></tr>\n";
							break;
				case "textarea": echo "<td><textarea name=\"edt$conf->keyword\" cols=\"$conf->sh\" rows=\"$conf->sv\">$conf->setting</textarea>";
							echo "</td></tr>\n";
							break;
				case "richtext": echo "<td>";
				 			editorArea( 'editor1', $conf->setting, "edt$conf->keyword", '100%', '350', '75', '20' ) ;
				 			echo "</td></tr>\n";
							break;
				case "yesno": 	echo "<td>";
							echo "<input type='radio' name='edt$conf->keyword' ".($conf->setting==0?" checked='checked'":"")." value='0' />".JText::_('No');
							echo "<input type='radio' name='edt$conf->keyword' ".($conf->setting==1?" checked='checked'":"")." value='1' />".JText::_('Yes');
							echo "</td></tr>\n";
							break;
				case "list": 	echo "<td>";
							echo "<select name='edt$conf->keyword'>";
							$txtoptlist=trim('');
							$pairoptlist=explode("\r\n",$txtoptlist);
							foreach ($pairoptlist as $k=>$value) {
								$aline=explode(":", trim($value));
								echo "<option value='".$aline[1]."'".($conf->setting==$aline[1]?" selected":"").">".$aline[0]."</option>\n";
							}
							echo "</select>";
							echo "</td></tr>\n";
							break;
				}
				echo "\n";
			}
		?>
		</td></tr>
		</table>
		<input type="hidden" name="option" value="com_articleplus" />
		<input type="hidden" name="action" value="prodkeys" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0" />
		</form>
	<?php
	}
	
}