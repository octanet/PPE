<?php
/**
 * Selctionner un visiteur et un mois 
 */
if(!isset($id)){
    $id = 0;
}

$messageRegiSucces = 0;
$validationSuccess = false;



$hideSelectionElement = 0;
//Bouton retour menu
if(isset($_POST['retourSelection'])){
    $hideSelectionElement = 0;
    $_SESSION['id'] = 0;
    $_SESSION['date'] = 0;
    $date = 0;
}

if(isset($_POST['nom'])){
    $_SESSION['id'] = $_POST['nom'];
    $moisVisi = $pdo->getLesMoisDisponiblescl($_POST['nom']);
}
if(isset($_POST['date'])){
    $_SESSION['date'] = $_POST['date'];
    $date = $_POST['date'];
}

if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}
    
if(isset($_SESSION['date'])){
    $date = $_SESSION['date'];
}


if(isset($_POST['date']) && $_POST['date'] != "0") {
    $hideSelectionElement = 1;
}

//Enregistrement des nom et prénoms
$visi = $pdo->getVisiteurCompta() ;
$max = sizeof($visi);
    foreach($visi as $vti ){
        $tab [$vti['id']]= [
            'id' =>$vti['id'],
            'nom' => $vti['nom'],
            'prenom' => $vti['prenom'] 
        ];    
    }

/***
 * Elements formulaire et modifications : 
 */
//selectionner les infos fraisForfait clients: 
if(isset($date) && $date !== 0){
    $info = $pdo->getLesFraisForfait($id, $date);
    $montant = $pdo->getMontantFrais();

//Calcul des frais selon nb 

$totoETP = ($info[0]['quantite']) * ($montant[0]['montant']);
$totoKM = ($info[1]['quantite']) * ($montant[1]['montant']);
$totoNUI = ($info[2]['quantite']) * ($montant[2]['montant']);
$totoREP = ($info[3]['quantite']) * ($montant[3]['montant']);
$total = $totoREP + $totoNUI + $totoKM + $totoETP ;
}
//Enregistrement des infos modifiées
if(isset($_POST['ETP'])){
    $formulaireModif =  [
        'ETP' => $_POST['ETP'], 
        'KM' => $_POST['KM'],
        'NUI' => $_POST['NUI'],
        'REP' => $_POST['REP']
    ];
    $pdo->majFraisForfait($id, $date, $formulaireModif);
    $hideSelectionElement = 1;
    $messageRegiSucces = 1;
    echo $id;
    echo $date;
    echo $hideSelectionElement;
}


//Enregistrement des infos Hors Forfaits modifiées 



// get nb Justificatifs
if(isset($date)){
$nbJustificatif = $pdo->getNbjustificatifs($id, $date);
}
// selection des infos Hors Forfait
if(isset($date)){
    $infoHF = $pdo->getLesFraisHorsForfait($id, $date);
}

//Enregistrement des infos modifiés
if(isset($_POST['libelleHF'])){
    $p = $_POST['positionTabHF'];
    $pdo->modifierFraisHorsForfait($infoHF[$p]['idvisiteur'],$infoHF[$p]['mois'],$_POST['libelleHF'],$_POST['dateHF'],$_POST['montantHF']);
}
// reselection des infos Hors Forfait pour actualisation de l'affichage
if(isset($date)){
    $infoHF = $pdo->getLesFraisHorsForfait($id, $date);
}



//validation Fiche de frais
if(isset($_POST['validationFicheFrais'])){
    $pdo->updateMontantValide($total, $id, $date);
    $pdo->validationFicheFrais($id, $date);
    $hideSelectionElement = 0;
    $moisVisi = null;
    $date = 0;
    $id = 0;
    $validationSuccess = 1;
    $_SESSION['date'] = 0;
}




include './vues/v_comptable.php';
    
?>