<?php
class db{
    // Properties
    private $dbhost = "localhost";
    private $dbname = "daonline_sitedb";
    private $dbuser = "daonline_bclincy";
    private $dbpass = "bcuz1Isb";
    // Connect
    public function connect(){    
        $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $dbConnection;
     }
}
