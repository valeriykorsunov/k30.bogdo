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

			table.gcustomsettings-settings-tab-headers td {
				border: 1px solid rgb(208, 215, 216) !important;
				padding: 3px !important;
			}

			.redLink {
				color: red;
			}
		</style>
	<?
	}

	public static function ShowJS()
	{
		?>
		<script>
			function addNewTabs(e){
				alert("test");
			}
		</script>
		<?
	}
}
