<?php
class CCustomTypeElementDate{

//описываем поведение пользовательского свойства
    function GetUserTypeDescription() {
        return array(
            'PROPERTY_TYPE'           => 'E',
            'USER_TYPE'             	=> 'skill',
            'DESCRIPTION'           	=> 'Квалификация — Дата получения квалификации', //именно это будет выведено в списке типов свойств во вкладке редактирования свойств ИБ
            //указываем необходимые функции, используемые в создаваемом типе
            'GetPropertyFieldHtml'  	=> array('CCustomTypeElementDate', 'GetPropertyFieldHtml'),
            'ConvertToDB'           	=> array('CCustomTypeElementDate', 'ConvertToDB'),
            'ConvertFromDB'         	=> array('CCustomTypeElementDate', 'ConvertToDB')
        );
    }
//формируем пару полей для создаваемого свойства
    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName) {
        $ID = intval($_REQUEST['ID']); //
        //формируем список квалификаций
        $rsSkills = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            array(
                "IBLOCK_ID" => 25, //ИБ Квалификации
                "ACTIVE"    => "Y"
            ),
            false,
            false,
            array("ID","NAME")
        );
        //формируем селект с опциями — квалификациями
        $html = '<select name="'.$strHTMLControlName["VALUE"].'">';
        $html .= '<option value="">(выберите квалификацию)</option>';
        while ($arSkill = $rsSkills->GetNext()){
            $html .= '<option value="' .$arSkill["ID"]. '"';
            if ($arSkill["ID"] == $value["VALUE"]){
                $html .= 'selected="selected"';
            }
            $html .= '>' .$arSkill["NAME"]. '</option>';
        }
        $html .= '</select>';
        echo $html;
        //формируем поле с датой для дескрипшена
        global $APPLICATION;
        $APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
                "SHOW_INPUT" => "Y",
                "FORM_NAME" => "",
                "INPUT_NAME" => $strHTMLControlName["DESCRIPTION"],
                "INPUT_NAME_FINISH" => "",
                "INPUT_VALUE" => $value["DESCRIPTION"],
                "INPUT_VALUE_FINISH" => "",
                "SHOW_TIME" => "N",
                "HIDE_TIMEBAR" => "Y"
            )
        );
        echo "<br />";
    }
    //сохраняем в базу
    function ConvertToDB($arProperty, $value){
        return $value;
    }
    //читаем из базы
    function ConvertFromDB($arProperty, $value){
        return $value;
    }
}