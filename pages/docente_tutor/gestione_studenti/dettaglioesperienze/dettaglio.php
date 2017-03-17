<?php
    include '../../../functions.php';
    checkLogin ( doctutType , "../../../../");
    
    $conn = dbConnection ("../../../../");    

    $id_doc = $_SESSION ['userId'];
        
    $idstudente = $_POST['ids'];
    $idanno = $_POST['ida'];
    $idclasse = $_POST['idc'];
    $query = "SELECT id_studente_has_stage, tutor.nome, tutor.cognome, azienda.nome_aziendale, inizio_stage, durata_stage FROM tutor, azienda, stage AS st, studente_has_stage AS shs, classe_has_stage AS chs "
            . "WHERE tutor.id_tutor = shs.tutor_id_tutor AND shs.azienda_id_azienda = azienda.id_azienda AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage "
            . "AND st.id_stage = chs.stage_id_stage AND shs.studente_id_studente = $idstudente AND chs.classe_id_classe = $idclasse AND chs.anno_scolastico_id_anno_scolastico = $idanno";
    $cognomestudente = $conn->query("SELECT cognome FROM studente WHERE id_studente = $idstudente")->fetch_assoc()['cognome'];
    $nomestudente = $conn->query("SELECT nome FROM studente WHERE id_studente = $idstudente")->fetch_assoc()['nome'];
    $nomeanno = $conn->query("SELECT nome_anno AS nome FROM anno_scolastico WHERE id_anno_scolastico = $idanno")->fetch_assoc()['nome'];
    
    import("../../../../");
    echo "<script src=\"scripts.js\"> </script>";
    open_html ( "Esperienze di $cognomestudente $nomestudente" );
?>
    
<body>
    <style>
        .tdlink{
            cursor: pointer;
        }
    </style>
   	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel" style='min-height: 0'>
                    <form id='rForm' action="registro.php" method='POST' target="_blank">
                        <input name='ida' type='hidden' value="<?php echo $idanno; ?>">
                    </form>
                    
                    <h1> Esperienze di stage di <u onclick="userProfile(<?php echo $idstudente ?>, '../../../')" style="cursor: pointer"><?php echo $cognomestudente . " " . $nomestudente ?></u></h1> <br>
                        
                    <div class="row">
                        <div class="col col-sm-4">
                            
                        </div>
                            
                        <div class="col col-sm-4">
                            Desidero visualizzare<select class="form-control" id="destination">
                                <option value="registro">Registro</option>
                                <option value="valutazionestud">Valutazione dello studente</option>
                                <option value="valutazioneaz">Valutazione  dell'azienda</option>
                            </select> 
                        </div>
                            
                        <div class="col col-sm-4">                   
                        </div>
                    </div>
                    <br>
                    <table class="table table-hover">
                        <thead>
                        <th style="text-align: center">
                            Data di inizio stage
                        </th>
                            
                        <th style="text-align : center" style="text-align: center;">
                            Data di fine stage
                        </th>
                            
                        <th style="text-align : center" style="text-align: center;">
                            Azienda
                        </th>
                            
                        <th style="text-align : center" style="text-align: center;">
                            Tutor
                        </th>
                            
                        <th style="text-align: center;">
                            Azioni
                        </th>
                        </thead>
                            
                        <tbody style="text-align: center">
                            <?php
                                $result = $conn->query($query);
                                $I = 0;
                                    
                                while ($row = $result->fetch_assoc())
                                {
                                    $inizio = $row['inizio_stage'];
                                    $durata = $row['durata_stage'];
                                        
                                    echo "<tr id=\"riga$I\" style=\"font-size : 20px\"> <td>".date("d-m-Y", strtotime($inizio))."</td> <td>".date('d-m-Y', strtotime("+".$durata." days", strtotime($inizio)))."</td>"
                                       . " <td>".$row['nome_aziendale']."</td> <td>".$row['cognome']." ".$row['nome']."</td> <td><div align=\"center\">"
                                       . "<button onclick=\"establishDestination($I, ".$row['id_studente_has_stage'].")\" id=\"dettagli$I\" style=\"margin : 0px\" class=\"btn btn-success\"> <span class=\"glyphicon glyphicon-circle-arrow-right\"></span> Visualizza </button></div></td></tr>";
                                           
                                    $I++;
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div align='right'>
                        <h3 style='display: inline'>A.S. <?php echo $nomeanno; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    close_html("../../../../");
?>