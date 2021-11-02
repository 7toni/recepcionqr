<?php
// require_once 'app.php';
abstract class Db {
   
    private static $db_host = APP_SERVER;
    private static $db_user = APP_USER;
    private static $db_pass = APP_PASS;
    protected $db_name = APP_DB;
    protected $query, $table, $table_aux, $primary_key;
    protected $rows = array();
    private $conn;


    public function read_single($id, $view = null) {
        if ($view == null) {
            $this->query = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = '" . $id . "'";
            $this->get_results_from_query();            
            return $this->rows;
        } else {
            $table_aux = $this->table;
            $this->table = $view;
            $this->query = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = '" . $id . "'";       
            $this->get_results_from_query();
            $this->table = $table_aux;
            return $this->rows;
            
        }
    }

    public function read_single_by($data, $view = null) {
        if ($view == null) {
            $query = "SELECT * FROM " . $this->table . " WHERE ";
            foreach ($data as $key => $value) {
                $query .= $key . " = '" . $value . "'";
                $query .= " AND ";
            }
            $query = substr($query, 0, -5);
            $this->query = $query;                        
            $this->get_results_from_query();
            return $this->rows;
        } else {
            $table_aux = $this->table;
            $this->table = $view;
            $query = "SELECT * FROM " . $this->table . " WHERE ";
            foreach ($data as $key => $value) {
                $query .= $key . " = '" . $value . "'";
                $query .= " AND ";
            }
            $query = substr($query, 0, -5);
            $this->query = $query;            
            $this->get_results_from_query();
            $this->table = $table_aux;           
            return $this->rows;
        }
    }

    private function open_connection() {
        $this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);        
        $this->conn->set_charset("utf8");
        if ($this->conn->connect_error) {
            var_dump($this->conn);           
        }
    }

    private function close_connection() {
        $this->conn->close();
    }

    protected function get_results_from_query() {
        unset($this->rows);
        $this->open_connection();        
        $result = $this->conn->query($this->query);        
        if ($result) {
            while ($this->rows[] = $result->fetch_assoc());
            $result->close();
            $this->close_connection();
            array_pop($this->rows);
        } else {
            return false;
        }
    }



}