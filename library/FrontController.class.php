<?php

class FrontController
{
    private $http;

    private $viewData;


    public function __construct() // création de $wwwUrl pour afficher les liens en html
    {
        $this->http = new Http();

        // Configurez les données de vue avec des variables de requête spéciales et WWW URL variables.
        $this->viewData = // création tableau
        [
            'template'  => null,
            'variables' =>
            [
                'requestUrl' => $_SERVER['SCRIPT_NAME'],
                'wwwUrl'     => str_replace('index.php', 'application/www', $_SERVER['SCRIPT_NAME'])
            ] //$_SERVER = donne des infos enregistrer sur le serveur 
        ];
    }

    public function buildContext(Configuration $configuration) // construire le contexte
    {
        // Trouvez tous les filtres d'interception à charger.
        $filters = $configuration->get('library', 'intercepting-filters', array());

        // Run all the intercepting filters.
        foreach($filters as $filterName)
        {
            if(empty($filterName) == true)
            {
                continue;
            }

            $filterName = $filterName.'Filter';

            /** @var InterceptingFilter $filter */
            $filter = new $filterName();

            if ($filter instanceof InterceptingFilter)
            {
                // Fusionner les variables de filtres d'interception avec les variables de vue.
                $this->viewData['variables'] = array_merge
                (
                    $this->viewData['variables'],
                    (array) $filter->run($this->http, $_GET, $_POST)
                );
            }
        }

        return $this->http->getRequestPath();//  récupère la partie d’url située après index.php 
    }

    public function renderErrorView($_fatalErrorMessage) //rendre la vue d'erreur
    {
        // Injectez les variables du modèle (du template) de vue.
        extract($this->viewData['variables'], EXTR_OVERWRITE);

        // Chargez le modèle d'erreur puis quittez.
        include 'ErrorView.phtml';
        die();
    }

    public function renderView() //
    {
        // Construisez le chemin complet du modèle (du template) et le nom du fichier en utilisant les valeurs par défaut.
        $this->viewData['template'] = WWW_PATH.
            $this->http->getRequestPath().DIRECTORY_SEPARATOR.
            $this->http->getRequestFile().'View.phtml';

        // Le contrôleur a-t-il créé un formulaire?
        if(array_key_exists('_form', $this->viewData['variables']) == true)
        {
            if($this->viewData['variables']['_form'] instanceof Form)
            {
                // Oui, récupérez l'objet formulaire.

                /** @var Form $form */
                $form = $this->viewData['variables']['_form'];

                if($form->hasFormFields() == false)
                {
                    // Le formulaire n'a pas encore été construit.
                    $form->build();
                }

                // Fusionnez les champs de formulaire avec les variables de modèle (de template).
                $this->viewData['variables'] = array_merge
                (
                    $this->viewData['variables'],
                    $form->getFormFields()
                );

                // Ajoutez la variable de modèle message d'erreur du champ de formulaire.
                $this->viewData['variables']['errorMessage'] = $form->getErrorMessage();
            }

            unset($this->viewData['variables']['_form']);
        }

        // Injectez les variables du modèle (du template) de vue.
        extract($this->viewData['variables'], EXTR_OVERWRITE);

        if(array_key_exists('_raw_template', $this->viewData['variables']) == true)
        {
            unset($this->viewData['variables']['_raw_template']);

            // Chargez le modèle (le template) directement en ignorant la mise en page.
            /** @noinspection PhpIncludeInspection */
            include $this->viewData['template'];
        }
        else
        {
            // Chargez la mise en page qui charge ensuite le modèle (le template).
            include WWW_PATH.'/LayoutView.phtml';
        }
    }

    public function run()
    {
        // Déterminez la classe du contrôleur de page à exécuter.
        $controllerClass = $this->http->getRequestFile().'Controller';

        if(ctype_alnum($controllerClass) == false)
        {
            throw new ErrorException
            (
                "Nom de contrôleur invalide : <strong>$controllerClass</strong>"
            );
        }

        // Créez la page contrôleur.
        $controller = new $controllerClass();

        /*
         * Sélectionnez la méthode HTTP GET ou HTTP POST du contrôleur de page à exécuter.
         *  et les champs de données HTTP à donner à la méthode.
         */
        if($this->http->getRequestMethod() == 'GET')// récupère la méthode utilisée (GET ou POST)
        {
            $fields = $_GET;
            $method = 'httpGetMethod';
        }
        else
        {
            $fields = $_POST;
            $method = 'httpPostMethod';
        }

        if(method_exists($controller, $method) == false)
        {
            throw new ErrorException
            (
                'Une requête HTTP '.$this->http->getRequestMethod().' a été effectuée, '.
                "mais vous avez oublié la méthode <strong>$method</strong> dans le contrôleur ".
                '<strong>'.get_class($controller).'</strong>'
            );
        }

        //si c'est une requete ajax, on retourne une réponse json
        if(isset($_REQUEST['isAjax']) && $_REQUEST['isAjax'] == true){
            $response = $controller->$method($this->http, $fields);
            $this->http->sendJsonResponse($response);
        }

        // Exécutez la méthode du contrôleur de page et fusionnez toutes les variables de vue des contrôleurs.
        $this->viewData['variables'] = array_merge
        (
            $this->viewData['variables'],
            (array) $controller->$method($this->http, $fields)
        );
    }
}