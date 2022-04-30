<?
use \Bitrix\Main\Localization\Loc;

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once(dirname(__FILE__) . "/../prolog.php");


Loc::loadMessages(__FILE__);
IncludeModuleLangFile(__FILE__);

$APPLICATION->SetTitle("Заголовок настройки");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
?>

Содержимое страницы

<?require($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_admin.php");?>