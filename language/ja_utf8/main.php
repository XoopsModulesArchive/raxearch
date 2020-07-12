<?php
define ("_MD_RAXEARCH_TITLE",		"楽天市場 検索");
define ("_MD_RAXEARCH_I_TITLE",		"楽天市場商品検索");
define ("_MD_RAXEARCH_H_TITLE",		"楽天トラベル検索");

define ("_MD_RAXEARCH_KEYWORD",	"検索ワード");
define ("_MD_RAXEARCH_SUBMIT",	"検索");
define ("_MD_RAXEARCH_I_SUBMIT","楽天市場商品検索");
define ("_MD_RAXEARCH_H_SUBMIT","楽天トラベル検索");
define ("_MD_RAXEARCH_RESULT",	"検索結果");
define ("_MD_RAXEARCH_PRICE_RANGE",	"価格帯");

define ("_MD_RAXEARCH_PRICE_DSC",	"価格の高い順");
define ("_MD_RAXEARCH_PRICE_ASC",	"価格の安い順");
define ("_MD_RAXEARCH_TIME_DSC",	"新着順");
define ("_MD_RAXEARCH_REV_CNT_DSC",	"感想の件数順");

define ("_MD_RAXEARCH_NEXT_PAGE",	"次のページ");
define ("_MD_RAXEARCH_PREV_PAGE",	"前のページ");
define ("_MD_RAXEARCH_HITS_TOTAL",	"全ヒット数");
define ("_MD_RAXEARCH_WITHIN",	"件中");

define ("_MD_RAXEARCH_INC_TAX",	"（税込）");
define ("_MD_RAXEARCH_EXC_TAX",	"（税抜）");
define ("_MD_RAXEARCH_INC_POSTAGE",	"（送料無料）");
define ("_MD_RAXEARCH_CARD_AVL",	"カード利用可");
define ("_MD_RAXEARCH_TIME_SALE",	"タイムセール");
define ("_MD_RAXEARCH_SHOP_OF_YEAR",	"ショップオブザイヤー受賞店舗");
define ("_MD_RAXEARCH_PARKING",		"駐車場");
define ("_MD_RAXEARCH_STATION",		"最寄り駅");

define ("_MD_RAXEARCH_COLON",		"：");
define ("_MD_RAXEARCH_SPACE",		"　");
define ("_MD_RAXEARCH_WAVE_DASH",	"～");
define ("_MD_RAXEARCH_YEN",		"円");
define ("_MD_RAXEARCH_VERTICAL",	"｜");
define ("_MD_RAXEARCH_LEFT_SQUARE",	"［");
define ("_MD_RAXEARCH_RIGHT_SQUARE",	"］");

define ("_MD_RAXEARCH_PLS_INPUT",	"検索ワードを入力してください。");
define ("_MD_RAXEARCH_NO_HITS",	"検索結果がありません。");

define ("_MD_RAXEARCH_NOTICE",	'
<!-- Rakuten Web Services Attribution Snippet FROM HERE -->
<a href="http://webservice.rakuten.co.jp/" target="_blank">Supported by 楽天ウェブサービス</a>
<!-- Rakuten Web Services Attribution Snippet TO HERE -->
<br />
購入にあたっては、楽天市場及びショップのサイト内容を必ず御確認下さい。
');


function raxearch_item_name_convert ($str = '', $keyword = '') {

	$str = htmlspecialchars($str);

	$strBackUp = $str;
	$str = mb_ereg_replace("(【.+?】)", "", $str);
	if ($str == '') { $str = $strBackUp; }
	$str = mb_ereg_replace("([！？』》】])", "\\1 ", $str);

	return $str;
}

function raxearch_text_convert ($str = '') {

	$str = htmlspecialchars($str);

	$str = mb_ereg_replace("([。！？』》】])", "\\1<br />", $str);
	$str = mb_ereg_replace("<br />([。！？』》】）／\)])", "\\1", $str);

	$str = mb_ereg_replace("([【●★◆※＊　])", "<br />\\1", $str);
	$str = mb_ereg_replace("([【●★◆※＊　])<br />", "\\1", $str);

	return $str;
}

function raxearch_shop_name_convert ($str = '', $keyword = '') {

	$str = htmlspecialchars($str);

	$str = mb_ereg_replace("([。！？』》】])", "\\1<br />", $str);
	$str = mb_ereg_replace("([【（\(\[「])", "<br />\\1", $str);
	$str = mb_ereg_replace("([　])", "<br />", $str);
	$str = str_replace("<br /><br />", "<br />", $str);
	$str = mb_ereg_replace("^<br />", "", $str);

	return $str;
}

?>