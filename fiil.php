<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Zebrać wartości z pól formularza
    $miejscowosc = $_POST['miejscowosc'];
    $numer_domu = $_POST['numer_domu'];
    $numer_lokalu = $_POST['numer_lokalu'];
    $powiat = $_POST['powiat'];
    $ulica = $_POST['ulica'];
    $wojewodztwo = $_POST['wojewodztwo'];
    $ID_adres = $_POST['ID_adres'];

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
            $stmt = $conn->prepare("INSERT INTO adres (miejscowosc, numer_domu, numer_lokalu, powiat, ulica, wojewodztwo) VALUES (:miejscowosc, :numer_domu, :numer_lokalu, :powiat, :ulica, :wojewodztwo)");
            $stmt->bindParam(':miejscowosc', $miejscowosc);
            $stmt->bindParam(':numer_domu', $numer_domu);
            $stmt->bindParam(':numer_lokalu', $numer_lokalu);
            $stmt->bindParam(':powiat', $powiat);
            $stmt->bindParam(':ulica',$ulica);
            $stmt->bindParam(':wojewodztwo', $wojewodztwo);
            $stmt->execute();
            echo "Record created successfully.";
        } elseif (isset($_POST["read"])) {
            // Operacja READ
            $stmt = $conn->query("SELECT * FROM adres");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "Miejscowość: {$row['miejscowosc']} - Numer domu: {$row['numer_domu']} - Numer lokalu: {$row['numer_lokalu']}<br>";
                echo "Powiat: {$row['powiat']} - Ulica: {$row['ulica']} - Województwo: {$row['wojewodztwo']}<br>";
            }
        } elseif (isset($_POST["update"])) {
            // Operacja UPDATE
            $stmt = $conn->prepare("UPDATE adres SET miejscowosc = :miejscowosc, numer_domu = :numer_domu, numer_lokalu = :numer_lokalu, powiat = :powiat, ulica = :ulica, wojewodztwo = :wojewodztwo WHERE ID_adres = :ID_adres");
            $stmt->bindParam(':miejscowosc', $miejscowosc);
            $stmt->bindParam(':numer_domu', $numer_domu);
            $stmt->bindParam(':numer_lokalu', $numer_lokalu);
            $stmt->bindParam(':powiat', $powiat);
            $stmt->bindParam(':ulica', $ulica);
            $stmt->bindParam(':wojewodztwo', $wojewodztwo);
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->execute();
            echo "Record updated successfully.";
        } elseif (isset($_POST["delete"])) {
            // Operacja DELETE
            $stmt = $conn->prepare("DELETE FROM adres WHERE ID_adres = :ID_adres");
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->execute();
            echo "Record deleted successfully.";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
