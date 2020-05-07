 
<link rel="stylesheet" href="./styles/style.css">
<link rel="stylesheet" href="./styles/bootstrap/bootstrap-grid.css">


<h1 class="title">PAGE DE VALIDATION DE FICHES DE FRAIS</h1>

<?php if($validationSuccess == true):?>
    <h2 class="successR"><span class="glyphicon glyphicon-ok" style="padding:5px;"></span>Validation réussi !!</h2>
<?php endif?>

<?php if($hideSelectionElement === 0):?>
    <form action="" method="post" class="form-group" style="margin-top: 60px;"> 
        <select name="nom" class="form-control" style="margin: 20px 0;" onChange="this.form.submit();">
        <?php if(isset($_POST['nom'])):?>
            <option value="0"><?php  print_r($tab[$id]['prenom'] . ' ' .$tab[$id]['nom'])  ?></option>
        <?php else:?>
            <option value="0">Choisir un visiteur</option>
        <?php endif;?>    
            <?php  foreach( $tab as $tob ):?> 
            <option value="<?= $tob['id'] ?>"> <?= str_replace("1", "",print_r($tob['prenom']. ' ' . $tob['nom']))?> </option>
            <?php endforeach;?>
        </select>
    </form>

    <?php if(!empty($moisVisi)):?>
        <form action="" method="post" class="form-group" > 
        <select name="date" class="form-control" style="margin: 20px 0;" >
            <option value="0">Choisir une Date</option>
            <?php  foreach($moisVisi as $mois):?> 
            <option value="<?= $mois['mois'] ?>"> <?php print_r($mois['numMois'] . ' / ' . $mois['numAnnee'])?> </option>
            <?php endforeach?>
        </select>
        <button class="btn btn-primary submit" >Voir Fiche de frais</button>
    </form>
            <?php else:?>
        <h3>Pas de dates disponible pour ce visiteur.</h3>
            <?php endif; ?>
<?php else:?>       
    <form action="" method="post" class="form-group">     
    <input type="submit" name="retourSelection"  class="btn btn-primary" value="Retour Selection">
    </form>
<?php endif;?>


<?php if(isset($date, $_SESSION['date']) && $date !== 0) { ?>

<h3>Elements fiche de frais de <?php  print_r($tab[$_SESSION['id']]['nom']); echo " "; print_r($tab[$_SESSION['id']]['prenom'])  ?> pour le mois <?php echo $_SESSION['date'] ?>  </h3>

<h2 class="uTitle">ELEMENTS FORFAITISÉS:</h2>


<form action="" method="post" name="formulaireModif" class="form-group">
    <div class="form-group">
        <label>Forfait Étape</label>
        <input type="text" class="form-control" name="ETP" value="<?php print_r($info[0]['quantite']); ?>"> <span> soit  <?php echo $totoETP?> €</span>
    </div>
    <div class="form-group">
        <label>Frais Kilométrique</label>
        <input type="text" class="form-control" name="KM" value="<?php print_r($info[1]['quantite']) ?>"><span>soit  <?php echo $totoKM?> €</span>
    </div>
    <div class="form-group">
        <label>Nuitée Hôtel</label>
        <input type="text" class="form-control" name="NUI" value="<?php print_r($info[2]['quantite']) ?>"><span>soit  <?php echo $totoNUI?> €</span>
    </div>
    <div class="form-group">
        <label>Repas Restaurant</label>
        <input type="text" class="form-control" name="REP" value="<?php print_r($info[3]['quantite']) ?>"> <span>soit  <?php echo $totoREP?> €</span>   
    </div>
    <input type="submit" class="btn btn-primary" value="Enregistrer les modifications">
    <button class="btn btn-danger">Réinitiamiser</button>
    <?php if ($messageRegiSucces == 1):?>
        <p class="successR"><span class="glyphicon glyphicon-ok" style="padding:5px;"></span>Enregistrement réussi !!</p>
    <?php endif;?> 

</form>

<h2 class="uTitle">ELEMENTS NON-FORFAITISÉS:</h2>
  <?php if(isset($infoHF) && !empty($infoHF)):?>
<table class="table">
  <thead class="thead-light">
    <tr>
    <th >Descriptifs des élements non-forfaitisés</th>
    </tr>
    </thead>
    <thead class="thead-dark">
    <tr>
      <th scope="col">Libellé</th>
      <th scope="col">Date</th>
      <th scope="col">Montant</th>
      <th scope="col"></th>
    </tr>
    </thead>

  <tbody>
    <?php for($i=0; $i<sizeof($infoHF); $i++) :?>
    <tr>
    <form action="" method="post" class="form-group">
        <input type="text" name=positionTabHF value="<?= $i ?>" style="display:none">
      <td><input type="text" class="form-control" name="libelleHF" value="<?php print_r($infoHF[$i]['libelle']) ?>"></td>
      <td><input type="text" class="form-control" name="dateHF" value="<?php print_r($infoHF[$i]['date']) ?>"></td>
      <td><input type="text" class="form-control" name="montantHF" value="<?php print_r($infoHF[$i]['montant']) ?>"></td>
      <td>   
            <div class="line"> 
                <input type="submit" class="btn btn-primary" value="Enregistrer les modifications">
                <input class="btn btn-danger" value="Réinitialiser">
            </div>
      </td>
    </form>
    </tr>
    <?php endfor ?>
    <h4>Nombre de justificatif(s) : <?php echo $nbJustificatif;?></h4>
    <?php else: ?>
        <h5>Pas de fiche de frais non-forfaitisé pour ce visiteur ce mois-ci</h5>
    <?php endif ?>
    
    </tbody>
</table>
<?php if($total !== 0): ?>
    <h2>TOTAL DES FRAIS FORFAITISÉ = <?php echo $total; ?> €</h2>
<?php endif ?>   

<div class="btnValid">
<form action="" method="post" class="form-group">

    <input type="submit" name="validationFicheFrais" class="btn btn-success btn-block" value="VALIDER LA FICHE DE FRAIS">
</form>
    <button class="btn btn-danger btn-block">REFUSER LE FICHE DE FRAIS</button><br>
</div>


    <?php  } ?>
