<?php
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );

    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $settore = $_POST['settore'];
    $figura = $_POST['figura'];
    $azienda = $_SESSION['userId'];
    
    $query = "INSERT INTO azienda_needs_figura_professionale (azienda_id_azienda, figura_professionale_id_figura_professionale, settore_id_settore) "
            . "VALUES ($azienda, $figura, $settore)";
    
    if ($connection->query($query))
    {
        $xml->addChild("esito", "ok");
        $xml->addChild("insert_id", $connection->insert_id);
        echo $xml->asXML();
    }        
    else
        echo $connection->error;