<?php

class Database {

    private $mysqli;

    function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Create the prepared statement
        $this->mysqli->query('CREATE DATABASE IF NOT EXISTS '.$data['db_name']);

		return true;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
        $this->mysqli = new mysqli($data['db_host'],$data['db_user'],$data['db_password'],$data['db_name']);

		// Open the default SQL file
		$query = file_get_contents('sql/database.sql');

		// Execute a multi query
        $this->mysqli->multi_query($query);

		return true;
	}
}
