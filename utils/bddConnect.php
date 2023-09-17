<?php

/**
 * Database Connection
 */
class BddConnect

{
	private $server = 'localhost';
	private $dbname = 'react';
	private $user = 'root';
	private $pass = 'root';

	public function connexion()
	{
		try {
			$bdd = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname, $this->user, $this->pass);
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $bdd;
		} catch (\Exception $e) {
			echo "Database Error: " . $e->getMessage();
		}
	}
}
