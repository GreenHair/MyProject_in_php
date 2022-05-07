<?php
class Language extends Api
{
    private $dba = null;

    public function get($elements)
    {
        if (isset($elements[0]) && !empty($elements[0])) {
            return $this->getOne($elements[0]);
        }
        return $this->getAll();
    }

    public function post($elements)
    {
        if (!$this->checkAuthorization()) {
            return $this->forbidden();
        }
        $raw = file_get_contents('php://input');
        if (!empty($raw)) {
            $data = $this->dba()->parse($raw, $this->response());
            $id = $this->dba()->create($data);
            if ($id) {
                return $this->response()->getElement(
                    sprintf('Created new language with ID %d', $id),
                    'success'
                );
            } else {
                return $this->badRequest("Could not create a new record. Database error");
            }
        }
        return $this->badRequest("You provided no data to insert.");
    }

    public function put($elements)
    { 
        if (!$this->checkAuthorization()) {
            return $this->forbidden();
        }
        if (isset($elements[0])) {
            $id = $elements[0];
            $raw = file_get_contents('php://input');
            if (!empty($raw)) {
                $data = $this->dba()->parse($raw,$this->response());
                $success = $this->dba()->update($id, $data);
                trigger_error("success | $success |");
                if ($success > 0) {
                    return $this->response()->getElement(
                        'Language successfully modified',
                        'success'
                    );
                }
            }
        }
        return $this->badRequest();
    }

    public function delete($elements)
    {
        if (!$this->checkAuthorization()) {
            return $this->forbidden();
        }
        if (isset($elements[0])) {
            $id = $elements[0];
            $success = $this->dba()->delete($id);
            if ($success) {
                return $this->response()->getElement(
                    'Language successfully deleted',
                    'success'
                );                
            }
        }
        return $this->badRequest();
    }

    protected function getOne($id){
        $language = $this->dba()->getById($id);
        if(!empty($language)){
            return $this->response()->getRecord($language, 'language');
        }
        return $this->notFound();
    }

    protected function getAll(){
        if(isset($_GET['search'])){
            $data = $this->dba()->getBySearch($_GET['search']);
        }else{
            $data = $this->dba()->getAll();
        }
        if(!empty($data)){
            return $this->response()->getRecords($data, 'languages', 'language');
        }
        return $this->notFound();
    }

    public function dba($dba = NULL){
        if($dba !== NULL){
            $this->dba = $dba;
        }elseif($this->dba === NULL){
            $this->dba = new LanguageDba();
        }
        return $this->dba;
    }
}
