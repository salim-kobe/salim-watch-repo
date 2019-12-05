<?php


class Configuration
{
	private static $registry;


	public function __construct() //construct = PHP va rechercher cette méthode constructeur et chercher à l’exécuter
								//dès qu’un objet va être créé à partir de notre classe
	{
		if(Configuration::$registry === null)
		{
			Configuration::$registry = array();
		}
	}

	public function get($filename, $key, $defaultValue = null)
	{
		if(array_key_exists($filename, Configuration::$registry) === true) //array_key_exists — Vérifie si une clé existe dans un tableau
		{
			if(array_key_exists($key, Configuration::$registry[$filename]) === true)
			{
				return Configuration::$registry[$filename][$key];
			}
		}

		return $defaultValue;
	}

	public function load($filename)
	{
		require_once CFG_PATH."/$filename.php";

		Configuration::$registry[$filename] = $config;
	}
}