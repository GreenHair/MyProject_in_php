<?php
class Json{
    public function getRecords($records, $root = 'result', $line = 'record'){
        //var_dump($records);
        $result = json_encode($records,JSON_UNESCAPED_UNICODE);
        return $result;
    }

    public function getRecord($record, $line = 'record'){
        $result = json_encode($record,JSON_UNESCAPED_UNICODE);
        return $result;
    }

    public function getElement($text, $element = 'message'){
        $el = array();
        $el[$element] = $text;
        $result = json_encode($el);
        return $result;
    }

    public function parse($xml, $fields){
        $result = array();
        $result = json_decode($xml, true);
        return $result;
    }

}
?>