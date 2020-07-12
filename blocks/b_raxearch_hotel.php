<?php
if (!function_exists('b_raxearch_hotel')) {
function b_raxearch_hotel ($options) {
	$block = array();
	$moduleDirName = basename(dirname(dirname(__FILE__)));
	$block['url'] = XOOPS_URL.'/modules/'.$moduleDirName.'/index.php';
	$block['keyword'] = (isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '');
	return $block;
}
}
?>