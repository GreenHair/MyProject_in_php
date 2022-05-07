<?php
require_once(__DIR__ . "/config.inc.php");
class Database{
    
    private $con = null;
    
    public function setCon($con){
        $this->con = $con;
    }
    
    /**
     * Get the Database connection, initialize if necessary
     * @throws RuntimeException
     * @return mysqli
     */
    public function getCon(){
        if(!is_object($this->con)){
            $this->con = new mysqli(HOST,USER,PASSWORD,DATABASE);
            if(!is_object($this->con)){
                throw new RuntimeException("no database connection");
            }
        }
        
        if(defined("CHARSET")){
            //$this->query(INIT_QUERY);
            $this->con->set_charset(CHARSET);
            trigger_error("initquery defined");
        }
        
        return $this->con;
    }

    /**
     * Create a condition to be used in a WHERE clause
     * @param array $filter
     * @return string
     */
    public function getCondition($filter){
        $result = "";
        $con = $this->getCon();
        $fieldFirstRun = TRUE;
        foreach($filter as $field => $value){
            if(!$fieldFirstRun){
                $result .= ' AND';
            }else{
                $fieldFirstRun = FALSE;
            }
            $result .= sprintf(" %s", $con->real_escape_string($field));
            if(is_array($value)){
                $result .= " IN (";
                $valFirstRun = TRUE;{
                    foreach($value as $val){
                        if(!$valFirstRun){
                            $result .= ", ";
                        }else{
                            $valFirstRun = FALSE;
                        }
                        $result .= sprintf("'%s'", $con->real_escape_string($val));
                    }
                    $result .= ")";
                }
            }elseif(strstr($value, '%') || strstr($value, '_')){
                $result .= sprintf(" LIKE '%S'", $con->real_escape_string(str_replace('%', '%%', $value)));
            }else{
                $result .= sprintf(" = '%s'", $con->real_escape_string($value));
            }
        }
        return $result;
    }

    /**
     * Perform a Database query
     * @param string $sql sprintf() - style format string
     * @param  array $params parameters for the format string (optional)
     * @return mysqli_result
     */
    public function query($sql, $params = array()){
        $con = $this->getCon();
        if(!is_array($params)){
            $params = array($params);
        }
        foreach($params as $key => $param){
            $params[$key] = $con->real_escape_string($param);
        }
        return $con->query(vsprintf($sql, $params));
    }

    /**
     * Perform an insert query
     * @param string $table
     * @param array $values associative array ($field => $value)
     * @return mixed last insert ID or affected rows
     */
    public function insertQuery($table, $values){
        $con = $this->getCon();
        $sql = "INSERT INTO %s (";
        $firstRun = TRUE;
        foreach(array_keys($values) as $field){
            if(!$firstRun){
                $sql .= ", ";
            }else{
                $firstRun = FALSE;
            }
            $sql .= $con->real_escape_string($field);
        }
        $sql .= ") VALUES (";
        $firstRun = TRUE;
        foreach($values as $value){
            if(!$firstRun){
                $sql .= ", ";
            }else{
                $firstRun = FALSE;
            }
            $sql .= $con->real_escape_string($value);
        }
        $sql .= ")";
        $this->query($sql, array($table));
        return $con->insert_id ? $con->insert_id : $con->affected_rows;
    }

    /**
     * Perfom an update query
     * @param string $table
     * @param array $values associative array ($field => $value)
     * @param string $condition sprintf() - style format string
     * @param array $param arguments for the sprintf() - style pattern
     * @throws InvalidArgumentException
     * @return integer number of affecte rows
     */
    public function updateQuery($table, $values, $condition = '', $params = array()){
        if(empty($values) || !is_array($values)){
            throw new InvalidArgumentException("At least one value for update needed");
        }
        $con = $this->getCon();
        $sql = sprintf("UPDATE %s SET ", $con->real_escape_string($table));
        $firstRun = TRUE;
        foreach($values as $field => $value){
            if($firstRun){
                $firstRun = FALSE;
            }else{
                $sql .= " ,";
            }
            $sql .= sprintf("%s = '%s'", $con->real_escape_string($field), $con->real_escape_string($value));
            
        }
        if(trim($condition) != ''){
            if(!is_array($params)){
                $params = array($params);
            }
            foreach($params as $key => $param){
                $params[$key] = $con->real_escape_string($param);
            }
            $sql .= sprintf(" WHERE %s", vsprintf($condition, $params));
        }
        $con->query($sql);
        return $con->affected_rows;
    }

    public function escape($string){
        $con = $this->getCon();
        return $con->real_escape_string($string);
    }

    public function getAffectedRows(){
        $con = $this->getCon();
        return $con->affected_rows;
    }

    public function getLastInsertId(){
        $con = $this->getCon();
        return $con->insert_id;
    }
}
?>