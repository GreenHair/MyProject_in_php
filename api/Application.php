<?php
class Application{
    public function run(){
        $path = strtok($_SERVER['REQUEST_URI'],'?');
        
        $elements = preg_split('(/)',$path);
        
        do{
            $element = array_shift($elements);
            //trigger_error($element);
        }
        while(empty($element) || $element != 'api');

        $classname = array_shift($elements);
        
        $instance = new $classname();
        if(isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] == 'xml'){
            $instance->contentType('text/xml');
            $instance->response(new Xml());
        }
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $result = $instance->$method($elements);
        header(sprintf("HTTP/1.1 %d %s", $instance->statusCode(), $instance->statusMessage()));
        header(sprintf("Content-type: %s", $instance->contentType()));
        header(sprintf("Content-length: %d", strlen($result)));
        echo $result;
    }
}
?>