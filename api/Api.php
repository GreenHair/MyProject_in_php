<?php
class Api{
    protected $response = NULL;
    // protected $contentType = "text/xml";
    protected $contentType = "application/json";
    protected $statuscode = 200;
    protected $statusMessage = "Ok";

    public function get($element){
        return $this->notImplemented();
    }

    public function post($element){
        return $this->notImplemented();
    }
    
    public function put($element){
        return $this->notImplemented();
    }
    
    public function delete($element){
        return $this->notImplemented();
    }

    public function contentType($type = NULL){
        if($type !== NULL){
            $this->contentType = $type;
        }
        return $this->contentType;
    }

    public function statusCode($code = NULL){
        if($code !== NULL){
            $this->contentType = $code;
        }
        return $this->statuscode;
    }

    public function statusMessage($message = NULL){
        if($message !== NULL){
            $this->contentType = $message;
        }
        return $this->statusMessage;
    }

    protected function notFound(){
        $this->statusCode(404);
        $this->statusMessage("Not Found");
        return $this->response()->getElement("The requested ressource could not be found","error");
    }

    protected function badRequest($message = ""){
        $this->statusCode(400);
        $this->statusMessage("Bad request");
        return $this->response()->getElement(
            empty($message)?"This request is formally incorrect":$message,"error"
        );
    }

    protected function notImplemented(){
        $this->statusCode(501);
        $this->statusMessage("Not implemented");
        return $this->response()->getElement("The requested method is not implemented","error");
    }

    protected function forbidden(){
        $this->statusCode(403);
        $this->statusMessage("Forbidden");
        return $this->response()->getElement("You are not allowed to access this resource","error");
    }

    protected function checkAuthorization(){
        $result = false;
        if(defined('AUTH_USER') && defined('AUTH_KEY')){
            if(isset($_GET['user']) && $_GET['user'] == AUTH_USER  && 
            isset($_GET['key']) && $_GET['key'] == AUTH_KEY){
                $result = true;
            }elseif(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == AUTH_USER &&
            isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == AUTH_KEY){
                $result = true;
            }
        }
        return $result;
    }

    public function response($response = NULL){
        if($response !== NULL){
            $this->response = $response;
        }elseif($this->response === NULL){
            $this->response = new Json();
        }
        return $this->response;
    }
}
?>