<?

namespace KDH;


class Debug
{
	/**
	 * Вывод данных в отладочную консоль javascript
	 *
	 * @param $data
	 */
	static function console_log($data)
	{
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
		$json = json_encode(unserialize(str_replace(
			array('NAN;', 'INF;'),
			'0;',
			serialize($data)
		)));
		echo '<script>';
		echo 'console.group("' . $backtrace[0]["file"] . " - line: " . $backtrace[0]["line"] . '");';
		echo 'console.log(' . $json . ');';
		echo 'console.groupEnd();';
		echo '</script>';
	}
}
