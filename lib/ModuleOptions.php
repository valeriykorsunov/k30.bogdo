<?

namespace K30\Bogdo;

use Bitrix\Main\Application;


class ModuleOptions
{
	static function GetPath($notDocumentRoot = false)
	{
		if ($notDocumentRoot)
			return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
		else
			return dirname(__DIR__);
	}

	public static function ShowButtonNewProperty()
	{
		global $APPLICATION;

		echo '
		<a href="/bitrix/admin/userfield_edit.php?lang=<?= LANGUAGE_ID ?>&amp;ENTITY_ID=K30_BOGDO_SETTINGS&amp;back_url=' . urlencode($APPLICATION->GetCurPageParam() . '&tabControl_active_tab=user_fields_tab') . '">Добавить настройку</a>';
	}

	public static function ShowInstructionProperty()
	{
?>
		<?= BeginNote(); ?>
		<br><strong>&lt;?echo \COption::GetOptionString( &quot;askaron.settings&quot;, &quot;UF_PHONE&quot;);?&gt;</strong>
		<br><strong>&lt;?$email = \COption::GetOptionString( &quot;askaron.settings&quot;, &quot;UF_EMAIL&quot;);?&gt;</strong>
		<br>D7:
		<br><strong>&lt;?echo \Bitrix\Main\Config\Option::get( &quot;askaron.settings&quot;, &quot;UF_PHONE&quot;);?&gt;</strong>
		<br><strong>&lt;?$email = \Bitrix\Main\Config\Option::get( &quot;askaron.settings&quot;, &quot;UF_EMAIL&quot;);?&gt;</strong>
		<?= EndNote(); ?>
	<?
	}


	public static function ShowCSS()
	{
	?>
		<style>
			table.gcustomsettings-settings-tab-headers thead td {
				background-color: rgb(224, 232, 234);
				color: rgb(75, 98, 103);
				text-align: center;
				font-weight: bold;
			}

			#optionsTab table.gcustomsettings-settings-tab-headers thead td:nth-child(1) {
				min-width: 30px;
			}

			#optionsTab table.gcustomsettings-settings-tab-headers thead td:nth-child(2) {
				min-width: 200px;
			}

			.gcustomsettings-settings-tab-headers.options-tab thead td:nth-child(1) {
				min-width: 300px;
			}

			.gcustomsettings-settings-tab-headers.options-tab thead td:nth-child(2) {
				min-width: 50px;
			}

			.gcustomsettings-settings-tab-headers.options-tab thead td:nth-child(3) {
				width: 70px;
			}

			.gcustomsettings-settings-tab-headers.options-tab thead td:nth-child(4) {
				min-width: 30px;
			}

			table.gcustomsettings-settings-tab-headers td {
				border: 1px solid rgb(208, 215, 216) !important;
				padding: 3px !important;
			}

			.redLink {
				color: red;
			}

			.tab-param {
				border: 1px solid rgb(208, 215, 216);
			}

			.tab-param div {
				padding: 10px;
			}
		</style>
	<?
	}

	public static function ShowJS()
	{
	?>
		<script>
			function editTab(elem) {
				// console.log(elem.getAttribute("data-tabname"));

				let popup = new BX.CDialog({
					'content_url': '<?= self::GetPath(true) ?>/ajax/formOptionTab.php',
					'content_post': 'tabname=' + elem.getAttribute("data-tabname") + '&ID_TAB=' + elem.getAttribute("data-tabid")
				});

				popup.Show();

				BX.addCustomEvent(popup, 'onWindowClose', function() {
					if (document.querySelector('#optionsTab input[name="save"]').value == "Y") {
						window.location.reload();
					}
				});
			}

			// function dellTab(elem){
			// 	let popup = new BX.CDialog({
			// 		'buttons': [BX.CDialog.btnSave, BX.CDialog.btnCancel],
			// 		'draggable': true,
			// 		'resizable': true,
			// 		'width':300,
          	// 		'height':100,
			// 		'content': '<form method="POST" id="form_delete">\
			// 								<input type="hidden" name="ID_TAB" value="'+elem.getAttribute("data-tabid")+'">\
			// 								<input type="hidden" name="DELETE" value="Y">\
			// 								<h1> Подтверждение удаления вкладки. <h1>\
			// 								<input type="hidden" name="sessid" value="'+BX.bitrix_sessid()+'"></form>',
			// 	});

			// 	popup.Show();
			// }
		</script>
	<?
	}

	public static function ShowJSformOptionTab()
	{
	?>
		<?
		// если мы окном рисуем с кнопками (передаем массив кнопок), то после сабмита они исчезают.
		// Решается установкой кнопок в теле (в прилетаемом контенте) диалога:
		?>
		<script type="text/javascript">
			BX.WindowManager.Get().SetButtons([BX.CDialog.prototype.btnSave, BX.CDialog.prototype.btnCancel]);
			BX.WindowManager.Get().SetTitle("Настройки вкладки: <?= $_POST["tabname"] ?>");
		</script>
<?
	}

	public static function templateNewTab($params = array("ID" => "new", 'NAME' => '', 'SORT' => 100,))
	{

		return '
		<tr class="tab' . $params["ID"] . '">
			<td>
				' . $params["NAME"] . '
			</td>
			<td>
				<input type="text" size="6" name="TABS[1][SORT]" value="' . $params["SORT"] . '">
			</td>
			<td>
				<a data-tabname="' . $params["NAME"] . '" data-tabid="' . $params["ID"] . '" href="javascript:void(0)"  onclick="editTab(this);" >Изменить</a>
			</td>
			<td>
				<a class="redLink" href="javascript:void(0)" data-tabid="' . $params["ID"] . '" onclick="dellTab(this);">Удалить</a>
			</td>
		</tr>
		';
	}

	public static function GetOptionForTabs()
	{
	}

	public static function GetOptionForEditTabs()
	{
	}

	public static function SetOptionForTabs()
	{
	}

	public static function GetTabsList()
	{
		$result = array();

		$Tabs = \K30\Bogdo\TabsTable::getEntity();
		$obTable = (new  \Bitrix\Main\ORM\Query\Query($Tabs))
			->setSelect(['*'])
			->exec();

		$result = $obTable->fetchAll();

		return $result;
	}

	public static function GetTabsInfo($ID)
	{
		$result = array();

		$Tabs = \K30\Bogdo\TabsTable::getEntity();
		$obTable = (new  \Bitrix\Main\ORM\Query\Query($Tabs))
			->setFilter(["ID" => $ID])
			->setSelect(['*'])
			->exec();

		$result = $obTable->fetchAll()[0];

		return $result;
	}

	public static function AddTab(array $params = array("NAME" => "default name", "SORT" => 100))
	{
		$result = \K30\Bogdo\TabsTable::add(array(
			"NAME" => $params["NAME"],
			"SORT" => $params["SORT"]
		));

		if ($result->isSuccess())
		{
			return $result->getId();
		}
		else
		{
			return false;
		}
	}

	public static function updateTab($ID, array $params = array("NAME" => "default name", "SORT" => 100))
	{
		$result = \K30\Bogdo\TabsTable::update($ID, array(
			"NAME" => $params["NAME"],
			"SORT" => $params["SORT"]
		));

		return $result;
	}

	public static function deleteTab($ID)
	{
		$result = \K30\Bogdo\TabsTable::delete($ID);

		return $result;
	}
}
