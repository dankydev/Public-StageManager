<?php

    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $iddocente = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "SELECT `id_docente` FROM `docente` WHERE `id_docente` = $iddocente AND `password` = '$password'";
    $result = $conn->query($query);
    if (!$result || $result->num_rows === 0)
        echo "non esiste";
    else
        echo "esiste";