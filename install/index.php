<?

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);
class kvv_bogdo extends CModule
{

	function __construct()
	{
		$arModuleVersion = array();
		include(__DIR__ . '/version.php');

		$this->MODULE_ID = 'kvv.bogdo';
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("KVV_BOGDO_MODULE_NAME"); // имя модуля
		$this->MODULE_DESCRIPTION = Loc::getMessage("KVV_BOGDO_MODULE_DESCRIPTION"); // описание модуля

		$this->PARTNER_NAME = Loc::getMessage("KVV_BOGDO_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("KVV_BOGDO_PARTNER_URI");

		$this->MODULE_SORT = 1;
		$this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
		$this->MODULE_GROUP_RIGHTS = 'Y';  //используем ли индивидуальную схему распределения прав доступа
	}

	function DoInstall()
	{
		global $APPLICATION;
		if ($this->isVersionD7()) {
			ModuleManager::registerModule($this->MODULE_ID);

			\Bitrix\Main\Loader::includeModule($this->MODULE_ID);
			$this->editHandler("install");
		} else {
			$APPLICATION->ThrowException(Loc::getMessage("KVV_BOGDO_ERROR_VERSION_D7"));
		}

		$APPLICATION->IncludeAdminFile(Loc::getMessage("KVV_BOGDO_INSTALL_TITLE"), $this->GetPath() . "/install/step.php");
	}

	function DoUninstall()
	{
		if (!check_bitrix_sessid()) return false;
		global $APPLICATION;
		$context = Application::getInstance()->getContext();
		$request = $context->getRequest();

		if ($request["step"] < 2) {
			$APPLICATION->IncludeAdminFile(Loc::getMessage("KVV_BOGDO_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep1.php");
		} elseif ($request["step"] == 2) {
			if ($request["savedata"] != "Y") {
				// удвлить данные из БД
			}

			$this->editHandler("uninstall");

			ModuleManager::unRegisterModule($this->MODULE_ID);
			$APPLICATION->IncludeAdminFile(Loc::getMessage("KVV_BOGDO_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep2.php");
		}
	}

	protected function isVersionD7()
	{
		return CheckVersion(\Bitrix\Main\ModuleManager::getVersion("main"), "14.00.00"); // на этой версии я начал разработку.
	}

	protected function GetPath($notDocumentRoot = false)
	{
		if ($notDocumentRoot)
			return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
		else
			return dirname(__DIR__);
	}

	protected function editHandler($typeAction)
	{
		$listHendler = array(
			["ModuleId" => "main", "Event" => "onPageStart", "Sort" => "100"],
			["ModuleId" => "main", "Event" => "OnEpilog", "Sort" => "100"],
		);

		if ($typeAction == "install") {
			foreach ($listHendler as $params) {
				$this->registerHandler($params);
			}
		}
		if ($typeAction == "uninstall") {
			foreach ($listHendler as $params) {
				$this->registerHandler($params);
			}
		}
	}

	protected function registerHandler(array $params)
	{
		if (!isset($params["ModuleId"], $params["Event"], $params["Sort"])) return false; // TODO зафиксировать как ошибку.

		\Bitrix\Main\EventManager::getInstance()->registerEventHandler(
			$params["ModuleId"],
			$params["Event"],
			$this->MODULE_ID,
			'\Bogdo\EventHandler',
			$params["Event"],
			$params["Sort"]
		);
	}

	protected function unregisterHandler($params)
	{
		if (!isset($params["ModuleId"], $params["Event"], $params["Sort"])) return false; // TODO зафиксировать как ошибку.

		\Bitrix\Main\EventManager::getInstance()->unregisterEventHandler(
			$params["ModuleId"],
			$params["Event"],
			$this->MODULE_ID,
			'\Bogdo\EventHandler',
			$params["Event"]
		);
	}
}
