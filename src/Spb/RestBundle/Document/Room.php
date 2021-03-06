<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 16.11.13
 * Time: 16:35
 */

namespace Spb\RestBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class Room
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
    * @MongoDB\Int
    */
    protected $externalId;

    /**
    * @MongoDB\String
    */
    protected $region;

    /**
     * @MongoDB\String
     */

/*
"Метро#" : "пл. Ленина",
"Цена" : 1740,
"Субъект" : "частное",
"Телефон" : "(950)2202488",
"Вид сделки" : "продажа",
"Район" : "Калининский район",
"Метро" : "пл. Ленина 1 пеш",
"Адрес" : "Ак. Лебедева ул. 31",
"Комнат" : "1",
"Общая пл. (м2)" : "93",
"Жилая пл. (м2)" : "16",
"Этаж/Этажность" : "5/5",
"Тип дома" : "Ст.Фонд Кап.Рем.",
"Просмотров" : "54",
"Дата размещения" : "28.10.2013",
"Дополнительно" : "<p>&#13;\n\tПродам комнату 16 кв.м. с балконом в трёхкомнатной квартире.</p>&#13;\n<p>&#13;\n\t1 минута пешком от метро пл. Ленина, 3 минуты пешком от Финляндского вокзала,</p>&#13;\n<p>&#13;\n\tрядом Нева и Литейный мост (600 метров).</p>&#13;\n<div>&#13;\n\tДом постройки 1896 года, был капитальный ремонт, перекрытия железобетонные.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tВход с улицы, чистая шикарная парадная с лепниной и ажурной ковкой.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tКвартира расположена на верхнем этаже, кровля над квартирой отремонтирована.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tСанузел раздельный, горячая вода - газовая колонка, полы - паркет, металлическая входная дверь, потолки 3.20 м</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tКвартира малонаселенная, тихая, чистая, по домашнему уютная, ещё две комнаты.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tХорошие спокойные соседи, две молодые пары без детей.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tКомната после ремонта, натяжные потолки.</div>&#13;\n<div>&#13;\n\tБалкон выходит в сквер. Деревья в сквере высокие, крона на уровне балкона. С балкона открывается прекрасный вид.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tДом находится в историческом центре города, рядом находятся: Военно-медицинская Академия имени С. М. Кирова, Администрация Калининского района, Гостиница \"Санкт-Петербург\", Бизнес-центр «Петровский форт», Аврора, Домик Петра I.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tХорошее состояние, прямая продажа, собственность более 3 лет, документы готовы.</div>&#13;\n<div>&#13;\n\t </div>&#13;\n<div>&#13;\n\tКомната перспективная - есть договоренность о продаже всей квартиры.</div>",
"Фото" :
"Пл. кухни (м2)" : "8",
"Санузел" : "Раздельный",
"Наличие телефона" : "+"
*/

} 