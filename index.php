<?php
//config
include('includes/config.inc.php');

// connection base mysql
include('includes/database.inc.php');

//demarrage session
session_start();


function render($view){
    include('views/layout/header.php');
    include('views/'. $view);
    include('views/layout/footer.php');
}


//----------------------------------------------------------------------------------------------------------------------
/* LOGIQUE DU CONTROLLER */

/* valeurs par defaut dans la session */
// liste des messages
$_SESSION['messages'] = [];
// données pour formulaire
$_SESSION['postdata'] = [];
// liste des erreurs
$_SESSION['errors'] = [];

render('layout/home.php'); //DONE//

//render('contact/form.php'); //DONE//
//render('contact/merci.php'); //DONE//

//render('cours/form.php'); //DONE//
//render('cours/cours.php'); //DONE//
//render('cours/list.php'); //DONE//

//render('devis/commande.php');
//render('devis/form.php');
//render('devis/list.php');





