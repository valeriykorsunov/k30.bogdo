<?
namespace K30\Bogdo;

class EventHandler {

	public static function onPageStart(){
		include 'Debug.php';
	}

	public static function OnEpilog(){
		\Bogdo\Debug::showLog();
	}
}

?>