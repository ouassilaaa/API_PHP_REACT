<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include './utils/bddConnect.php';


//nouvel object de connexion à la BDD
$connexion = new BddConnect();
$bdd = $connexion->connexion();

//autoriser l'accès page
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {

    case "GET":

        $req = $bdd->prepare($sql);
        $req->execute();
        $users = $req->fetch(PDO::FETCH_ASSOC);
        echo json_encode($users);
        break;


    case "POST":
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $note = $_POST['note'];

        $user = json_decode(file_get_contents('php://input'));

        //préparation de la requête
        $sql = "INSERT INTO users (name,surname, mobile,email,note) VALUES('$name','$surname','$mobile','$email', '$note');";
        $req = $bdd->prepare($sql);


        // affectation des variables
        $req->bindParam(1, $user->name, PDO::PARAM_STR);
        $req->bindParam(2, $user->surname, PDO::PARAM_STR);
        $req->bindParam(3, $user->email, PDO::PARAM_STR);
        $req->bindParam(4, $user->mobile, PDO::PARAM_STR);
        $req->bindParam(5, $user->note, PDO::PARAM_STR);

        //exécution de la requête
        if ($req->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }
        echo json_encode($response);

        //nettoyage des inputs
        function cleanInput($input)
        {
            return htmlspecialchars(strip_tags(trim($input)));
        }
        break;

    case "UPDATE":
        $user = json_decode(file_get_contents('php://input'));
        $sql = "UPDATE users SET name= :name, email =:email, mobile =:mobile, updated_at =:updated_at WHERE id = :id";
        $req = $bdd->prepare($sql);
        $updated_at = date('Y-m-d');

        // affectation des variables
        $req->bindParam(1, $user->name, PDO::PARAM_STR);
        $req->bindParam(2, $user->surname, PDO::PARAM_STR);
        $req->bindParam(3, $user->email, PDO::PARAM_STR);
        $req->bindParam(4, $user->mobile, PDO::PARAM_STR);
        $req->bindParam(5, $user->note, PDO::PARAM_STR);

        //exécution de la requête
        if ($req->execute()) {
            $response = ['status' => 1, 'message' => 'Record updated successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to update record.'];
        }
        echo json_encode($response);

        function cleanInput($input)
        {
            return htmlspecialchars(strip_tags(trim($input)));
        }
        break;

    case "DELETE":
        $sql = "DELETE FROM users WHERE id = :id";
        $path = explode('/', $_SERVER['REQUEST_URI']);

        $req = $bdd->prepare($sql);
        $req->bindParam(':id', $path[3]);

        if ($req->execute()) {
            $response = ['status' => 1, 'message' => 'Record deleted successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to delete record.'];
        }
        echo json_encode($response);
        break;
}
