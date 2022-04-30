<?

namespace K30\Bogdo;

class Test
{
	static function dump($data)
	{
		echo"<pre>"; var_dump(substr(strrchr(dirname(__DIR__,3),"/"),1)); echo "</pre>";
	}
}
?>