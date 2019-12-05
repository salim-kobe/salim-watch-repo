<?php

// Enregistrez le répertoire racine du projet en tant que constante globale.
define('ROOT_PATH', __DIR__);

/*
 * Créez une constante globale utilisée pour obtenir le chemin du système de fichiers vers
 * répertoire de configuration de l'application.
 */
define('CFG_PATH', realpath(ROOT_PATH.'/application/config'));


/*
 * Créez une constante globale utilisée pour obtenir le chemin du système de fichiers vers
 * répertoire racine Web public de l'application.
 *
 * Peut être utilisé pour gérer les téléchargements de fichiers par exemple.
 */
define('WWW_PATH', realpath(ROOT_PATH.'/application/www'));



require_once 'library/Configuration.class.php';
require_once 'library/Database.class.php';
require_once 'library/FlashBag.class.php';
require_once 'library/Form.class.php';
require_once 'library/FrontController.class.php';
require_once 'library/MicroKernel.class.php';
require_once 'library/Http.class.php';
require_once 'library/InterceptingFilter.interface.php';




$microKernel = new MicroKernel();
$microKernel->bootstrap()->run(new FrontController());

