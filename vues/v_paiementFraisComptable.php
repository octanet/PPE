<link rel="stylesheet" href="./styles/style.css">


<h1 class="title">PAGE DE SUIVI DES PAIEMENTS</h1>


<?php if($_SESSION['idUser'] === 0  && $paiement !== 1 || !isset($_POST['date']) && $paiement !== 1 ):?>


    <form action="" method="post" class="form-group" style="margin-top: 60px;"> 
        <select name="nom" class="form-control" style="margin: 20px 0;" onChange="this.form.submit();">
        <?php if(isset($_POST['nom'])){?>
            <option value="0"><?php  print_r($tab[$id]['prenom'] . ' ' .$tab[$id]['nom'])  ?></option>
        <?php  } else {?>
            <option value="0">Choisir un visiteur</option>
        <?php }?>    
            <?php  foreach( $tab as $tob ){?> 
            <option  <?php  if($tob['idetat'] ==  'VA'): ?>style="background-color: #FFB0B0" <?php endif ?>
                value="<?= $tob['id'] ?>"> <?= str_replace("1", "",print_r($tob['prenom']. ' ' . $tob['nom']))?> </option>
            <?php }?>
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


    <form action="" method="post">
    <input type="submit"  name="back" class="btn btn-primary submit" value="Retour choix des noms">
    </form>


<?php  endif ?>
<div class="div">

<?php  if($paiement == 1): ?>
    <h2 style="color:green">VALIDÉ : Le Paiement sera effectué sous peu !</h2>
<?php  elseif($paiement == 2): ?>
    <h2 style="color:red" >Un probleme est survenu</h2>
<?php  endif ?>

<?php if(isset($id, $_POST['date'])): ?>
<h2 class="center" style="margin-bottom:80px">STATUT DU PAIEMENT POUR <?= str_replace("1", "",print_r(strtoupper($tab[$id]['nom']. ' ' . $tab[$id]['prenom'])))?> :</h2>
    <?php  if($tab[$id]['idetat'] ==  'VA'): ?>

        <div class="container">
      <h1>FRAIS DU MOIS</h1>
      <table class="table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Forfait Etape</th>
            <th>Frais Kimométrique</th>
            <th>Nuité</th>
            <th>Repas Midi</th>
            <th>Total des Frais</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            
            <td><?php str_replace("1", "",print_r(strtoupper($tab[$id]['nom']. ' ' . $tab[$id]['prenom'])))?></td>
            <td><?php echo $totoETP ?>€</td>
            <td><?php echo $totoKM ?>€</td>
            <td><?php echo $totoNUI ?>€</td>
            <td><?php echo $totoREP ?>€</td>
            <td><?php print_r($total['total'])  ?>€</td>
          </tr>

        </tbody>
      </table>
    </div>



        <form action="" class="form-group" method="post">
        <h3>Fiche de frais Validée, le paiement reste à effectuer =>
        <input type="submit"  name="payment" style="float:right"  class="btn btn-primary submit" value="Mettre en paiement">
        </form></h3>

    <?php  elseif($tab[$id]['idetat'] ==  'RB'): ?>
        <h2 style="color:green" >Remboursée !</h2>



    <?php  endif ?>
<?php  endif ?>
</div>

</body>
</html>