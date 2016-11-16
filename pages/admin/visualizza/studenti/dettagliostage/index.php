<?php
    include '../../../../functions.php';
    checkLogin(superUserType, "../../../../../");
    open_html("Dettaglio esperienze");
    echo "<script src=\"scripts.js\"> </script>";
    import("../../../../../");    
    $connessione = dbConnection("../../../../../");
    $idstudente = $_POST['studente'];
    $idclasse = $_POST['classe']; 
    $idanno = $_POST['anno_scolastico']; //esperienze dello studente in quella specifica classe in quello specifico anno!    
        
    $query = "SELECT nome, cognome FROM studente WHERE id_studente = $idstudente";
    $result = $connessione->query($query);
    $row = $result->fetch_assoc();
    $nomestudente = $row["nome"];
    $cognomestudente = $row["cognome"];
    $query = "SELECT nome_anno FROM anno_scolastico WHERE id_anno_scolastico = $idanno";
    $result = $connessione->query($query);
    $nomeanno = $result->fetch_assoc()["nome_anno"];
?>
    
<body>
    
    <?php
        topNavbar("../../../../../");    
        titleImg("../../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h2> Dettaglio esperienze di <?php echo $cognomestudente . " " . $nomestudente ?> (A.S. <?php echo $nomeanno; ?>)</h2>
                    <br><br>    
                    <table id="mainTable" class="table table-bordered">
                        <thead style="background: #ddd">
                        <th style="text-align: center; width: 35%">
                            Inizio
                        </th>
                        <th style="text-align: center; width: 35%">
                            Durata
                        </th>
                        <th style="text-align: center; width: 30%">
                            Azioni
                        </th>
                        </thead>
                        
                        <tbody>
                            <?php
                                $query = "SELECT id_stage, inizio_stage, durata_stage FROM stage AS s, classe_has_stage AS chs WHERE chs.stage_id_stage = s.id_stage AND chs.anno_scolastico_id_anno_scolastico = $idanno AND chs.classe_id_classe = $idclasse";
                                
                                $result = $connessione->query($query);
                                
                                $I=0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $resultstage = $connessione->query("SELECT id_classe_has_stage FROM classe_has_stage WHERE stage_id_stage = ".$row['id_stage']." AND classe_id_classe = $idclasse AND anno_scolastico_id_anno_scolastico = $idanno");
                                    $idclassestage = $resultstage->fetch_assoc()["id_classe_has_stage"];
                                    
                                    echo "<tr id=\"riga$I\" style=\"text-align : center\"> <td> ".$row['inizio_stage']." </td> <td> ".$row['durata_stage']." giorni </td>"
                                         . " <td>"
                                         . "<button id=\"dettagli$I\" style=\"margin : 0px\" onclick=\"openInfo($I, $idclassestage, $idstudente)\" class=\"btn btn-success btn-sm margin buttonfix\"> <span class=\"glyphicon glyphicon-edit\"></span> Dettagli </button> "
                                         . "<button id=\"rimuovi$I\" style=\"margin : 0px\" onclick=\"\" class=\"btn btn-danger btn-sm margin buttonfix\"> <span class=\"glyphicon glyphicon-remove\"></span> Rimuovi </button> </td> </tr>";
                                    
                                    $I++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html();
?>