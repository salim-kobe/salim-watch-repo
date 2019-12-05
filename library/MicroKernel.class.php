<?php

class MicroKernel //Micro-noyau
{
    /** @var string */
    private $applicationPath;

    /** @var Configuration $configuration */
    private $configuration;

    /** @var string */
    private $controllerPath;


    public function __construct()
    {
        $this->applicationPath = realpath(ROOT_PATH.'/application');//realpath() résout tous les liens symboliques,
                                                                // et remplace toutes les références /./, /../ et / de path 
                                                                //puis retourne le chemin canonique absolu ainsi trouvé. 
        $this->configuration   = new Configuration();
        $this->controllerPath  = null;
    }

    public function bootstrap()
    {
        // Activer le chargement automatique des classes de projet.
        spl_autoload_register([ $this, 'loadClass' ]);

        // Charger les fichiers de configuration.
        $this->configuration->load('database');
        $this->configuration->load('library');

        // Convertissez toutes les erreurs PHP en exceptions.
        error_reporting(E_ALL);
        set_error_handler(function($code, $message, $filename, $lineNumber)
        {
            throw new ErrorException($message, $code, 1, $filename, $lineNumber);
        });

        return $this;
    }

    public function loadClass($class)
    {
        // Activer la prise en charge des espaces de noms de style PSR-4.
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if(substr($class, -10) == 'Controller') //substr = Retourne un segment de chaîne
        {
            // Ceci est un fichier de classe de contrôleur.
            $filename = "$this->controllerPath/$class.class.php";
        }
        else if(substr($class, -4) == 'Form')
        {
            // Ceci est un fichier de classe de formulaire.
            $filename = "$this->applicationPath/forms/$class.class.php";
        }
        elseif(substr($class, -5) == 'Model')
        {
            // Ceci est un fichier de classe de modèle.
            $filename = "$this->applicationPath/models/$class.class.php";
        }
        else
        {
            // C'est un fichier de classe d'application (en dehors de MVC).
            $filename = "$this->applicationPath/classes/$class.class.php";
        }

        if(file_exists($filename) == true)
        {
            /** @noinspection PhpIncludeInspection */
            include $filename;
        }
        else
        {
            if($this->configuration->get('library', 'autoload-chain', false) == false)
            {
                throw new ErrorException
                (
                    "La classe <strong>$class</strong> ne se trouve pas ".
                    "dans le fichier<br><strong>$filename</strong>"
                );
            }
        }
    }

    public function run(FrontController $frontController)
    {
        try
        {
            //ob_start() démarre la temporisation de sortie. Tant qu'elle est enclenchée, aucune donnée, hormis les en-têtes, 
            //n'est envoyée au navigateur, mais temporairement mise en tampon. 
            ob_start();

            // Construisez les données de contexte HTTP.
            $requestPath = $frontController->buildContext($this->configuration);

            //Construisez la chaîne du chemin du contrôleur pour le chargement automatique de la classe du contrôleur.
            $this->controllerPath = "$this->applicationPath/controllers$requestPath";

            // Exécutez le front controlleur.
            $frontController->run();
            $frontController->renderView();

            // Envoyer une réponse HTTP et désactiver la mise en mémoire tampon de sortie.
            ob_end_flush();
        }
        catch(Exception $exception)
        {
            // Détruit tout contenu de tampon de sortie qui aurait pu être ajouté.
            ob_clean();

            $frontController->renderErrorView
            (
                implode('<br>', //implode — Rassemble les éléments d'un tableau en une chaîne
                [
                    $exception->getMessage(),
                    "<strong>Fichier</strong> : ".$exception->getFile(),
                    "<strong>Ligne</strong> : ".$exception->getLine()
                ])
            );
        }
    }
}