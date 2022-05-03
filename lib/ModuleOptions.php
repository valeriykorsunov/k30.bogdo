<?

namespace K30\Bogdo;


class ModuleOptions
{

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
}
