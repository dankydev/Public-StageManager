<?php
    include "../../../functions.php";
    $id_studente = $_SESSION ['userId'];
    
    $connection = dbConnection("../../../../");
    $query = "SELECT studente.nome, studente.cognome, studente.email
                FROM studente
                WHERE studente.id_studente = $id_studente;";
    $result = $connection->query ( $query );
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc ();
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $mittente = $row ['email'];
    }

    if (isset ($_POST ['email'])) {
        $destinatario = $_POST ['email'];
        $headers .= "From:" . $nome . " " . $cognome . "<" . $mittente .">";
    }
    else {
        $destinatario = $mittente;
        $headers .= "From: <noreply@stagemanager.it>";
    }    
    $oggetto = $_POST ['object'];
    $messaggio = $_POST ['message'];
    
    if (mail ( $destinatario, $oggetto, $messaggio, $headers )) {
        echo "ok";
         
    } else {
        echo "error";
    }
?>