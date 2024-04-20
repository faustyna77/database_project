<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Zebrać wartości z pól formularza
    $data_wylotu = $_POST['data_wylotu'];
    $ID_numer_lotu= $_POST['ID_numer_lotu'];
    $ID_samolotu = $_POST['ID_samolotu'];
   

    // Połączenie z bazą danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rezerwacje";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully. <br>";

        if (isset($_POST["create"])) {
            // Operacja CREATE
            $stmt = $conn->prepare("INSERT INTO lot (data_wylotu, ID_numer_lotu, ID_samolotu) VALUES (:data_wylotu, :ID_numer_lotu, :ID_samolotu)");
            $stmt->bindParam(':data_wylotu', $data_wylotu);
            $stmt->bindParam(':ID_numer_lotu', $ID_numer_lotu);
            $stmt->bindParam(':ID_samolotu', $ID_samolotu);
            
            $stmt->execute();
            echo "Record created successfully.";
        } elseif (isset($_POST["read"])) {
            // Operacja READ
            $stmt = $conn->query("SELECT * FROM lot");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "data_wylotu: {$row['data_wylotu']} - Numer lotu: {$row['ID_numer_lotu']} - id samolot: {$row['ID_samolotu']}<br>";
                
            }
        } elseif (isset($_POST["update"])) {
            // Operacja UPDATE
            $stmt = $conn->prepare("UPDATE lot SET data_wylotu = :data_wylotu, ID_numer_lotu = :ID_numer_lotu,  ID_samolotu = :ID_samolotu WHERE ID_numer_lotu = :ID_numer_lotu");
            $stmt->bindParam(':data_wylotu', $data_wylotu);
            $stmt->bindParam(':ID_numer_lotu', $ID_numer_lotu);
            $stmt->bindParam(':ID_samolotu', $ID_samolotu);
          
            $stmt->execute();
            echo "Record updated successfully.";
        } elseif (isset($_POST["delete"])) {
            // Operacja DELETE
            $stmt = $conn->prepare("DELETE FROM lot WHERE ID_numer_lotu = :ID_numer_lotu");
            $stmt->bindParam(':ID_numer_lotu', $ID_numer_lotu);
            $stmt->execute();
            echo "Record deleted successfully.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
