<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")

{
    $ID_samolotu=$_POST['ID_samolotu'];
    $producent = $_POST['producent'];
    $typ= $_POST['typ'];
    

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
            $stmt = $conn->prepare("INSERT INTO samolot (ID_samolotu,producent,typ ) VALUES (:ID_samolotu,:producent, :typ)");
             
            $stmt->bindParam(':ID_samolotu', $ID_samolotu);
            $stmt->bindParam(':producent', $producent);
            $stmt->bindParam(':typ', $typ);
            
            $stmt->execute();
            echo "Connected successfully. <br>";
        } elseif (isset($_POST["read"])) {
            $stmt = $conn->query("SELECT * FROM samolot");
            ?>
            <div class="container mt-5">
                <div class="row">
                    <div class="col">
                        <h2>Lista samolotów</h2>
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                                <tr>
                                    
                                    <th scope="col">ID</th>
                                    <th scope="col">producent</th>
                                    <th scope="col">typ</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['ID_samolotu']; ?></th>
                                        <td><?php echo $row['producent']; ?></td>
                                        <td><?php echo $row['typ']; ?></td>
                                       
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
            $stmt = $conn->prepare("UPDATE samolot SET ID_samolotu=:ID_samolotu,producent = :producent, typ = :typ WHERE ID_samolotu = :ID_samolotu");
            $stmt->bindParam(':ID_samolotu', $ID_samolotu);
            $stmt->bindParam(':producent', $producent);
            $stmt->bindParam(':typ', $typ);
           
            
            $stmt->execute();
            echo "Connected successfully. <br>";
        } elseif (isset($_POST["delete"])) {
            // Operacja DELETE
            $stmt = $conn->prepare("DELETE FROM samolot WHERE ID_samolotu = :ID_samolotu");
            $stmt->bindParam(':ID_samolotu', $ID_samolotu);
            $stmt->execute();
            header ("Location: samolot.html");
        }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
