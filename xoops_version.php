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
$modversion['name'] = _STARTUP_MI_NAME;
$modversion['version'] = 0.4;
$modversion['description'] = _STARTUP_MI_DESC;
$modversion['author'] = "Benoit Duchaine (modified by Mazarin)";
$modversion['credits'] = "Typhon Solutions Inc. (http://www.TyphonSolutions.ca)";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/logo.gif";
$modversion['dirname'] = "startup";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/admin.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Table
$modversion['tables'][0] = "startup_page";

//install
$modversion['onInstall'] = '';

//update
$modversion['onUpdate'] = '';

// Smarty
$modversion['use_smarty'] = 1;

// Templates
$modversion['templates'][1]['file'] = 'sp_admin_list.html';
$modversion['templates'][1]['description'] = _STARTUP_MI_TEMPLATE_DESC;

// Menu
// Must be ON (1) and set to invisible on the module administration list
$modversion['hasMain'] = 1;

// User Profile
$modversion['hasProfile'] = 0;

?>