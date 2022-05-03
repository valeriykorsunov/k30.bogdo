<?

use \Bitrix\Main\Localization\Loc;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once(dirname(__FILE__) . "/../prolog.php");

global $USER_FIELD_MANAGER, $APPLICATION;

Loc::loadMessages(__FILE__);
IncludeModuleLangFile(__FILE__);


$RIGHT = $APPLICATION->GetGroupRight($module_id);
$RIGHT_W = ($RIGHT >= "W");
$RIGHT_R = ($RIGHT >= "R");

if (!$RIGHT_R)
{
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}


// TODO переделать request через ядро битрикса. Обновление данных
if (
	$REQUEST_METHOD == "POST"
	&& strlen($Update) > 0
	&& $RIGHT_W
	&& check_bitrix_sessid()
)
{
	$arUpdateFields = array();
	$USER_FIELD_MANAGER->EditFormAddFields("K30_BOGDO_SETTINGS", $arUpdateFields); // fill $arUpdateFields from $_POST and $_FILES

	$obSettings = new CK30BogdoSetings;
	$res = $obSettings->Update($arUpdateFields);
	if ($res)
	{
		LocalRedirect($APPLICATION->GetCurPageParam("ok=Y", array("ok")));
	}
	else
	{
		$errorText = $obSettings->LAST_ERROR;
	}
}


/******************************************************************************************************************************** */
$APPLICATION->SetTitle("Настройки сайта");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
?>

<? if (isset($_REQUEST["ok"]) && $_REQUEST["ok"] == "Y") : ?>
	<?
	CAdminMessage::ShowMessage(
		array(
			"TYPE" => "OK",
			"MESSAGE" => "Настройки успешно сохранены",
			"DETAILS" => "",
			"HTML" => true
		)
	);
	?>
<? endif ?>

<? if (strlen($errorText) > 0) : ?>
	<?
	CAdminMessage::ShowMessage(
		array(
			"TYPE" => "ERROR",
			"MESSAGE" => $errorText,
			"DETAILS" => "",
			"HTML" => true
		)
	);
	?>
<? endif ?>

<?
$aTabs = array(
	array("DIV" => "edit1", "TAB" => "Вкладка", "ICON" => "", "TITLE" => "Заголовок"),
	array("DIV" => "editEnd", "TAB" => "Прочие настройки", "ICON" => "", "TITLE" => "Прочие настройки") // Последняя вкладка настроек, седержит настройки без вкладок
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();
?>
<form method="post" action="<? echo $APPLICATION->GetCurPage() ?>?&lang=<?= LANGUAGE_ID ?>" enctype="multipart/form-data">
	<?= bitrix_sessid_post() ?>
	<? $tabControl->BeginNextTab(); ?>

	<?
	$bVarsFromForm = false;
	$arUserFields = $USER_FIELD_MANAGER->GetUserFields("K30_BOGDO_SETTINGS", 1, LANGUAGE_ID);
	?>

	<? foreach ($arUserFields as $FIELD_NAME => $arUserField) : ?>
		<? $arUserField['VALUE_ID'] = 1; ?>
		<tr>
			<td colspan="2" style="color: #CCC;"><?= $arUserField["SORT"] ?><?= $FIELD_NAME ?></td>
		</tr>
		<? echo $USER_FIELD_MANAGER->GetEditFormHTML($bVarsFromForm, $GLOBALS[$FIELD_NAME], $arUserField); ?>
	<? endforeach ?>

	<?
	// $tabControl->BeginNextTab(); 
	?>


	<? $tabControl->Buttons(); ?>
	<input type="submit" name="Update" value="<?= GetMessage("MAIN_SAVE") ?>" title="<?= GetMessage("MAIN_OPT_SAVE_TITLE") ?>">
	<? $tabControl->End(); ?>
</form>

<? require($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_admin.php"); ?>