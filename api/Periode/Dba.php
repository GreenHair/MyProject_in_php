<?php
class PeriodeDba extends Dba{

    private $response = NULL;
    private $function = null;

    protected $fields = array(
        'total_expenses' => 'ausgaben',
        'total_income' => 'inkommen'
    );

    private function month(){
        return "SELECT MONTH(CURRENT_DATE) as Periode_id, SUM(ausgaben.betrag) as total_expenses, 
        (SELECT SUM(einkommen.betrag) FROM einkommen
        WHERE EXTRACT(YEAR_MONTH FROM einkommen.datum) = EXTRACT(YEAR_MONTH FROM CURRENT_DATE)) as total_income  
        FROM ausgaben 
        JOIN rechnung ON ausgaben.rechnungsnr = rechnung.id
        WHERE EXTRACT(YEAR_MONTH FROM rechnung.datum) = EXTRACT(YEAR_MONTH FROM CURRENT_DATE)";
    }

    public function __construct($function)
    {
        switch($function){
            case "woche": $this->function = "WEEK" ; break;
            case "Monat": $this->function = "month"; break;
            case "jahr" : $this->function = "YEAR" ; break;
            default : $this->function = "WEEK";
        }
    }

    public function getCurrent(){
        $sql = $this->{$this->function}();;
        $result = array();
        $query = $this->query($sql);
        while($row = $query->fetch_assoc()){
            $result[$row['Periode_id']] = $this->recordToResult($row);
        }
        return $result;
    }

    public function getPast($interval){
        $sql = "SELECT `Periode_id`, `Periode_name`, `Periode_architecture`, `Periode_implementation`, `Periode_system`, `Periode_description`, `Periode_year` FROM `Periodes` WHERE `Periode_id` = %d";
        $query = $this->query($sql, $interval);
        $row = $query->fetch_assoc();
        return $this->recordToResult($row);        
    }

    public function getBySearch($search){
        $condition = $this->getCondition(array('Periode_name' => '%' . $search . '%'));
        $sql = "SELECT `Periode_id`, `Periode_name`, `Periode_architecture`, `Periode_implementation`, `Periode_system`, `Periode_description`, `Periode_year` FROM `Periodes` WHERE " . $condition;
        $result = array();
        $query = $this->query($sql);
        while($row = $query->fetch_assoc()){
            $result[$row['Periode_id']] = $this->recordToResult($row);
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