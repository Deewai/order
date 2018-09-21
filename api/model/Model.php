<?php
namespace App\model;
class Model{
    private $conn;


	function __construct()
	{
		$this->dbconnect();
	}//end __construct

	function dbconnect()
	{
		try {
			$this->conn = new \PDO('mysql:host=' . __SERVER . ';dbname=' . __DBNAME . ';charset=utf8', __USER, __PASS);
            // set the \PDO error mode to exception
			$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";

		} catch (\PDOException $e) {
            // echo "Connection failed: " . $e->getMessage();
		}

	}//end dbconnect

	function get_conn()
	{
		return $this->conn;
	}//end get_conn
}