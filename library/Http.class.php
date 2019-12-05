<?php

class Http
{
	private $requestMethod;

	private $requestPath;


	public function __construct()
	{
		$this->requestMethod = $_SERVER['REQUEST_METHOD']; //REQUEST_METHOD = POST ou GET

		if(isset($_SERVER['PATH_INFO']) == false || $_SERVER['PATH_INFO'] == '/')//PATH_INFO = chemin_info
		{
			$this->requestPath = null;
		}
		else
		{
			$this->requestPath = strtolower($_SERVER['PATH_INFO']); //strtolower = Renvoie une chaîne en minuscules
		}
	}

	public function getRequestFile() // récupère la dernière partie de l’url
	{
		if($this->requestPath == null)
		{
			return 'Home';
		}

        $pathSegments = explode('/', $this->requestPath); //explode — Scinde une chaîne de caractères en segments

		if(($pathSegment = array_pop($pathSegments)) == null)// array_pop() dépile (contraire d'empiler) et retourne 
																//la valeur du dernier élément du tableau array, 
																//le raccourcissant d'un élément. 
        {
            // Une barre oblique de fin a été ajoutée à l'URL, supprimez-la.
            $pathSegment = array_pop($pathSegments);
        }

        return ucfirst($pathSegment); // Met le premier caractère en majuscule
	}

	public function getRequestMethod() //récupère la méthode utilisée (GET ou POST)
	{
		return $this->requestMethod;
	}

	public function getRequestPath() //récupère la partie d’url située après index.php 
	{
		return $this->requestPath;
	}

    public function getUploadedFile($name) //obtenir le fichier téléchargé
    {
        if(array_key_exists($name, $_FILES) == true)
        {
            if($_FILES[$name]['error'] == UPLOAD_ERR_OK)
            {
                return $_FILES[$name];
            }
        }

        return false;
    }

    public function hasUploadedFile($name)  //a téléchargé le fichier
    {
        if(array_key_exists($name, $_FILES) == true)
        {
            if($_FILES[$name]['error'] == UPLOAD_ERR_OK)
            {
                return true;
            }
        }

        return false;
    }

    public function moveUploadedFile($name, $path = null) //déplacer le fichier téléchargé
    {
        if($this->hasUploadedFile($name) == false)
        {
            return false;
        }

        // Construisez le chemin absolu du fichier de destination.
        $filename = WWW_PATH."$path/".$_FILES[$name]['name'];

        move_uploaded_file($_FILES[$name]['tmp_name'], $filename);

        return pathinfo($filename, PATHINFO_BASENAME);
    }

	public function redirectTo($url) 
	{
		if(substr($url, 0, 1) !== '/')
		{
			$url = "/$url";
		}

		header('Location: http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'].$url);
		exit();
	}

	public function sendJsonResponse($data) //envoyer une réponse Json
	{
        echo json_encode($data);
		exit();
	}
}