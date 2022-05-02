<?
namespace K30\Bogdo;

use \Bitrix\Main\Entity;
use Bitrix\Main\ORM;

class TabsTable extends ORM\Data\DataManager
{
	public static function getTableName()
    {
        return 'k30_bogdo_tabs';
    }

	public static function getMap()
	{
		return array(
			//ID
            new ORM\Fields\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //Название
			new ORM\Fields\StringField('NAME', array(
				'required' => true,
			)),
			// сортировка
			new ORM\Fields\IntegerField('SORT',array(
				'default_value' => 100
			)),

			// пользовательские свойства
			new ORM\Fields\Relations\OneToMany('USERS_PROPERTIES', \Bitrix\Main\UserFieldTable::class, 'K30_BOGDO_SETTINGS')
        );
	}
}