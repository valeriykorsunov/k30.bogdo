# "BOGDO" - возможности модуля:

## DEBUG

`\Bogdo\Debug::console_log()` -  Вывод данных в отладочную консоль javascript (код выводится там, где вызвана функция)

`\Bogdo\Debug::consoleAdd()` - Вывод данных в отладочную консоль javascript (код выводится в OnEpilog)



Так как модули подключаются сразу после init.php (в служебной части пролога), то для доступа к модулю в init.php его нужно подключить:

`\Bitrix\Main\Loader::includeModule("k30.bogdo");`
