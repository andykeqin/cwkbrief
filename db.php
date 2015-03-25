<?php
    class DbHelper {
        protected $conn;
        
        function __construct() {
            $config = include('config.php');
            $this->conn = mysqli_connect($config['DB_HOST'], $config['DB_USER'], $config['DB_PWD'], $config['DB_NAME'], $config['DB_PORT']);
            if (!$this->conn) {
                exit;
            }
            mysqli_query($this->conn, 'SET NAMES ' . $config['DB_CHARSET']);
        }
        
        function executeQuery($cmdText) {
            $tb = mysqli_query($this->conn, $cmdText);
            $result = array();
            while ($row = mysqli_fetch_array($tb)) {
                $result[] = $row;
            }
            return $result;
        }
        
        function executeNonQuery($cmdText) {
            mysqli_query($this->conn, $cmdText);
            return mysqli_affected_rows($this->conn) > 0;
        }
    }