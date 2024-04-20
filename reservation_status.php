<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")

{
    $ID_rezerwacji_status=$_POST['ID_rezerwacji_status'];
    $status_rezerwacji = $_POST['status_rezerwacji'];
    
    

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
            $stmt = $conn->prepare("INSERT INTO status_rezerwacji (ID_rezerwacji_status,status_rezerwacji ) VALUES (:ID_rezerwacji_status,:status_rezerwacji)");
             
            $stmt->bindParam(':ID_rezerwacji_status', $ID_rezerwacji_status);
            $stmt->bindParam(':status_rezerwacji', $status_rezerwacji);
            
            
            $stmt->execute();
            echo "Connected successfully. <br>";
        } elseif (isset($_POST["read"])) {
            $stmt = $conn->query("SELECT * FROM status_rezerwacji");
            ?>
            <div class="container mt-5">
                <div class="row">
                    <div class="col">
                        <h2>Status rezerwacji</h2>
                        <table class="table table-hover table-striped mt-3">
                            <thead>
                                <tr>
                                    
                                    <th scope="col">ID rezerwacji status</th>
                                    <th scope="col">status rezerwacji</th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <th scope="row"><?php echo $row['ID_rezerwacji_status']; ?></th>
                                        <td><?php echo $row['status_rezerwacji']; ?></td>
                                        
                                       
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
            $stmt = $conn->prepare("UPDATE status_rezerwacji SET ID_rezerwacji_status=:ID_rezerwacji_status,status_rezerwacji = :status_rezerwacji WHERE ID_rezerwacji_status = :ID_rezerwacji_status");
            $stmt->bindParam(':ID_rezerwacji_status', $ID_rezerwacji_status);
            $stmt->bindParam(':status_rezerwacji', $status_rezerwacji);
           
           
            
            $stmt->execute();
            echo "Connected successfully. <br>";
        } elseif (isset($_POST["delete"])) {
            // Operacja DELETE
            $stmt = $conn->prepare("DELETE FROM status_rezerwacji WHERE ID_rezerwacji_status = :ID_rezerwacji_status");
            $stmt->bindParam(':ID_rezerwacji_status', $ID_rezerwacji_status);
            $stmt->execute();
            header ("Location: samolot.html");
        }
        
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
