<?php

    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idazienda = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "SELECT `id_azienda` FROM `azienda` WHERE `id_azienda` = $idazienda AND `password` = '$password'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0)
        echo "non esiste";
    else
        echo "esiste";