<?php
class Excel extends Api
{
    private $dba = null;

    public function __construct()
    {
        $this->response = new Xml();
        $this->contentType = "text/xml";
    }
    public function get($elements)
    {
        if (isset($elements[0]) && !empty($elements[0])) {
            return $this->getPast($elements[0]);
        }
        return $this->getCurrent();
    }

    protected function getPast($year){
        $Excel = $this->dba()->getByyear($year);
        if(!empty($Excel)){
            return $this->response()->getRecord($Excel, 'Excel');
        }
        return $this->notFound();
    }

    protected function getCurrent(){
        if(isset($_GET['search'])){
            $data = $this->dba()->getBySearch($_GET['search']);
        }else{
            $data = $this->dba()->getCurrent();
        }
        if(!empty($data)){
            return $this->response()->getRecords($data, 'Excels', 'Excel');
        }
        return $this->notFound();
    }

    public function dba($dba = NULL){
        if($dba !== NULL){
            $this->dba = $dba;
        }elseif($this->dba === NULL){
            $this->dba = new ExcelDba();
        }
        return $this->dba;
    }
}
