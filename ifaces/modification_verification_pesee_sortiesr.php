<?php session_start(); 

//Vérification des autorisations de l'utilisateur et des variables de session requises pour l'affichage de cette page:
  if (isset($_SESSION['id']) AND $_SESSION['systeme'] = "oressource" AND (strpos($_SESSION['niveau'], 'h') !== false))
      {  include "tete.php" ?>
   <div class="container">
        <h1>Modifier la pesée n° <?php echo $_POST['id']?> appartenant à la sortie <?php echo $_POST['nsortie']?> </h1> 
        <?php
if ($_GET['err'] == "") // SI on a pas de message d'erreur
{
   echo'';
}

else // SINON 
{
  echo'<div class="alert alert-danger">'.$_GET['err'].'</div>';
}


  if ($_GET['msg'] == "") // SI on a pas de message positif
{
   echo '';
}

else // SINON (la variable ne contient ni Oui ni Non, on ne peut pas agir)
{
  echo'<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$_GET['msg'].'</div>';
}
?>
 <div class="panel-body">




<br>


<div class="row">
   
        	<form action="../moteur/modification_verification_pesee_sortiesr_post.php" method="post">
            <input type="hidden" name ="nsortie" id="nsortie" value="<?php echo $_POST['nsortie']?>">
            <input type="hidden" name ="id" id="id" value="<?php echo $_POST['id']?>">
            <input type="hidden" name ="masse" id="masse" value="<?php echo $_POST['masse']?>">
  <input type="hidden" name ="date1" id="date1" value="<?php echo $_POST['date1']?>">
  <input type="hidden" name ="date2" id="date2" value="<?php echo $_POST['date2']?>">
    <input type="hidden" name ="npoint" id="npoint" value="<?php echo $_POST['npoint']?>">




<div class="col-md-3">

    <label for="masse">Masse:</label>
<br><input type="text"       value ="<?php echo $_POST['masse']?>" name="masse" id="masse" class="form-control " required >
  <br>
<button name="creer" class="btn btn-warning">Modifier</button>
 </div>
</form>
</div>



</div>

      





  </div><!-- /.container -->
<?php include "pied.php"; 
}
    else
{
    header('Location: ../moteur/destroy.php') ;
}
?>
       
      
