<?php
//  ------------------------------------------------------------------------ //
//            raxearch - XOOPS Module for Rakuten-Affiliaters                //
//                     Copyright (c) 2009 taquino.                           //
//                     <http://xoops.taquino.net/>                           //
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

$myDirName = basename(dirname(__FILE__));

$modversion['name'] = _MI_RAXEARCH_NAME;
$modversion['version'] = '0.91';
$modversion['description'] = _MI_RAXEARCH_DESC;
$modversion['credits'] = "http://xoops.taquino.net/";
$modversion['author'] = "taquino";
$modversion['help'] = '';
$modversion['license'] = "GPL";
$modversion['official'] = 0;
if (defined( 'XOOPS_CUBE_LEGACY')) {
	$modversion['image']		= "images/raxearch_xcl.png";
} else {
	$modversion['image']		= "images/raxearch.png";
}
$modversion['dirname'] = $myDirName;

$modversion['templates'][1]['file']		= 'raxearch_main.html';
$modversion['templates'][1]['description']	= 'RAKUTEN search form';
$modversion['templates'][2]['file']		= 'raxearch_item.html';
$modversion['templates'][2]['description']	= 'RAKUTEN search item result';
$modversion['templates'][3]['file']		= 'raxearch_hotel.html';
$modversion['templates'][3]['description']	= 'RAKUTEN search hotel result';

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";

$modversion['hasMain'] = 1;

$modversion['hasSearch'] = 0;

$modversion['blocks'][1]['file']	= "b_raxearch_item.php";
$modversion['blocks'][1]['name']	= _MI_RAXEARCH_I_BLOCK_NAME;
$modversion['blocks'][1]['description']	= _MI_RAXEARCH_I_BLOCK_DESC;
$modversion['blocks'][1]['show_func']	= 'b_raxearch_item';
$modversion['blocks'][1]['template']	= 'b_raxearch_item.html';
$modversion['blocks'][1]['options']	= '1';

$modversion['blocks'][2]['file']	= "b_raxearch_hotel.php";
$modversion['blocks'][2]['name']	= _MI_RAXEARCH_H_BLOCK_NAME;
$modversion['blocks'][2]['description']	= _MI_RAXEARCH_H_BLOCK_DESC;
$modversion['blocks'][2]['show_func']	= 'b_raxearch_hotel';
$modversion['blocks'][2]['template']	= 'b_raxearch_hotel.html';
$modversion['blocks'][2]['options']	= '1';

$modversion['config'][1]['name']	= 'affiliateId';
$modversion['config'][1]['title']	= '_MI_RAXEARCH_CONF1_TITLE';
$modversion['config'][1]['description']	= '_MI_RAXEARCH_CONF1_DESC';
$modversion['config'][1]['formtype']	= 'text';
$modversion['config'][1]['valuetype']	= 'text';
$modversion['config'][1]['default']	= '04405178.d81ca600.04405179.c82017b9';

$modversion['config'][2]['name']	= 'developerId';
$modversion['config'][2]['title']	= '_MI_RAXEARCH_CONF2_TITLE';
$modversion['config'][2]['description']	= '_MI_RAXEARCH_CONF2_DESC';
$modversion['config'][2]['formtype']	= 'text';
$modversion['config'][2]['valuetype']	= 'text';
$modversion['config'][2]['default']	= '79c7b0f6b8a95820e9e04397cd756422';

$modversion['config'][3]['name']	= 'hits';
$modversion['config'][3]['title']	= '_MI_RAXEARCH_CONF3_TITLE';
$modversion['config'][3]['description']	= '_MI_RAXEARCH_CONF3_DESC';
$modversion['config'][3]['formtype']	= 'text';
$modversion['config'][3]['valuetype']	= 'int';
$modversion['config'][3]['default']	= '10';

$modversion['config'][4]['name']	= 'highlight';
$modversion['config'][4]['title']	= '_MI_RAXEARCH_CONF4_TITLE';
$modversion['config'][4]['description']	= '_MI_RAXEARCH_CONF4_DESC';
$modversion['config'][4]['formtype']	= 'yesno';
$modversion['config'][4]['valuetype']	= 'int';
$modversion['config'][4]['default']	= '1';
?>