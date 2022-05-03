<?

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Page\Asset;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once(dirname(__FILE__) . "/prolog.php");

Loc::loadMessages(__FILE__);
IncludeModuleLangFile(__FILE__);

$APPLICATION->SetTitle("Настройки K30_BOGDO");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
?>


<?
$aTabs = array(
	array("DIV" => "edit1", "TAB" => "Пользовательские настройки", "ICON" => "", "TITLE" => "Пользовательские настройки"),
	array("DIV" => "editEnd", "TAB" => "Прочие настройки", "ICON" => "", "TITLE" => "Прочие настройки") // Последняя вкладка настроек, седержит настройки без вкладок
);

$tabControl = new CAdminTabControl("tabControl", $aTabs);
$tabControl->Begin();
?>

<form method="post" action="<? echo $APPLICATION->GetCurPage() ?>?&lang=<?= LANGUAGE_ID ?>" enctype="multipart/form-data">
	<?= bitrix_sessid_post() ?>
	<? $tabControl->BeginNextTab(); ?>

	<? K30\Bogdo\ModuleOptions::ShowInstructionProperty() ?>
	<? K30\Bogdo\ModuleOptions::ShowButtonNewProperty() ?>

	<!-- Вкладки начало -->

	<h2>Управление вкладками:</h2>
	<tr>
		<td>
			<table class="gcustomsettings-settings-tab-headers" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>Название вкладки</td>
						<td>Сорт.</td>
						<td>Список настроек</td>
						<td></td>
					</tr>
				</thead>
				<tbody class="js-tabs">
					<tr>
						<td>
							<input type="text" size="60" name="TABS[]" value="">
						</td>
						<td>
							<input type="text" size="6" name="TABS[1][SORT]" value="100">
						</td>
						<td>
							<a href="javascript:void(0)">Изменить список</a>
						</td>
						<td>
							<a class="redLink" href="javascript:void(0)" >Удалить вкладку</a>
						</td>
					</tr>
				</tbody>
			</table>
			<div style="padding-top: 10px;">
				<a href="javascript:void(0)"  onclick="addNewTabs(this);">Допавить вкладку</a>
			</div>
		</td>
	</tr>
	<!-- Конец вкладки -->
	<? $tabControl->BeginNextTab(); ?>
	<h2>прочие настройки - содержание</h2>

	<? $tabControl->Buttons(); ?>
	<input type="submit" name="Update" value="<?= GetMessage("MAIN_SAVE") ?>" title="<?= GetMessage("MAIN_OPT_SAVE_TITLE") ?>">
	<? $tabControl->End(); ?>

</form>
<?
\K30\Bogdo\ModuleOptions::ShowCSS();
\K30\Bogdo\ModuleOptions::ShowJS();
?>
<? require($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/include/epilog_admin.php"); ?>