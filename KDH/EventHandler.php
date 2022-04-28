<?
namespace KDH;

class EventHandler {

	public static function onPageStart(){
		include 'Debug.php';
	}

	public static function OnEpilog(){
		var_dump("test01110111");
	}
}

