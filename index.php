<?php
/**
 * Index du projet GSB
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

require_once 'includes/fct.inc.php';
require_once 'includes/class.pdogsb.inc.php';
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
if($estConnecte){
    $statut = $_SESSION['statut'];
}else{
    $statut = 0;
}


if($statut == 'Comptable'){
    require 'vues/v_enteteComptable.php';
}else{
    require 'vues/v_entete.php';
}
    $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);

    if ($uc && !$estConnecte) {
        $uc = 'connexion';
    } else if(empty($uc)) {
        $uc = 'accueil';
    }

    if($statut == 'Comptable' && $uc == 'accueil'){
        $uc = 'accueilComptable';
    }


    
    switch ($uc) {
    case 'connexion':
        include 'controleurs/c_connexion.php';
        break;
    case 'accueil':
        include 'controleurs/c_accueil.php';
        break;
    case 'accueilComptable':
        include 'controleurs/c_accueilComptable.php';
        break;
    case 'paiementFrais':
        include 'controleurs/c_paiementFraisComptable.php';
        break;
    case 'validationFrais':
        include 'controleurs/c_gestionFraisComptable.php';
        break;
    case 'gererFrais':
        include 'controleurs/c_gererFrais.php';
        break;
    case 'etatFrais':
        include 'controleurs/c_etatFrais.php';
        break;
    case 'deconnexion':
        include 'controleurs/c_deconnexion.php';
        break;
    }
    
    


require 'vues/v_pied.php';
