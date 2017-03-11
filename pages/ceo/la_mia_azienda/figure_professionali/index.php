<?php
    include '../../../functions.php';
    checkLogin ( ceoType , "../../../../");
    import("../../../../");
    open_html ( "Figure Professionali" );
    $id_az = $_SESSION ['userId'];
    echo "<script src='scripts/script.js'></script>";
    $connessione = dbConnection ("../../../../");
?>
<body>
   	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Figure professionali richieste</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <br>
                            <table id="figtable" style="table-layout: fixed" class="table table-bordered">
                                <thead style="background: #eee">
                                <th style="text-align: center">Tipo di scuola</th>
                                <th style="text-align: center">Figura professionale</th>    
                                <th style="text-align: center;width: 20%">Azioni</th>                                    
                                </thead>
                                <tbody>
                                    <?php
                                        $query = "SELECT anfp.id_azienda_needs_figura_professionale, s.indirizzo_studi, s.nome_settore, fp.nome 
                                                  FROM settore AS s, figura_professionale AS fp, azienda_needs_figura_professionale AS anfp 
                                                  WHERE anfp.figura_professionale_id_figura_professionale = fp.id_figura_professionale 
                                                  AND anfp.settore_id_settore = s.id_settore 
                                                  AND anfp.azienda_id_azienda = $id_az";
                                                      
                                        $result = $connessione->query($query);
                                        if ($result && $result->num_rows > 0)
                                        {
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $scuola = $row['indirizzo_studi'] . " " . $row['nome_settore'];
                                                $figura = $row['nome'];
                                                $idneed = $row['id_azienda_needs_figura_professionale'];
                                                    
                                                echo "<tr><td>$scuola</td>"
                                                       . "<td>$figura</td>"
                                                       . "<td align='center'><button class='btn btn-danger' onclick='deleteNeeding($idneed, this)'><span class=\"glyphicon glyphicon-remove\"></span> Elimina</button></td>"
                                                    . "</tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <button id="addButton" class="btn btn-success" onclick="$(this).prop('disabled', true); openAddBox()">
                                <span class="glyphicon glyphicon-plus"></span>
                                Aggiungi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</body>
<?php
    close_html ("../../../../");
?>