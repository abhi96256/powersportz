<?php if (!defined('DATATABLES')) exit(); // Ensure being used in DataTables env.

// Enable error reporting for debugging (remove for production)
error_reporting(E_ALL);
ini_set('display_errors', '1');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Database user / pass
 */
   
// ////$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");

$sql_details = array(
	"type" => "Mysql",  // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
	"user" => "powersport",       // Database user name
	"pass" => "Dgt569khd",       // Database password
	"host" => "10.10.10.28",       // Database host
	"port" => "",       // Database connection port (can be left empty for default)
	"db"   => "powersport",       // Database name
	"dsn"  => ""        // PHP DSN extra information. Set as `charset=utf8` if you are using MySQL
);



/*
$sql_details = array(
	"type" => "Mysql",  // Database type: "Mysql", "Postgres", "Sqlserver", "Sqlite" or "Oracle"
	"user" => "mojo_voice",       // Database user name
	"pass" => "mojo@123",       // Database password
	"host" => "spice-db.cpersmswui52.eu-west-1.rds.amazonaws.com",       // Database host
	"port" => "",       // Database connection port (can be left empty for default)
	"db"   => "mojovoice",       // Database name
	"dsn"  => ""        // PHP DSN extra information. Set as `charset=utf8` if you are using MySQL
);
*/
