<?php session_start(); 

//Vérification des autorisations de l'utilisateur et des variables de session requises pour l'affichage de cette page:
if (isset($_SESSION['id']) AND $_SESSION['systeme'] = "oressource" AND (strpos($_SESSION['niveau'], 'v'.$_GET['numero']) !== false))
      {include "tete.php";?>


<div class="panel-body">
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
      <fieldset>
      <legend>
             <?php 
          // on determine le numero de la vente
        try
            {
            // On se connecte à MySQL 
            include('../moteur/dbconfig.php');
            }
            catch(Exception $e)
            {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            }
 
         $req = $bdd->prepare("SELECT max(id) FROM ventes WHERE id_point_vente = :id ");
            $req->execute(array('id' => $_GET['numero']));
 
           // On affiche chaque entree une à une
           while ($donnees = $req->fetch())
           {
            $numero_vente = $donnees['max(id)'] + 1;
           }
              $req->closeCursor(); // Termine le traitement de la requête
            //on affiche le nom du point de vente
            try
            {
            // On se connecte à MySQL 
            include('../moteur/dbconfig.php');
            }
            catch(Exception $e)
            {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            }
 
            // Si tout va bien, on peut continuer
 
            // On recupère tout le contenu de la table point de collecte
          
            $req = $bdd->prepare("SELECT * FROM points_vente WHERE id = :id ");
            $req->execute(array('id' => $_GET['numero']));
 
           // On affiche chaque entree une à une
           while ($donnees = $req->fetch())
           {
            echo$donnees['nom'];
            $nom_pv = $donnees['nom'];
            $adresse_pv = $donnees['adresse'];
           }
              $req->closeCursor(); // Termine le traitement de la requête
        ?>
      </legend>   
      </fieldset>     
    <div class="row">
   	<br>
      <div class="col-md-2 col-md-offset-2" style="width: 330px;" >
     

       <div class="panel panel-danger">
        <div class="panel-heading">
    <label class="panel-title">Remboursement:</label>
    <span class ="badge" id="recaptotal"  style="float:right;">0€
    </span>
  </div>
  <div class="panel-body">
     
<form action="../moteur/remboursement_post.php" id="formulaire" method="post">
<ul id="liste" class="list-group">
   <li class="list-group-item">Réference: <?php echo $_GET['numero']?>#<?php echo $numero_vente?>, date: <?php echo date("d-m-Y") ?><br><?php echo $nom_pv;?><br><?php echo $adresse_pv;?>,<br>siret: <?php echo$_SESSION['siret'];?></li>
  
</ul>
 <ul class="list-group" id="total">
</ul>
<input type="text" class="form-control" placeholder="commentaire" id="comm" name="comm"><br>

<br>
<input type="hidden"  id="nlignes" name="nlignes">
<input type="hidden"  id="narticles" name="narticles">
<input type="hidden"  id="ptot" name="ptot">

<input type="hidden" name ="id_point_vente" id="id_point_vente" value="<?php echo $_GET['numero']?>">
    </form>
 <ul id="boutons" class="list-group">
        <button class="btn btn-danger btn-lg" onclick="encaisse();">Rembourser!</button>
        <button class="btn btn-danger btn-lg" type="button"  align="center"><span class="glyphicon glyphicon-print"></span></button>
        <button class="btn btn-warning btn-lg" onClick="javascript:window.location.reload()"><span class="glyphicon glyphicon-refresh"></button>
  </ul>


      </div>
      </div>
      </div>  
      
   
    <div class="col-md-3" style="width: 220px;">
 
      <div class="panel panel-danger">
        <div class="panel-heading">
    <h3 class="panel-title"id="nom_objet"><label>Objet:</label></h3>
  </div>
  <div class="panel-body"> 
      Quantité: <input type="text" class="form-control" placeholder="Quantité" id="quantite" name="quantite" onfocus="fokus(this)" > Prix unitaire: <input type="text" class="form-control" placeholder="€" id="prix" name="prix" onfocus="fokus(this)">
<input type="hidden"  id="id_type_objet" name="id_type_objet">
<input type="hidden"  id="id_objet" name="id_objet">   
<input type="hidden"  id="nom_objet0" name="nom_objet0">   


      <br>
     

    <button type="button" class="btn btn-default btn-lg" onclick="ajout();">
    Ajouter
    </button>


    <div class="col-md-3" style="width: 200px;">
    <div class="row">
    
    </div>
    <br>
    <div class="row">
        <button class="btn btn-default btn-lg" value="1" onclick="often(this);" style="margin-top:8px;">1</button>
        <button class="btn btn-default btn-lg" value="2" onclick="often(this);" style="margin-left:8px; margin-top:8px;">2</button>
        <button class="btn btn-default btn-lg" value="3" onclick="often(this);" style="margin-left:8px; margin-top:8px;">3</button>
    </div>
    <div class="row">
        <button class="btn btn-default btn-lg" value="4" onclick="often(this);" style="margin-top:8px;">4</button>
        <button class="btn btn-default btn-lg" value="5" onclick="often(this);" style="margin-left:8px; margin-top:8px;">5</button>
        <button class="btn btn-default btn-lg" value="6" onclick="often(this);" style="margin-left:8px; margin-top:8px;">6</button>
    </div>
    <div class="row">
        <button class="btn btn-default btn-lg" value="7" onclick="often(this);" style="margin-top:8px;">7</button>
        <button class="btn btn-default btn-lg" value="8" onclick="often(this);" style="margin-left:8px; margin-top:8px;">8</button>
        <button class="btn btn-default btn-lg" value="9" onclick="often(this);" style="margin-left:8px; margin-top:8px;">9</button>
    </div>
    <div class="row">
        <button class="btn btn-default btn-lg" value="c" onclick="often(this);" style="margin-top:8px;">C</button>
        <button class="btn btn-default btn-lg" value="0" onclick="often(this);" style="margin-left:8px; margin-top:8px;">0</button>
        <button class="btn btn-default btn-lg" value="." onclick="often(this);" style="margin-left:8px; margin-top:8px;">,</button>
    </div>
    </div>


  </div>
  </div>



    </div>

 
<div class="col-md-3" >
<div class="panel panel-danger">
        <div class="panel-heading">
    <h3 class="panel-title"><label>Type d'objet:</label></h3>
  </div>
  <div class="panel-body"> 
      


            <?php 
            try
            {
            // On se connecte à MySQL
            include('../moteur/dbconfig.php');
            }
            catch(Exception $e)
            {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            }
            // On recupère tout le contenu de la table point de collecte
            $reponse = $bdd->query('SELECT * FROM type_dechets WHERE visible = "oui"');
 
           // On affiche chaque entree une à une
           while ($donnees = $reponse->fetch())
           {
           ?>
      <div class="btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="margin-left:8px; margin-top:16px;">
      <span class="badge" id="cool" style="background-color:<?php echo$donnees['couleur']?>"><?php echo$donnees['nom']?></span>
      </button>
      <ul class="dropdown-menu" role="menu">
      <li><a href="javascript:edite('<?php echo$donnees['nom']?>','0','<?php echo$donnees['id']?>','0')" ><?php echo$donnees['nom']?></a></li>
      <li class="divider"></li>


  <?php 
            try
            {
            // On se connecte à MySQL
            include('../moteur/dbconfig.php');
            }
            catch(Exception $e)
            {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
            }
             // On recupère tout le contenu de la table grille_objets
           $req = $bdd->prepare('SELECT * FROM grille_objets WHERE id_type_dechet = :id_type_dechet AND visible = "oui"   ');
           $req->execute(array('id_type_dechet' => $donnees['id']));
           $i = 1;
           // On affiche chaque entree une à une
           while ($donneesint = $req->fetch())
           {
           ?>
    <li><a href="javascript:edite('<?php echo$donneesint['nom']?>','<?php echo$donneesint['prix']?>','<?php echo$donnees['id']?>','<?php echo$donneesint['id']?>')"><?php echo$donneesint['nom']?></a></li>
    </li>
           <?php }
           $req->closeCursor(); // Termine le traitement de la requête
           ?> 
    </ul>
    </div>
   
                <?php }
                $reponse->closeCursor(); // Termine le traitement de la requête
                ?>
    </div> 



    </div>
    <br>
    <a href="ventes.php?numero=<?php echo $_GET['numero']?>&nom=<?php echo $_GET['nom']?>&adresse=<?php echo $_GET['adresse']?>"> 
    <button type="button"  class="btn btn-default pull-right" >
    Retour aux ventes
    </button>
    <a>
       <br><br>
     
    </div>
  </div>
    </div>
   
    <br>
            <?php include "pied.php" ; ?> 
<script type="text/javascript">

var what;

function fokus(that) {
what = that;
}


function often(that) {
if (isNaN(parseInt(document.getElementById('id_type_objet').value)) ) 
          { 
          }
          else{

if (what == null) {document.getElementById('quantite').value ="" ; what = document.getElementById('quantite');}
if (that.value == "c"){what.value = "";}
else{
what.value = what.value + that.value;
}

}

}

function ajout() {
     if (isNaN((parseFloat(document.getElementById('prix').value)*parseFloat(document.getElementById('quantite').value)).toFixed(2)) ) 
         {} 
          else
          {

         
if (isNaN(parseInt(document.getElementById('nlignes').value)) ) 
          { 
          document.getElementById('nlignes').value = 1;
          } 
          else
          {
          document.getElementById('nlignes').value=parseInt(document.getElementById('nlignes').value)+ 1; 
          }
if (isNaN(parseInt(document.getElementById('narticles').value)) ) 
          { 
          document.getElementById('narticles').value = document.getElementById('quantite').value;
          } 
          else
          {
          document.getElementById('narticles').value=parseInt(document.getElementById('narticles').value)+parseInt(document.getElementById('quantite').value); 
          }          
if (isNaN(parseInt(document.getElementById('ptot').value)) ) 
          { 
          document.getElementById('ptot').value = document.getElementById('prix').value*document.getElementById('quantite').value;
          } 
          else
          {
          document.getElementById('ptot').value=parseFloat(document.getElementById('ptot').value)+parseFloat(document.getElementById('prix').value*document.getElementById('quantite').value); 
          }          

             document.getElementById('liste').innerHTML += '<li class="list-group-item"><span class="badge">'+parseFloat(parseFloat(document.getElementById('prix').value)*parseFloat(document.getElementById('quantite').value)).toFixed(2)+'€'+'</span>'
             +document.getElementById('quantite').value+'*'+document.getElementById('nom_objet0').value
             +'<input type="hidden"  id="tid_type_objet'+parseInt(document.getElementById('nlignes').value)+'" name="tid_type_objet'+parseInt(document.getElementById('nlignes').value)+'"value="'+document.getElementById('id_type_objet').value+'">'
             +'<input type="hidden"  id="tid_objet'+parseInt(document.getElementById('nlignes').value)+'" name="tid_objet'+parseInt(document.getElementById('nlignes').value)+'"value="'+document.getElementById('id_objet').value+'">'
             +'<input type="hidden"  id="tquantite'+parseInt(document.getElementById('nlignes').value)+'" name="tquantite'+parseInt(document.getElementById('nlignes').value)+'"value="'+document.getElementById('quantite').value+'">'
             +'<input type="hidden"  id="tprix'+parseInt(document.getElementById('nlignes').value)+'" name="tprix'+parseInt(document.getElementById('nlignes').value)+'"value="'+document.getElementById('prix').value+'"></li>';                                               
               document.getElementById('total').innerHTML = '<li class="list-group-item">Soit : '+document.getElementById('narticles').value+' article(s) pour : <span class="badge" style="float:right;">'+parseFloat(document.getElementById('ptot').value).toFixed(2)+'€</span></li>';
               document.getElementById('recaptotal').innerHTML = parseFloat(document.getElementById('ptot').value).toFixed(2)+'€';
               document.getElementById('nom_objet').innerHTML = "<label>Objet:</label>";
               document.getElementById('quantite').value = "";
               document.getElementById('prix').value = "";
               document.getElementById('id_type_objet').value = "";
               document.getElementById('id_objet').value = "";
               document.getElementById('nom_objet0').value = "";
               }
                  }
function edite(nom,prix,id_type_objet,id_objet) {
    document.getElementById('nom_objet').innerHTML = "<label>"+nom+"</label>";
    document.getElementById('quantite').value = "1";
    document.getElementById('prix').value = parseFloat(prix);
    document.getElementById('id_type_objet').value = parseFloat(id_type_objet);
    document.getElementById('id_objet').value = parseFloat(id_objet);
    document.getElementById('nom_objet0').value = nom;

}
function encaisse() {
  if (parseInt(document.getElementById('nlignes').value) >= 1) 
          { 
            
          document.getElementById("formulaire").submit();
          }
                    }
</script>

            <?php 
} 
else
      { 
        header('Location:../moteur/destroy.php');
      }
?>
