<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include '../utils/bddConnect.php';

// echo "test";
// $objDb = new DbConnect;
// $conn = $objDb->connect();

$connexion = new BddConnect();
$bdd = $connexion->connexion();



$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {

    case "GET":

        $req = $bdd->prepare($sql);
        $req->execute();
        $users = $req->fetch(PDO::FETCH_ASSOC);
        echo json_encode($users);
        break;

        // $path = explode('/', $_SERVER['REQUEST_URI']);
        // if (isset($path[3]) && is_numeric($path[3])) {
        //     $sql .= " WHERE id = :id";
        //     $req = $bdd->prepare($sql);
        //     $req->bindParam(':id', $path[3]);
        //     $req->execute();
        //     $users = $req->fetch(PDO::FETCH_ASSOC);
        // } else {
        //     $req = $bdd->prepare($sql);
        //     $req->execute();
        //     $users = $req->fetchAll(PDO::FETCH_ASSOC);
        // }

        // echo json_encode($users);
        // break;


    case "POST":
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];

        $user = json_decode(file_get_contents('php://input'));

        //préparation de la requête
        $sql = "INSERT INTO reactusers (name,mobile,email) VALUES('$name','$mobile','$email');";
        $req = $bdd->prepare($sql);

        // affectation des variables
        $req->bindParam(1, $user->name, PDO::PARAM_STR);
        $req->bindParam(2, $user->email, PDO::PARAM_STR);
        $req->bindParam(3, $user->mobile, PDO::PARAM_STR);

        //exécution de la requête

        if ($req->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
            // header('http: ')
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }
        echo json_encode($response);
        break;

    case "PUT":
        $user = json_decode(file_get_contents('php://input'));
        $sql = "UPDATE users SET name= :name, email =:email, mobile =:mobile, updated_at =:updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $updated_at = date('Y-m-d');
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':name', $user->name);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':mobile', $user->mobile);
        $stmt->bindParam(':updated_at', $updated_at);

        if ($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record updated successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to update record.'];
        }
        echo json_encode($response);
        break;

    case "DELETE":
        $sql = "DELETE FROM users WHERE id = :id";
        $path = explode('/', $_SERVER['REQUEST_URI']);

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $path[3]);

        if ($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record deleted successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to delete record.'];
        }
        echo json_encode($response);
        break;
}
