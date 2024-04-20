<?php

$db = new PDO("mysql:host=localhost; dbname=rezerwacje; charset=utf8mb4", "root", "");

$db->exec("CREATE TABLE IF NOT EXISTS samolot (
    ID_samolotu INT AUTO_INCREMENT PRIMARY KEY, 
    producent VARCHAR(50) NOT NULL, 
    typ VARCHAR(50) NOT NULL
)");

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "GET":
        $stmt = $db->query("SELECT * FROM samolot");
        $samolot = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($samolot);
        break;

    case "POST":
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $db->prepare("INSERT INTO samolot (producent, typ) VALUES (:producent, :typ)");
        $stmt->execute($input);
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $delete_vars);
        $ID_samolotu = $delete_vars["ID_samolotu"];
        $stmt = $db->prepare("DELETE FROM samolot WHERE ID_samolotu = :ID_samolotu");
        $stmt->execute(["ID_samolotu" => $ID_samolotu]);
        break;
}

?>
