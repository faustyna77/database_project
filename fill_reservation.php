<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Zebrać wartości z pól formularza
    $ID_Rezerwacji = $_POST['ID_Rezerwacji'];
    $numer_siedzenia = $_POST['numer_siedzenia'];
    $bagaz = $_POST['bagaz'];
    $ID_Pasazer = $_POST['ID_Pasazer'];
    $ID_adres = $_POST['ID_adres'];
    $ID_numer_lotu = $_POST['ID_numer_lotu'];
    $ID_rezerwacji_status = $_POST['ID_rezerwacji_status'];

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
            $stmt = $conn->prepare("INSERT INTO rezerwacje (bagaz, ID_adres,ID_numer_lotu, ID_Pasazer, ID_Rezerwacji, ID_rezerwacji_status,numer_siedzenia) VALUES (:bagaz, :ID_adres,:ID_numer_lotu, :ID_Pasazer, :ID_Rezerwacji, :ID_rezerwacji_status,:numer_siedzenia)");
            $stmt->bindParam(':bagaz', $bagaz);
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->bindParam(':ID_numer_lotu', $ID_numer_lotu);
            $stmt->bindParam(':ID_Pasazer', $ID_Pasazer);
            $stmt->bindParam(':ID_Rezerwacji',$ID_Rezerwacji);
            $stmt->bindParam(':ID_rezerwacji_status', $ID_rezerwacji_status);
            $stmt->bindParam(':numer_siedzenia', $numer_siedzenia);
            $stmt->execute();
            echo "Record created successfully.";
        } elseif (isset($_POST["read"])) {
            // Operacja READ
            $stmt = $conn->query("SELECT * FROM rezerwacje");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "bagaz: {$row['bagaz']} - ID_adres: {$row['ID_adres']} - ID_numer_lotu: {$row['ID_numer_lotu']}<br>";
                echo "ID_Pasazer: {$row['ID_Pasazer']} - ID_Rezerwacji: {$row['ID_Rezerwacji']} - ID_rezerwacji_status: {$row['ID_rezerwacji_status']}<br>";
                echo "numer_siedzenia: {$row['numer_siedzenia']} ";
            
            }
        } elseif (isset($_POST["update"])) {
            // Operacja UPDATE
            $stmt = $conn->prepare("UPDATE rezerwacje SET bagaz = :bagaz, ID_adres = :ID_adres, ID_numer_lotu = :ID_numer_lotu, ID_Pasazer = :ID_Pasazer, ID_Rezerwacji = :ID_Rezerwacji, ID_rezerwacji_status = :ID_rezerwacji_status,numer_siedzenia=:numer_siedzenia WHERE ID_Rezerwacji = :ID_Rezerwacji");
            $stmt->bindParam(':bagaz', $bagaz);
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->bindParam(':ID_numer_lotu', $ID_numer_lotu);
            $stmt->bindParam(':ID_Pasazer', $ID_Pasazer);
            $stmt->bindParam(':ID_Rezerwacji', $ID_Rezerwacji);
            $stmt->bindParam(':ID_rezerwacji_status', $ID_rezerwacji_status);
            $stmt->bindParam(':numer_siedzenia', $numer_siedzenia);
            $stmt->execute();
            echo "Record updated successfully.";
        } elseif (isset($_POST["delete"])) {
            // Operacja DELETE
            $stmt = $conn->prepare("DELETE FROM rezerwacje WHERE ID_Rezerwacji = :ID_Rezerwacji");
            $stmt->bindParam(':ID_Rezerwacji', $ID_Rezerwacji);
            $stmt->execute();
            echo "Record deleted successfully.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
