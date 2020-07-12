<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

function raxearch_item_search ($keyword = '', $page = '1', $sort = '', $maxPrice = '', $minPrice = '', $shopCode = '', $genreId = '') {
	global $raxearchModuleConfig, $xoopsDB;

	//	Initilize
	$sortList = array('+affiliateRate', '-affiliateRate', '+reviewCount', '-reviewCount',
	                  '+itemPrice', '-itemPrice', '+updateTimestamp', '-updateTimestamp', 'random');
	$carrier = '0';
	$nowTimeUTS = time();

	//	Call fetcher
	$parameters = array();
	$parameters['version']		= '2008-09-01';
	$parameters['developerId']	= $raxearchModuleConfig['developerId'];
	$parameters['affiliateId']	= $raxearchModuleConfig['affiliateId'];
	$parameters['hits']		= $raxearchModuleConfig['hits'];
	$parameters['operation']	= 'ItemSearch';
	if (_CHARSET == 'UTF-8') {
		$parameters['keyword']		= urlencode($keyword);
	} else {
		$parameters['keyword']		= urlencode(mb_convert_encoding($keyword, 'UTF-8', _CHARSET));
	}
	$parameters['carrier']		= $carrier;
	$parameters['availability']	= '1';
	//	$parameters['minPrice']		= '1';
	//	$parameters['field']		= '1';
	if ($page > 0) {
		$parameters['page']	= $page;
	}
	if (($sort != '') && in_array($sort, $sortList)) {
		$parameters['sort']	= urlencode($sort);
	} else {
		$parameters['sort']	= urlencode(_RAXEARCH_DEFAULT_SORT);
	}
	if ($shopCode != '') {
		$parameters['shopCode']	= $shopCode;
	}
	if ($genreId != '') {
		$parameters['genreId']	= $genreId;
	}
	if (($maxPrice != '') && (intval($maxPrice) > 0)) {
		$parameters['maxPrice']	= $maxPrice;
	}
	if (($minPrice != '') && (intval($minPrice) > 0)) {
		$parameters['minPrice']	= $minPrice;
	}

	$responseXML = raxearch_fetcher($parameters);

	$itemXMLParser = new raxearch_xml_parser;
	$itemData = $itemXMLParser->parseXML($responseXML);

	$itemData = raxearch_array_mb_convert_encoding($itemData, _CHARSET, 'UTF-8');
	
	return $itemData;
}

function raxearch_hotels_search ($keyword = '', $page = '1') {
	global $raxearchModuleConfig, $xoopsDB;

	$carrier = '0';
	$nowTimeUTS = time();

	$parameters = array();
	$parameters['version']		= '2008-11-13';
	$parameters['developerId']	= $raxearchModuleConfig['developerId'];
	$parameters['affiliateId']	= $raxearchModuleConfig['affiliateId'];
	$parameters['hits']		= $raxearchModuleConfig['hits'];
	$parameters['operation']	= 'KeywordHotelSearch';
	if (_CHARSET == 'UTF-8') {
		$parameters['keyword']		= urlencode($keyword);
	} else {
		$parameters['keyword']		= urlencode(mb_convert_encoding($keyword, 'UTF-8', _CHARSET));
	}
	$parameters['carrier']		= $carrier;
	$parameters['sumDisplayFlag']	= '1';
	if ($page > 0) {
		$parameters['page']	= $page;
	}

	$responseXML = raxearch_fetcher($parameters);

	$itemXMLParser = new raxearch_xml_parser;
	$itemData = $itemXMLParser->parseXML($responseXML);

	$itemData = raxearch_array_mb_convert_encoding($itemData, _CHARSET, 'UTF-8');
	
	return $itemData;
}

function raxearch_hotels_info ($hotelNo = '') {
	global $raxearchModuleConfig, $xoopsDB;

	//	Initilize
	$carrier = '0';
	$nowTimeUTS = time();

	//	Call fetcher
	$parameters = array();
	$parameters['version']		= '2008-11-13';
	$parameters['developerId']	= $raxearchModuleConfig['developerId'];
	$parameters['affiliateId']	= $raxearchModuleConfig['affiliateId'];
	$parameters['operation']	= 'SimpleHotelSearch';
	$parameters['hotelNo']		= urlencode(mb_convert_encoding($hotelNo, 'UTF-8', _CHARSET));
	$parameters['carrier']		= $carrier;

	$responseXML = raxearch_fetcher($parameters);

	//	Parse XML
	$itemXMLParser = new raxearch_xml_parser;
	$itemData = $itemXMLParser->parseXML($responseXML);

	$itemData = raxearch_array_mb_convert_encoding ($itemData, _CHARSET, 'UTF-8');

	return $itemData;
}

function raxearch_fetcher ($parameters, $requestURL = _RAXEARCH_API_URL, $requestPort = _RAXEARCH_API_PORT) {

	//	API URL
	if (preg_match('!^(http://)([^/]+)(.+)$!', $requestURL, $m)) {
		$apiServer = $m[2];
		$apiPath = $m[3];
	} else {
		exit();
	}

	//	Paraqmeters to Query
	$queryString = '';
	$delimeter = '';
	if (is_array($parameters)) {
		foreach ($parameters as $key => $val) {
			$queryString .= $delimeter.trim($key).'='.trim($val);
			$delimeter = '&';
		}
	} else {
		exit();
	}

	//	Puts request
	if (_RAXEARCH_PROXY_SERVER != '') {
		$fp = @fsockopen(_RAXEARCH_PROXY_SERVER, _RAXEARCH_PROXY_PORT, $errorNumber, $errorString, 5);
		$RequestURI = "http://$apiServer:$requestPort$apiPath?$queryString";
	} else {
		$fp = @fsockopen($apiServer, _RAXEARCH_API_PORT, $errorNumber, $errorString, _RAXEARCH_TIME_OUT);
		$RequestURI = "$apiPath?$queryString";
	}
	if (!$fp) {
		exit();
	}
	$requestHeader =	"GET $RequestURI HTTP/1.0\r\n".
				"User-Agent: raxearch/PHP".phpversion()."\r\n".
				"Host: $apiServer\r\n\r\n";
	fputs($fp, $requestHeader);

	//	Get Result
	$responseBuffer = '';
	while (!feof($fp)) { $responseBuffer .= fgets($fp, 1024); }
	fclose($fp);
	//	
	$responseBuffer = str_replace("\r\n", "\n", $responseBuffer);
	list($responseHeader, $responseBody) = explode("\n\n", $responseBuffer, 2);
	preg_match('/^([\S]+) ([\d]{3}) ([^\n]*)/', $responseHeader, $matches);
	if (($matches[2] != 200) && ($matches[3] != 'OK')) {
		exit();
	}
	//	
	return $responseBody;
}

class raxearch_xml_parser {
	var $xmlParser, $xmlSource;
	var $resultArray, $tagFlag, $xmlData, $itemsCount;

	function raxearch_xml_parser () {
		$this->resultArray = array();
		$this->tagFlag = array(	'Header' => false, 'Body' => false,
					'Items' => false, 'Item' => false,
					'keywordHotelSearch' => false, 'hotelSimple' => false,
					'hotel' => false);
		$this->xmlData = '';
		$this->itemsCount = 0;
	}

	function parseXML ($source) {
		$this->xmlSource = $source;
		$this->xmlParser = xml_parser_create("UTF-8");
		xml_parser_set_option($this->xmlParser, XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->xmlParser, $this);
		xml_set_element_handler($this->xmlParser, "startElement", "endElement");
		xml_set_character_data_handler($this->xmlParser, "characters");
		if (!xml_parse($this->xmlParser, $this->xmlSource)) {
			exit();
		}
		xml_parser_free($this->xmlParser);
		return $this->resultArray;
	}

	function characters ($parser, $text) {
		$this->xmlData .= $text;
	}

	function startElement ($parser, $name, $attrib) {
		$this->xmlData = '';
		$this->tagFlag[$name] = true;
	}

	function endElement ($parser, $name) {
		if (($this->tagFlag['Item']) || ($this->tagFlag['hotelSimple'])|| ($this->tagFlag['hotel'])) {
			$this->resultArray['Item'][$this->itemsCount][$name] = $this->xmlData;
		} else {
			$this->resultArray[$name] = $this->xmlData;
		}
		$this->tagFlag[$name] = false;
		$this->xmlData = '';
		if (($name == 'Item') || ($name == 'hotelSimple') || ($name == 'hotel')) {
			$this->itemsCount++;
		}
	}
}

function raxearch_array_mb_convert_encoding ($d, $to = _CHARSET, $from = 'UTF-8') {
	if ($to == $from) { return $d; }
	if (is_array($d)) {
		foreach ($d as $key => $val) {
			$d[$key] = raxearch_array_mb_convert_encoding($val, $to, $from);
		}
		return $d;
	} else {
		return (mb_convert_encoding($d, $to, $from));
	}
}

function raxearch_highlight_text ($str = '', $keywords = '') {

	foreach (explode(' ', $keywords) as $keyword) {
		if (!preg_match('/(<|>|&)/', $keyword)) {
			$str = str_replace($keyword, '<span style="'._RAXEARCH_HIGHLIGHT_STYLE.'">'.$keyword.'</span>', $str);
		}
	}

	return $str;
}
?>