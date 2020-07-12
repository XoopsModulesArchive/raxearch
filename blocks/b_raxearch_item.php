<?php
if (!function_exists('b_raxearch_item')) {
function b_raxearch_item ($options) {
	$block = array();
	$moduleDirName = basename(dirname(dirname(__FILE__)));
	$block['url'] = XOOPS_URL.'/modules/'.$moduleDirName.'/index.php';
	$block['keyword'] = (isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '');
	return $block;
}
}
?>