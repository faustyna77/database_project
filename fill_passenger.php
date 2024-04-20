<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")

{
    $imie = $_POST['imie'];
    $surname= $_POST['surname'];
    $mail = $_POST['mail'];
    $telefon = $_POST['telefon'];
    $pesel = $_POST['pesel'];
   
    $ID_adres = $_POST['ID_adres'];

    // Połączenie z bazą danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rezerwacje";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        

        if (isset($_POST["create"])) {
            // Operacja CREATE
            $stmt = $conn->prepare("INSERT INTO pasazer (ID_adres, imie, mail, pesel, surname, telefon) VALUES (:ID_adres, :imie, :mail, :pesel, :surname, :telefon)");
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->bindParam(':imie', $imie);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':pesel', $pesel);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':telefon', $telefon);
            $stmt->execute();
            header ("Location: home.html");
        } elseif (isset($_POST["read"])) {
            $stmt = $conn->query("SELECT * FROM pasazer");
            ?>
            <div class="container mt-5">
                <div class="row">
                    <div class="col">
                        <h2>Lista pasażerów</h2>
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                                <tr>
                                    
                                    <th scope="col">ID_adres</th>
                                    <th scope="col">Imię</th>
                                    <th scope="col">Mail</th>
                                    <th scope="col">Pesel</th>
                                    <th scope="col">Surname</th>
                                    <th scope="col">Telefon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['ID_adres']; ?></th>
                                        <td><?php echo $row['imie']; ?></td>
                                        <td><?php echo $row['mail']; ?></td>
                                        <td><?php echo $row['pesel']; ?></td>
                                        <td><?php echo $row['surname']; ?></td>
                                        <td><?php echo $row['telefon']; ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        } elseif (isset($_POST["update"])) {
            // Operacja UPDATE
            $stmt = $conn->prepare("UPDATE pasazer SET imie = :imie, mail = :mail, pesel = :pesel, surname = :surname, telefon = :telefon WHERE ID_adres = :ID_adres");
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->bindParam(':imie', $imie);
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':pesel', $pesel);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':telefon', $telefon);
            
            $stmt->execute();
            header ("Location: home.html");
        } elseif (isset($_POST["delete"])) {
            // Operacja DELETE
            $stmt = $conn->prepare("DELETE FROM pasazer WHERE ID_adres = :ID_adres");
            $stmt->bindParam(':ID_adres', $ID_adres);
            $stmt->execute();
            header ("Location: home.html");
        }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
