<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <header>
        <div class="topnav" id="myTopnav">
            <a href="/pokalbis/home.php">Home</a>
            <div class=crud>
                <h1>Electronic devices</h1>
                <div class=crud>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </div>
            </div>

    </header>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "sp2";


    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = 'SELECT goods.id, goods.category, goods.model, goods.producer, goods.inStock  FROM goods';
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $counter = 1;
        print('<table id=table1>');
        print('<thead>');
        print('<tr><th>ID</th><th>Prekes kategorija</th><th>Modelis</th><th>Gamintojas</th><th>Ar yra sandelyje</th>');

        print('</thead>');
        while ($row = mysqli_fetch_assoc($result)) {
            print('<tr><td>' . $counter++ . '</td>
                       <td> ' . $row['category'] . '</td>
                       <td> ' . $row['model'] . '</td>
                       <td> ' . $row['producer'] . '</td>
                       <td> ' . $row['inStock'] . '</td>
             </form></td></tr>');
        }
        print('<table>');
    } else {
        echo "Nėra duomenų";
    }
    $conn->close();
    ?>

    <br>

    <footer>
        <div id="footer-content">
            <p> NO Copyright 2021 @ Tomas - NO Rights Reserved </p>
        </div>
    </footer>

</body>

</html>