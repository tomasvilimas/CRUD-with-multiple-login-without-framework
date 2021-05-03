<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: admin-login.html');
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
            <a href="/pokalbis/home2.php">Home</a>
            <div class=crud>
                <h1>Electronic devices</h1>
                <div class=crud>
                    <a href="admin-logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
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
        print('<tr><th>ID</th><th>Prekes kategorija</th><th>Modelis</th><th>Gamintojas</th><th>Ar yra sandelyje</th><th>actions</th>');

        print('</thead>');
        while ($row = mysqli_fetch_assoc($result)) {
            print('<tr><td>' . $counter++ . '</td>
                       <td> ' . $row['category'] . '</td>
                       <td> ' . $row['model'] . '</td>
                       <td> ' . $row['producer'] . '</td>
                       <td> ' . $row['inStock'] . '</td>
            <td><form class="actions" action="" method="POST">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <button type="submit" name="delete" value="' . $row['id'] . '">Delete</button>
            <button type="submit" name="update" value="' . $row['id'] . '">Update</button>
            </form></td></tr>');
        }
        print('<table>');
    } else {
        echo "Nėra duomenų";
    }

    if (isset($_POST['create'])) {
        $stmt = $conn->prepare("INSERT INTO goods (id, category, model, producer, inStock) VALUES (?, ?, ? , ?, ?)");
        $stmt->bind_param("issss", $id, $category, $model, $producer, $inStock);
        $id = $_POST['fname'];
        $category = $_POST['1name'];
        $model = $_POST['2name'];
        $producer = $_POST['3name'];
        $inStock = $_POST['4name'];
        if (!empty($id) || !empty($category) || !empty($model) || !empty($producer) || !empty($inStock)) {
            $stmt->execute();
            $stmt->close();
            header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
            die;
        }
    }

    if (isset($_POST['delete'])) {
        $delete = $conn->prepare("DELETE FROM goods WHERE id = ?");
        $delete->bind_param("i", $delete_id);
        $delete_id = $_POST['id'];
        $delete->execute();
        $delete->close();
        header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
        die;
    }


    if (isset($_POST['update_name'])) {
        $id = $_POST['id'];
        $update = $conn->prepare("UPDATE goods SET category= ? , model= ? , producer= ?, inStock= ? WHERE id = '$id'");
        $update->bind_param("ssss", $category, $model, $producer, $inStock);
        $category = $_POST['category'];
        $model = $_POST['model'];
        $producer = $_POST['producer'];
        $inStock = $_POST['inStock'];
        $update->execute();
        $update->close();
        header('Location: ' . $_SERVER['REQUEST_URI']);
        die;
    }

    if (isset($_POST['update'])) {
        $category = $_POST['category'];
        $model = $_POST['model'];
        $producer = $_POST['producer'];
        $inStock = $_POST['inStock'];
        $crnt_id = $_POST['id'];
        print('<div>
        <br>
        <br>
                <form class="actions" action="" method="POST">
                    <input type="hidden" name="id" value="' . $crnt_id . '">
                    <input class=input type="text" id="category" name="category" value=""' . $category . '" placeholder="Prekės kategorija" Required>
                    <input class=input type="text" id="model" name="model" value="' . $model . '" placeholder="Modelis" Required>
                    <input class=input type="text" id="producer" name="producer" value="' . $producer . '" placeholder="Gamintojas" Required>
                    <input class=input type="text" id="inStock" name="inStock" value="' . $inStock . '" placeholder="Ar yra sandelyje" Required>
                    <br>
                    <br>
                    <button class=button type="submit" name="update_name">Pakeisti</button>
                </form>
            </div>');
    }
    $conn->close();
    ?>

    <br>
    <form action="" method="POST">
        <label for="lname"></label><br>
        <input class=input type="TEXT" id="lname" name="1name" value="" placeholder="Prekės kategorija" Required><br>
        <br>
        <input class=input type="TEXT" id="lname" name="2name" value="" placeholder="Modelis" Required><br>
        <br>
        <input class=input type="TEXT" id="lname" name="3name" value="" placeholder="Gamintojas" Required><br>
        <br>
        <input class=input type="TEXT" id="lname" name="4name" value="" placeholder="Ar yra sandelyje" Required><br>
        <br>
        <input class=button type="submit" name="create" value="Pridėti prekę">

    </form>



    <footer>
        <div id="footer-content">
            <p> NO Copyright 2021 @ Tomas - NO Rights Reserved </p>
        </div>
    </footer>

</body>

</html>