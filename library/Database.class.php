<?php


class Database
{
	private $pdo;


	public function __construct() //connexion à la BD
	{
		$configuration = new Configuration();
		
		$this->pdo = new PDO
		(
			$configuration->get('database', 'dsn'),
			$configuration->get('database', 'user'),
			$configuration->get('database', 'password')
		);

		$this->pdo->exec('SET NAMES UTF8');
	}

	public function executeSql($sql, array $values = array())// Retourne l'identifiant de la dernière ligne insérée
	{
		$query = $this->pdo->prepare($sql);

		$a = $query->execute($values);

		return $this->pdo->lastInsertId();
	}

    public function query($sql, array $criteria = array())// Retourne un tableau contenant toutes les lignes
    {
        $query = $this->pdo->prepare($sql);

        $query->execute($criteria);

        return $query->fetchAll(PDO::FETCH_ASSOC);//Récupère une ligne de résultat sous forme de tableau associatif
    }

    public function queryOne($sql, array $criteria = array())// Retourne un tableau contenant une ligne
    {
        $query = $this->pdo->prepare($sql);

        $query->execute($criteria);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}