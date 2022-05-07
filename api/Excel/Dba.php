<?php
class ExcelDba extends Dba{

    //private $response = NULL;

    protected $fields = array(     
        "id" => "Rechung_id",   
        "datum" => "Datum",
        "name" => "Laden",
        "vorname" => "Name",
        "kategorie" => "Kategorie",
        "essen" => "Ist_essen",
        "einmalig" => "Einmalig",
        "bezeichnung" => "Bezeichnung",
        "betrag" => "Betrag",
    );

    public function getCurrent(){
        $sql = "SELECT rechnung.id, rechnung.datum, laden.name, familienmitglied.vorname, produktgruppe.bezeichnung AS kategorie, rechnung.einmalig, produktgruppe.essen, ausgaben.bezeichnung, FORMAT(ausgaben.betrag, 2, 'de_DE') AS betrag FROM rechnung
        JOIN laden ON rechnung.laden = laden.ID
        JOIN familienmitglied ON rechnung.person = familienmitglied.ID
        JOIN ausgaben ON rechnung.id = ausgaben.rechnungsnr
        JOIN produktgruppe ON ausgaben.prod_gr = produktgruppe.ID
        WHERE YEAR(rechnung.datum) = YEAR(CURRENT_DATE)";
        $result = array();
        $query = $this->query($sql);
        while($row = $query->fetch_assoc()){
            $result[$row["id"]] = $this->recordToResult($row);
        }
        return $result;
    }

    public function getPast($year){
        $sql = "SELECT `Excel_id`, `Excel_name`, `Excel_architecture`, `Excel_implementation`, `Excel_system`, `Excel_description`, `Excel_year` FROM `Excels` WHERE `Excel_id` = %d";
        $query = $this->query($sql, $year);
        $row = $query->fetch_assoc();
        return $this->recordToResult($row);        
    }

    public function getBySearch($search){
        $condition = $this->getCondition(array('Excel_name' => '%' . $search . '%'));
        $sql = "SELECT `Excel_id`, `Excel_name`, `Excel_architecture`, `Excel_implementation`, `Excel_system`, `Excel_description`, `Excel_year` FROM `Excels` WHERE " . $condition;
        $result = array();
        $query = $this->query($sql);
        while($row = $query->fetch_assoc()){
            $result[$row['Excel_id']] = $this->recordToResult($row);
        }
        return $result;
    }

    public function parse($rawXml,$xml = null){
        return $this->response($xml)->parse($rawXml,$this->fields);
    }

    public function response($xml = NULL){
        if($xml !== NULL){
            $this->response = $xml;
        }else{
            $this->response = new Json();
        }
        return $this->response;
    }

}
?>