<?php
        include '../../../../functions.php';
$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
    $connessione = dbConnection("../../../../../");

    $idscuola = $_POST['id'];
    
    $query =  "SELECT * FROM scuola WHERE id_scuola = $idscuola";
    
    $result = $connessione->query($query);
    
    $scuola = $xml->addChild("scuola");
    while ($row = $result->fetch_assoc())
    {
        $scuola->addChild("nome", $row['nome']);
        $scuola->addChild("citta", $row['citta']);
        $scuola->addChild("CAP", $row['CAP']);
        $scuola->addChild("indirizzo", $row['indirizzo']);
        $scuola->addChild("telefono", $row['telefono']);
        $scuola->addChild("email", $row['email']);
        $scuola->addChild("sito_web", $row['sito_web']);
    }
    
    echo $xml->asXML(); 