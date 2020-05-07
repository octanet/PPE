
<?php 
$paiement = 0;
$id = 0;
$getId  = $pdo->getIDSuiviPaiementCompta();



// Ajout variable id
if(isset($_SESSION['idUser'])){
    $id = $_SESSION['idUser'];
}else{
    $_SESSION['idUser'] = 0;
}




/**
 * Création tableaux id, nom prenom des visiteur pour selection déroulante
 * 
 */
for($i=0; $i<sizeof($getId); $i++)
{
    $visi[$i] = $pdo->getNomVisiteurCompta($getId[$i]['idvisiteur']) ;
    $max = sizeof($visi);
    foreach($visi[$i] as $vti ){
        $tab [$vti['id']]= [
            'id' =>$vti['id'],
            'nom' => $vti['nom'],
            'prenom' => $vti['prenom'] ,
            'idetat' => $getId[$i]['idetat']
        ];       
    }
}
/**
 * implémentation $id
 */
if(isset($_POST['nom'])){
    $_SESSION['idUser'] = $_POST['nom'];
    $id = $_SESSION['idUser'];
    $moisVisi = $pdo->getLesMoisDisponiblesva($id);
}


/**
 * Bouton de retour selection visiteur
 * remise à zero des variables
 */
if(isset($_POST['back'])){
    $paiement = 0;
    $_SESSION['idUser'] = 0;
    $id = 0;
}

/**
 * Change le statut de idetat de la fiche de frais du visiteur 
 */
if(isset($_POST['payment'])){
    try {
        $pdo->changeidEtatVisiteur($_SESSION['idUser']);
        $paiement = 1;
        $_SESSION['idUser'] = 0;
        $id = 0;
    } catch(Exception $e) {
        $paiement = 2;
    }
}

/**
 * Détail du coût du paoement de la fiche de frais
 */

if(isset($id, $_POST['date']) && $id !== 0){
    $info = $pdo->getLesFraisForfait($id, $_POST['date']);
    $montant = $pdo->getMontantFrais();

    if(!empty($info)){
        $totoETP = (!empty($info[0]['quantite'])) ? $info[0]['quantite'] * ($montant[0]['montant']) : 0;
        $totoKM = (!empty($info[1]['quantite'])) ? $info[1]['quantite'] * ($montant[1]['montant']) : 0;
        $totoNUI = (!empty($info[2]['quantite'])) ? $info[2]['quantite'] *  ($montant[2]['montant']) : 0;
        $totoREP = (!empty($info[3]['quantite'])) ?  $info[3]['quantite'] * ($montant[3]['montant']) : 0 ;
    $total =  $pdo->getMontantValide($id, $_POST['date']);
    }
}




include './vues/v_paiementFraisComptable.php';


