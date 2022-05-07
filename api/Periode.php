<?php
class Periode extends Api
{
    private $dba = null;
    protected $period = null;

    public function get($elements)
    {
        if (isset($elements[0]) && !empty($elements[0])) {
            return $this->getPast($elements[0]);
        }
        return $this->getCurrent();
    }

    protected function getPast($interval){
        $Periode = $this->dba()->getByInterval($interval);
        if(!empty($Periode)){
            return $this->response()->getRecord($Periode, 'Periode');
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
            return $this->response()->getRecords($data, 'Periodes', 'Periode');
        }
        return $this->notFound();
    }

    public function dba($dba = NULL){
        if($dba !== NULL){
            $this->dba = $dba;
        }elseif($this->dba === NULL){
            $this->dba = new PeriodeDba($this->period);
        }
        return $this->dba;
    }
}
