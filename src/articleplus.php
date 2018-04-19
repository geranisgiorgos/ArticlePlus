	<?php
/**
 * @package		Article Plus
 */

defined('_JEXEC') or die;

require_once(JPATH_COMPONENT_ADMINISTRATOR."/articleplus1.php");

// pairnoume tis metavlites gia to task kai to action
$task=JRequest::getVar("task");
if ($task=="") 
	$task="main";

$action=JRequest::getVar("action");
if ($action=="") 
	$action="prodkeys";

if(class_exists($action)) {
    $prodkeys=new $action();
    if(method_exists($prodkeys, $task)) {
            $prodkeys->$task();
    }
}
?>
