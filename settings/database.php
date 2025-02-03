<?php
error_reporting(1);
session_start();

$host_name = "localhost";
$database = "hr_system"; // Change your database name
$dbusername = "root"; // Your database user id
$dbpassword = ''; // Your password
$dbh = null;

class DB
{
	public static function connect()
	{
		global $host_name, $database, $dbusername, $dbpassword, $dbconn;

		try {
			$dbconn = new PDO('mysql:host=' . $host_name . ';dbname=' . $database, $dbusername, $dbpassword);
			// echo 'connected';
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}
}


DB::connect();
