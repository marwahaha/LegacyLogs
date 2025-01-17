<?php

require "ProcessTBC.php";
require "../Database/Mysql.php";
require "CronJobTBC.php";

class FireCronJob{
	private $db = null;
	private $possib = array();
	
	private function commit(){
		$i=0;
		foreach($this->possib as $key => $val){
			if ($this->db->query('SELECT id FROM cronjob WHERE active = 1 AND expansion = 1 AND id = '.$key)->rowCount()==0){
				new CronJob($this->db, $key);
				if ($i>1)
					break;
				$i++;
			}
		}
	}
	
	public function __construct($db){
		for ($i=11; $i<=20; $i++){
			$this->possib[$i] = true;
		}
		$this->db = $db;
		$this->commit();
	}
}

$keyData = new KeyData();
$db = new Mysql($keyData->host, $keyData->user, $keyData->pass, $keyData->db, 3306, false, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

new FireCronJob($db);

?>