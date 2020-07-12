<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

require_once './library.php';

$sort = (isset($_GET['sort']) ? htmlspecialchars(trim($_GET['sort'])) : _RAXEARCH_DEFAULT_SORT);
if (($sort != '') && !preg_match('/^(\+|-).+/', $sort)) { $sort = '+'.$sort; }

$maxPrice = (isset($_GET['maxPrice']) ? intval(mb_convert_kana($_GET['maxPrice'], 'a', _CHARSET)) : '');
$minPrice = (isset($_GET['minPrice']) ? intval(mb_convert_kana($_GET['minPrice'], 'a', _CHARSET)) : '');
if (($maxPrice != 0) && ($maxPrice < $minPrice)) { $temp = $maxPrice; $maxPrice = $minPrice; $minPrice = $temp; }

$xoopsTpl->assign('keyword', htmlspecialchars($keyword));
$xoopsTpl->assign('keyword_encoded', urlencode($keyword));
$xoopsTpl->assign('sort', $sort);
$xoopsTpl->assign('page', $page);
$xoopsTpl->assign('maxPrice', (($maxPrice > 0) ? $maxPrice : ''));
$xoopsTpl->assign('minPrice', (($minPrice > 0) ? $minPrice : ''));

$rakutenResult = raxearch_item_search($keyword, $page, $sort, $maxPrice, $minPrice);

$searchResult = array();
foreach ($rakutenResult as $key => $val) {
	if (!is_array($val)) { $searchResult[$key] = $val; }
}
if (isset($searchResult['pageCount'])) {
	$searchResult['nextPage'] = (($searchResult['pageCount'] > $page) ? $page + 1 : 0);
	$searchResult['prevPage'] = (($page > 1) ? $page - 1 : 0);
}
if (isset($searchResult['count'])) {
	$searchResult['countF'] = number_format(intval($searchResult['count']));
}
$xoopsTpl->assign('searchResult', $searchResult);

$itemsOutData = array();
if (isset($rakutenResult['Item'])) {
foreach ($rakutenResult['Item'] as $itemData) {
	$itemOutData = array();
	$itemOutData['keyword']		= htmlspecialchars($keyword);
	$itemOutData['availability']	= intval($itemData['availability']);
	$itemOutData['taxFlag']		= intval($itemData['taxFlag']);
	$itemOutData['postageFlag']	= intval($itemData['postageFlag']);
	$itemOutData['creditCardFlag']	= intval($itemData['creditCardFlag']);
	$itemOutData['reviewCount']	= intval($itemData['reviewCount']);
	$itemOutData['affiliateRate']	= floatval($itemData['affiliateRate']);
	$itemOutData['reviewAverage']	= floatval($itemData['reviewAverage']);
	$itemOutData['shopCode']	= $itemData['shopCode'];
	$itemOutData['genreId']		= floatval($itemData['genreId']);
	$itemOutData['itemName']	= htmlspecialchars($itemData['itemName']);
	$itemOutData['itemNameF']	= raxearch_item_name_convert($itemData['itemName']);
	if ($raxearchModuleConfig['highlight']) {
		$itemOutData['itemNameF'] = raxearch_highlight_text($itemOutData['itemNameF'], $keyword);
	}
	$itemOutData['itemCode']	= $itemData['itemCode'];
	$itemOutData['itemPrice']	= intval($itemData['itemPrice']);
	$itemOutData['itemPriceF']	= number_format(intval($itemData['itemPrice']));
	$itemOutData['shopName']	= htmlspecialchars($itemData['shopName']);
	$itemOutData['shopNameF']	= raxearch_shop_name_convert($itemData['shopName']);
	$itemOutData['itemCaption']	= nl2br($itemData['itemCaption']);
	if (preg_match('/<br/i', $itemData['itemCaption'])) {
		$itemOutData['itemCaptionF']	= $itemData['itemCaption'];
	} else {
		$itemOutData['itemCaptionF']	= raxearch_text_convert($itemData['itemCaption']);
	}
	if ($raxearchModuleConfig['highlight']) {
		$itemOutData['itemCaptionF']	= raxearch_highlight_text($itemOutData['itemCaptionF'], $keyword);
	}
	$itemOutData['itemUrl']		= $itemData['itemUrl'];
	$itemOutData['affiliateUrl']	= $itemData['affiliateUrl'];
	$itemOutData['smallImageUrl']	= $itemData['smallImageUrl'];
	$itemOutData['mediumImageUrl']	= $itemData['mediumImageUrl'];
	$itemOutData['startTime']	= $itemData['startTime'];
	$itemOutData['endTime']		= $itemData['endTime'];
	$itemOutData['shopUrl']		= $itemData['shopUrl'];
	$itemOutData['shopAffiliateUrl']= 'http://hb.afl.rakuten.co.jp/hgc/'.$raxearchModuleConfig['affiliateId'].'/?pc='.urlencode($itemData['shopUrl']);
	$itemOutData['shopOfTheYearFlag']= $itemData['shopOfTheYearFlag'];
	$itemsOutData[] = $itemOutData;
}
}
$xoopsTpl->assign('items', $itemsOutData);

?>