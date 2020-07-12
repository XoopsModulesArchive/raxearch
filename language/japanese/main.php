<?php
define ("_MD_RAXEARCH_TITLE",		"��ŷ�Ծ� ����");
define ("_MD_RAXEARCH_I_TITLE",		"��ŷ�Ծ쾦�ʸ���");
define ("_MD_RAXEARCH_H_TITLE",		"��ŷ�ȥ�٥븡��");

define ("_MD_RAXEARCH_KEYWORD",	"�������");
define ("_MD_RAXEARCH_SUBMIT",	"����");
define ("_MD_RAXEARCH_I_SUBMIT","��ŷ�Ծ쾦�ʸ���");
define ("_MD_RAXEARCH_H_SUBMIT","��ŷ�ȥ�٥븡��");
define ("_MD_RAXEARCH_RESULT",	"�������");
define ("_MD_RAXEARCH_PRICE_RANGE",	"������");

define ("_MD_RAXEARCH_PRICE_DSC",	"���ʤι⤤��");
define ("_MD_RAXEARCH_PRICE_ASC",	"���ʤΰ¤���");
define ("_MD_RAXEARCH_TIME_DSC",	"�����");
define ("_MD_RAXEARCH_REV_CNT_DSC",	"���ۤη����");

define ("_MD_RAXEARCH_NEXT_PAGE",	"���Υڡ���");
define ("_MD_RAXEARCH_PREV_PAGE",	"���Υڡ���");
define ("_MD_RAXEARCH_HITS_TOTAL",	"���ҥåȿ�");
define ("_MD_RAXEARCH_WITHIN",	"����");

define ("_MD_RAXEARCH_INC_TAX",	"���ǹ���");
define ("_MD_RAXEARCH_EXC_TAX",	"����ȴ��");
define ("_MD_RAXEARCH_INC_POSTAGE",	"������̵����");
define ("_MD_RAXEARCH_CARD_AVL",	"���������Ѳ�");
define ("_MD_RAXEARCH_TIME_SALE",	"�����ॻ����");
define ("_MD_RAXEARCH_SHOP_OF_YEAR",	"����åץ��֥����䡼����Ź��");
define ("_MD_RAXEARCH_PARKING",		"��־�");
define ("_MD_RAXEARCH_STATION",		"�Ǵ���");

define ("_MD_RAXEARCH_COLON",		"��");
define ("_MD_RAXEARCH_SPACE",		"��");
define ("_MD_RAXEARCH_WAVE_DASH",	"��");
define ("_MD_RAXEARCH_YEN",		"��");
define ("_MD_RAXEARCH_VERTICAL",	"��");
define ("_MD_RAXEARCH_LEFT_SQUARE",	"��");
define ("_MD_RAXEARCH_RIGHT_SQUARE",	"��");

define ("_MD_RAXEARCH_PLS_INPUT",	"������ɤ����Ϥ��Ƥ���������");
define ("_MD_RAXEARCH_NO_HITS",	"������̤�����ޤ���");

define ("_MD_RAXEARCH_NOTICE",	'
<!-- Rakuten Web Services Attribution Snippet FROM HERE -->
<a href="http://webservice.rakuten.co.jp/" target="_blank">Supported by ��ŷ�����֥����ӥ�</a>
<!-- Rakuten Web Services Attribution Snippet TO HERE -->
<br />
�����ˤ����äƤϡ���ŷ�Ծ�ڤӥ���åפΥ��������Ƥ�ɬ�����ǧ��������
');


function raxearch_item_name_convert ($str = '', $keyword = '') {

	$str = htmlspecialchars($str);

	$strBackUp = $str;
	$str = mb_ereg_replace("(��.+?��)", "", $str);
	if ($str == '') { $str = $strBackUp; }
	$str = mb_ereg_replace("([�����١ա�])", "\\1 ", $str);

	return $str;
}

function raxearch_text_convert ($str = '') {

	$str = htmlspecialchars($str);

	$str = mb_ereg_replace("([�������١ա�])", "\\1<br />", $str);
	$str = mb_ereg_replace("<br />([�������١աۡˡ�\)])", "\\1", $str);

	$str = mb_ereg_replace("([�ڡ�����������])", "<br />\\1", $str);
	$str = mb_ereg_replace("([�ڡ�����������])<br />", "\\1", $str);

	return $str;
}

function raxearch_shop_name_convert ($str = '', $keyword = '') {

	$str = htmlspecialchars($str);

	$str = mb_ereg_replace("([�������١ա�])", "\\1<br />", $str);
	$str = mb_ereg_replace("([�ڡ�\(\[��])", "<br />\\1", $str);
	$str = mb_ereg_replace("([��])", "<br />", $str);
	$str = str_replace("<br /><br />", "<br />", $str);
	$str = mb_ereg_replace("^<br />", "", $str);

	return $str;
}

?>