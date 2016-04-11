<?php
class CCustomTypeElementDate{

//��������� ��������� ����������������� ��������
    function GetUserTypeDescription() {
        return array(
            'PROPERTY_TYPE'           => 'E',
            'USER_TYPE'             	=> 'skill',
            'DESCRIPTION'           	=> '������������ � ���� ��������� ������������', //������ ��� ����� �������� � ������ ����� ������� �� ������� �������������� ������� ��
            //��������� ����������� �������, ������������ � ����������� ����
            'GetPropertyFieldHtml'  	=> array('CCustomTypeElementDate', 'GetPropertyFieldHtml'),
            'ConvertToDB'           	=> array('CCustomTypeElementDate', 'ConvertToDB'),
            'ConvertFromDB'         	=> array('CCustomTypeElementDate', 'ConvertToDB')
        );
    }
//��������� ���� ����� ��� ������������ ��������
    function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName) {
        $ID = intval($_REQUEST['ID']); //
        //��������� ������ ������������
        $rsSkills = CIBlockElement::GetList(
            array("SORT" => "ASC"),
            array(
                "IBLOCK_ID" => 25, //�� ������������
                "ACTIVE"    => "Y"
            ),
            false,
            false,
            array("ID","NAME")
        );
        //��������� ������ � ������� � ��������������
        $html = '<select name="'.$strHTMLControlName["VALUE"].'">';
        $html .= '<option value="">(�������� ������������)</option>';
        while ($arSkill = $rsSkills->GetNext()){
            $html .= '<option value="' .$arSkill["ID"]. '"';
            if ($arSkill["ID"] == $value["VALUE"]){
                $html .= 'selected="selected"';
            }
            $html .= '>' .$arSkill["NAME"]. '</option>';
        }
        $html .= '</select>';
        echo $html;
        //��������� ���� � ����� ��� �����������
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
    //��������� � ����
    function ConvertToDB($arProperty, $value){
        return $value;
    }
    //������ �� ����
    function ConvertFromDB($arProperty, $value){
        return $value;
    }
}