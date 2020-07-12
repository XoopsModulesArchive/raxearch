<?php
require_once '../../mainfile.php';

define('_RAXEARCH_DEFAULT_SORT', '-updateTimestamp');
define('_RAXEARCH_TIME_OUT', 5);
define('_RAXEARCH_HIGHLIGHT_STYLE', 'color:#ff0000; font-weight:bold;');

define('_RAXEARCH_API_URL', 'http://api.rakuten.co.jp/rws/1.12/rest');
define('_RAXEARCH_API_PORT', 80);

define('_RAXEARCH_PROXY_SERVER', '');
define('_RAXEARCH_PROXY_PORT', '');

include_once XOOPS_ROOT_PATH."/header.php";
	
$myDirName = basename(dirname(__FILE__));
if (is_object($xoopsModule) && ($xoopsModule->getVar('dirname') == $myDirName)) {
	$raxearchModuleConfig = $xoopsModuleConfig;
} else {
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($myDirName);
	$config_handler =& xoops_gethandler('config');
	$raxearchModuleConfig =  $config_handler->getConfigsByCat(0, $module->getVar('mid'));
}
$xoopsTpl->assign('mydirname', $myDirName);

$keyword = '';
if (isset($_GET['keyword'])) {
	$keyword = trim($_GET['keyword']);
} else {
	foreach ($_GET as $key => $val) {
		if ($val == '') { $keyword = $key; break; }
	}
}
if ($keyword != '') {
	$keywordMbEncoding = mb_detect_encoding($keyword, _CHARSET.", auto");
	if ($keywordMbEncoding != _CHARSET) {
		$keyword = mb_convert_encoding ($keyword, _CHARSET, $keywordMbEncoding);
	}
}
$keyword = mb_ereg_replace("([,_+])", " ", $keyword);

$page = (isset($_GET['page']) ? intval($_GET['page']) : 1);
if ($page <= 0) { $page = 1; }

$op = (isset($_GET['op']) ? trim($_GET['op']) : '');
if ($op === 'item') {
	$xoopsOption['template_main'] = 'raxearch_item.html';
	require_once './raxitem.php';
} elseif ($op === 'hotel') {
	$xoopsOption['template_main'] = 'raxearch_hotel.html';
	require_once './raxhotel.php';
} else {
	$xoopsOption['template_main'] = 'raxearch_main.html';
}

include XOOPS_ROOT_PATH.'/footer.php';
?>