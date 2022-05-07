<?php
class LanguageDba extends Dba{

    private $response = NULL;

    protected $fields = array(
        'language_id' => 'id',
        'language_name' => 'name',
        'language_architecture' => 'architecture',
        'language_implementation' => 'implementation',
        'language_system' => 'system',
        'language_description' => 'description',
        'language_year' => 'year'
    );

    public function getAll(){
        $sql = "SELECT `language_id`, `language_name`, `language_architecture`, `language_implementation`, `language_system`, `language_description`, `language_year` FROM `languages` ORDER BY `language_name`";
        $result = array();
        $query = $this->query($sql);
        while($row = $query->fetch_assoc()){
            $result[$row['language_id']] = $this->recordToResult($row);
        }
        return $result;
    }

    public function getById($id){
        $sql = "SELECT `language_id`, `language_name`, `language_architecture`, `language_implementation`, `language_system`, `language_description`, `language_year` FROM `languages` WHERE `language_id` = %d";
        $query = $this->query($sql, $id);
        $row = $query->fetch_assoc();
        return $this->recordToResult($row);        
    }

    public function getBySearch($search){
        $condition = $this->getCondition(array('language_name' => '%' . $search . '%'));
        $sql = "SELECT `language_id`, `language_name`, `language_architecture`, `language_implementation`, `language_system`, `language_description`, `language_year` FROM `languages` WHERE " . $condition;
        $result = array();
        $query = $this->query($sql);
        while($row = $query->fetch_assoc()){
            $result[$row['language_id']] = $this->recordToResult($row);
        }
        return $result;
    }

    public function create($data){
        return $this->insertQuery('languages', $this->resultToRecord($data));
    }

    public function update($id, $data){
        return $this->updateQuery('languages', $this->resultToRecord($data),'language_id = %d', $id);
    }

    public function delete($id){
        $sql = "DELETE FROM `languages` WHERE language_id = %d";
        $this->query($sql, $id);
        return $this->getAffectedRows();
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