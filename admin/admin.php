<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - MyStartup	 	                    				 //
//                       <http://www.TyphonSolutions.ca/>                    //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Benoit Duchaine                                          		 //
// URL: http://www.TyphonSolutions.ca										 //
// Project: TS-MyStartup	                                                 //
// ------------------------------------------------------------------------- //


include '../../../include/cp_header.php';
include XOOPS_ROOT_PATH."/class/xoopsformloader.php";

include_once(XOOPS_ROOT_PATH."/header.php");

// Handlers
$myhandler = xoops_getmodulehandler('startuppage');
$group_handler = xoops_gethandler('group');
$module_handler = xoops_gethandler('module');

xoops_cp_header();


	// Handle the posts
	if (isset($_POST['btnAdd'])) {
		// Adding a new startup page for a group
		$module_id = intval($_POST['module_selected']);
		$group_sel = intval($_POST['group_selected']);
		$order = intval($_POST['order']);
		if (!is_numeric($order) || $order < 0) $order = 0;
		$msg = _STARTUP_SUCCESS_SAVE;
		
		// Validate
		if ($module_handler->get($module_id)) {
			foreach ($group_sel as $grp) {
				if ($group_handler->get($grp)) {
					$newitem = $myhandler->create();
					$newitem->setVar('group_id', $grp);
					$newitem->setVar('module_id', $module_id);
					$newitem->setVar('start_order', $order);
					if (!$myhandler->insert($newitem, true)) {
						$msg = _STARTUP_ERROR_FAILURE_SAVE;
					}
				}
			}
		}
		redirect_header("admin.php",1,$msg);
	}
	
	if (isset($_REQUEST['op'])) {
		// Delete a startup page for a group
		$msg = _STARTUP_SUCCESS_SAVE;
		if ($_REQUEST['op'] == 'delete') {
			$criteria = new CriteriaCompo();
			$criteria->add( new Criteria('group_id', intval($_REQUEST['gid'] )));
			$criteria->add( new Criteria('module_id', intval($_REQUEST['mid'] )));
			if (!$moduleList = $myhandler->DeleteAll($criteria)) {
				$msg = _STARTUP_ERROR_FAILURE_DELETE;
			}
		}
		redirect_header("admin.php",1,$msg);
	}

	if (isset($_POST['btnUpdate'])) {
		$count=1;
		while($count<1000){
			$gidname="gid".$count;
			$midname="mid".$count;
			$ordername="order".$count;
			if (isset($_POST[$gidname])){
				$db=Database::getInstance();
				$sql="UPDATE ".$db->prefix("startup_page")." SET start_order='".intval($_REQUEST[$ordername])."' WHERE group_id=".intval($_POST[$gidname])." AND module_id=".intval($_POST[$midname]);
				$db->query($sql);
				$msg = _STARTUP_SUCCESS_SAVE;
			} else {
				break;
			}
			$count++;
		}
		redirect_header("admin.php",1,$msg);
	}
	// Show the add form
	echo _STARTUP_FORM_DESCRIPTION;
	$myForm = new XoopsThemeForm(_STARTUP_MI_CAT_STARTUP_NAME, 'frmStartupPage', '');
	$myForm->addElement(new XoopsFormSelectGroup(_STARTUP_FORM_GROUP_SELECT, 'group_selected', true, null, 5,true));
	
	$moduleSelect = new XoopsFormSelect(_STARTUP_FORM_MODULE_SELECT, 'module_selected', false);
	$moduleList =& $module_handler->getList(new Criteria('hasmain', 1));
	$moduleSelect->addOptionArray($moduleList);
	$myForm->addElement($moduleSelect);
	$myForm->addElement(new XoopsFormText(_STARTUP_FORM_ORDER, 'order', 4, 4, '0'));
	$myForm->addElement(new XoopsFormButton('', 'btnAdd', _STARTUP_ADD, 'submit'));
	
	$myForm->display();


echo '<table cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>'._STARTUP_FORM_GROUP_NAME.'</th>
			<th>'._STARTUP_FORM_MODULE_NAME.'</th>
			<th>'._STARTUP_FORM_ORDER.'</th>
			<th>'._STARTUP_FORM_ACTION.'</th>
		</tr>
	</thead>
	<tbody>';
	
	$criteria = new CriteriaCompo();
	$criteria->setSort('group_id, start_order, module_id');
	$pageList = $myhandler->getObjects($criteria);
	$rowcount=1;

echo "<form action='admin.php' method='post' name='startorder' id='startorder'>";
	foreach ($pageList as $grouppage) {
	    if ($rowcount % 2 != 0) {
            $class = 'odd';
        } else {
            $class = 'even';
        }
		$grp = $group_handler->get($grouppage->getVar('group_id'));
		$mod = $module_handler->get($grouppage->getVar('module_id'));
		if ($mod && $grp) {
			$action = '<input type="button" name="btnDelete" value="'._STARTUP_DELETE.'" onclick="location=\'?op=delete&gid='.intval($grouppage->getVar('group_id')).'&mid='.intval($grouppage->getVar('module_id')).'\'" />';
			echo "<input type=hidden name=gid".$rowcount." value=".intval($grouppage->getVar('group_id')).">";
			echo "<input type=hidden name=mid".$rowcount." value=".intval($grouppage->getVar('module_id')).">";


	echo 	'<tr align="center" class="'.$class.'">
			<td>'.$grp->getVar("name").'</td>
			<td>'.$mod->getVar("name").'</td>
			<td><input name="order'.$rowcount.'" type="text" value="'.$grouppage->getVar("start_order").'" maxlength="3" size="2"</td>
			<td>'.$action.'</td>
		</tr>';

		}
		else {
			// Module or group has been deleted... get rid of this mapping
			$criteria = new CriteriaCompo();
			$criteria->add( new Criteria('group_id', $grp));
			$criteria->add( new Criteria('module_id', $mod));
			if (!$moduleList = $myhandler->DeleteAll($criteria)) {
				$msg = _STARTUP_ERROR_FAILURE_DELETE;
			}
		}
		$rowcount++;
	}

echo '	</tbody>
		<tr>
		<td colspan=4>&nbsp;</td>
		</tr>
			<tr>
			<td colspan=4 align="center"><input type="submit" name="btnUpdate" value="'._STARTUP_ORDER_UPDATE.'"></td>
		</tr>
			</form>
</table>';
	
xoops_cp_footer();
?>