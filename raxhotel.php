<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

require_once './library.php';

$xoopsTpl->assign('keyword', htmlspecialchars($keyword));
$xoopsTpl->assign('keyword_encoded', urlencode($keyword));
$xoopsTpl->assign('page', $page);

$rakutenResult = raxearch_hotels_search($keyword, $page);

$searchResult = array('hits' => 0);
foreach ($rakutenResult as $key => $val) {
	if (!is_array($val)) { $searchResult[$key] = $val; }
}

$searchResult['pageCount'] = ceil($searchResult['recordCount'] / $raxearchModuleConfig['hits']);
$searchResult['nextPage'] = (($searchResult['pageCount'] > $page) ? $page + 1 : 0);
$searchResult['prevPage'] = (($page > 1) ? $page - 1 : 0);

if (isset($searchResult['recordCount'])) {
	$searchResult['recordCountF'] = number_format(intval($searchResult['recordCount']));
}

$hotelNos = '';
$comma = '';
if (isset($rakutenResult['Item'])) {
	foreach ($rakutenResult['Item'] as $itemData) {
		$searchResult['hits']++;
		$hotelNos .= $comma . $itemData['hotelNo'];
		$comma = ',';
	}
	$hotelInfo = raxearch_hotels_info($hotelNos);
}

$searchResult['first'] = ($page - 1) * $raxearchModuleConfig['hits'] + 1;
$searchResult['last'] = $searchResult['first'] + $searchResult['hits'] - 1;

$xoopsTpl->assign('searchResult', $searchResult);

$itemsOutData = array();
if (isset($rakutenResult['Item'])) {
foreach ($rakutenResult['Item'] as $itemData) {

	$hotelNo = $itemData['hotelNo'];

	$itemOutData = array();
	$itemOutData['keyword']		= htmlspecialchars($keyword);
	$itemOutData['hotelNo']		= $itemData['hotelNo'];
	$itemOutData['hotelName']	= htmlspecialchars($itemData['hotelName']);
	$itemOutData['hotelNameF']	= raxearch_item_name_convert($itemData['hotelName']);
	if ($raxearchModuleConfig['highlight']) {
		$itemOutData['hotelNameF']	= raxearch_highlight_text($itemOutData['hotelNameF'], $keyword);
	}
	$itemOutData['areaSum']		= htmlspecialchars($itemData['areaSum']);
	$itemOutData['hotelSpecialSum']	= htmlspecialchars($itemData['hotelSpecialSum']);
	$itemOutData['hotelSpecialSumF']= raxearch_text_convert($itemData['hotelSpecialSum']);
	if ($raxearchModuleConfig['highlight']) {
		$itemOutData['hotelSpecialSumF'] = raxearch_highlight_text($itemOutData['hotelSpecialSumF'], $keyword);
	}
	$itemOutData['middleClassCode']	= $itemData['middleClassCode'];
	$itemOutData['smallClassCode']	= $itemData['smallClassCode'];
	$itemOutData['reviewAverage']	= floatval($itemData['reviewAverage']);
	$itemOutData['reviewCount']	= intval($itemData['reviewCount']);

	$itemOutData['hotelInformationUrl']	= $itemData['hotelInformationUrl'];
	$itemOutData['hotelAffiliateUrl']	= $itemData['hotelAffiliateUrl'];

	foreach ($hotelInfo['Item'] as $infoData) {
		if ($infoData['hotelNo'] === $itemOutData['hotelNo']) {
			$itemOutData['hotelKanaName']	= htmlspecialchars($infoData['hotelKanaName']);
			$itemOutData['hotelSpecial']	= htmlspecialchars($infoData['hotelSpecial']);
			$itemOutData['hotelSpecialF']	= raxearch_text_convert($infoData['hotelSpecial']);

			if ($raxearchModuleConfig['highlight']) {
				$itemOutData['hotelSpecialF']	= raxearch_highlight_text($itemOutData['hotelSpecialF'], $keyword);
			}

			$itemOutData['checkinTime']	= htmlspecialchars($infoData['checkinTime']);
			$itemOutData['checkoutTime']	= htmlspecialchars($infoData['checkoutTime']);
			$itemOutData['address1']	= htmlspecialchars($infoData['address1']);
			$itemOutData['address2']	= htmlspecialchars($infoData['address2']);
			$itemOutData['access']		= htmlspecialchars($infoData['access']);
			$itemOutData['nearestStationName'] = htmlspecialchars($infoData['nearestStationName']);
			$itemOutData['parkingInformation'] = htmlspecialchars($infoData['parkingInformation']);
			$itemOutData['hotelClassCode']	= htmlspecialchars($infoData['hotelClassCode']);
			$itemOutData['hotelImageUrl']	= $infoData['hotelImageUrl'];
			break;
		}
	}

	$itemsOutData[] = $itemOutData;
}
}

$xoopsTpl->assign('items', $itemsOutData);
?>