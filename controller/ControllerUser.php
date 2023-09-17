<?php


$message = "message d'information";

//tester si le formulaire est submit
if(isset($_POST['submit'])){
    //tester si les champs sont remplis
    if(!empty($_POST['name']) AND !empty($_POST['email']) AND
    !empty($_POST['mobile']))
    {
        //nettoyage nom via function
        $name = Fonction::cleandata($_POST['nom_utilisateur']);
        //stocker le contenu du formulaire
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        // $image = $_POST['image_utilisateur'];
        // $password = $_POST['password_utilisateur'];

        echo ('AddUser OK');
    }
    else{
        $message = 'Erreur formulaire.'; 
    }

}
