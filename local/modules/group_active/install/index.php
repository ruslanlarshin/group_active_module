<?

Class group_active extends CModule
{
var $MODULE_ID = "group_active";
var $MODULE_VERSION;
var $MODULE_VERSION_DATE;
var $MODULE_NAME;
var $MODULE_DESCRIPTION;
var $MODULE_CSS;

function group_active()
{
$arModuleVersion = array();

$path = str_replace("\\", "/", __FILE__);
$path = substr($path, 0, strlen($path) - strlen("/index.php"));
include($path."/version.php");

if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
{
$this->MODULE_VERSION = $arModuleVersion["VERSION"];
$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
}

$this->MODULE_NAME = "group_active Ц модуль с компонентом";
$this->MODULE_DESCRIPTION = "ѕосле установки вы сможете пользоватьс€ компонентом group_active:larshin";
}

function InstallFiles()
{
CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/group_active/install/components",
             $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
return true;
}

function UnInstallFiles()
{
DeleteDirFilesEx("/local/components/group_active");
return true;
}

function DoInstall()
{
global $DOCUMENT_ROOT, $APPLICATION;
$this->InstallFiles();
RegisterModule("group_active");
$APPLICATION->IncludeAdminFile("”становка модул€ group_active", $DOCUMENT_ROOT."/local/modules/group_active/install/step.php");
}

function DoUninstall() 
{
global $DOCUMENT_ROOT, $APPLICATION;
$this->UnInstallFiles();
UnRegisterModule("group_active");
$APPLICATION->IncludeAdminFile("ƒеинсталл€ци€ модул€ group_active", $DOCUMENT_ROOT."/local/modules/group_active/install/unstep.php");
}
}
?>