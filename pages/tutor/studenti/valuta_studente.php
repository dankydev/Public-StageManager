<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Valutazione studente" );
    import("../../../");
    $conn = dbConnection ("../../../");
    $idStudenteHasStage = $_POST ['shs'];
    
    echo "<link href='css/valuta_studente.css' rel='stylesheet' type='text/css'>";
?>
<body>
    <script src="js/scripts_valuta.js"> </script>
        
	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">                    
                    <h1 id = "valuta">Valuta</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                        <?php
                        	$sql = "select `visita_azienda` from `studente_has_stage` where `id_studente_has_stage`=$idStudenteHasStage";
                            $Result = $conn->query ( $sql );
                            $row = $Result->fetch_assoc ();
                            $visita = $row ['visita_azienda'];
                            if ($visita == 0) {
                        ?>
                                <script>window.location.replace("index.php");</script>
                        <?php 
                            } 
                            elseif ($visita == 1) {
                                $sql = "SELECT studente.nome, studente.cognome 
                                		FROM studente, studente_has_stage 
                                		WHERE studente_has_stage.id_studente_has_stage = $idStudenteHasStage 
                                		AND studente_has_stage.studente_id_studente = studente.id_studente;";
                                $Result = $conn->query ( $sql );
                                while ( $row = $Result->fetch_assoc () ) {
                                    $gestione_ambiente_spazio_lavoro = "";
                                    $collaborazione_comunicazione = "";
                                    $uso_strumenti = "";
                                    $complessita_compito_atteggiamento = "";
                                    $valutazione_gestione_sicurezza = "";
                                    $competenze_linguistiche = "";
                                    $conoscenza_coerenza_approfondimento = "";
                                    $efficacia_esposizone = "";
                                    $qualita_processo = "";
                                    $efficacia_prodotto = "";
                                    $commento = "";
                                    $button_value = "Inserisci valutazione";
                                    $button_onClick = "insertGrades();";
                                    $nome = $row ['nome'];
                                    $cognome = $row ['cognome'];
					                echo "<script>$('#valuta').append(' <i>$cognome $nome<i>');</script>";
                                    echo "<div class=\"row\"><div class=\"col col-sm-8\">";
                                    
                                    $sql = "select `valutazione_studente_id_valutazione_studente` from studente_has_stage where `id_studente_has_stage`=  $idStudenteHasStage";
                                    $Result = $conn->query ( $sql );
                                    $row = $Result->fetch_assoc ();
                                            if (isset($row ['valutazione_studente_id_valutazione_studente'])) {
                                                $button_value = "Aggiorna valutazione";
                                                $button_onClick = "updateGrades ();";
                                                $id_valutazione_studente = $row ['valutazione_studente_id_valutazione_studente'];
                                                $sql = "SELECT `gestione_ambiente_spazio_lavoro`, `collaborazione_comunicazione`, `uso_strumenti`, `rispetta_norme_vigenti`, `rispetto_ambiente`, `puntualita`"
                                                        . ", `collaborazione_tutor`, `lavoro_requisiti`, `conoscenze_tecniche`, `acquisire_nuove_conoscenze`, `commento` FROM `valutazione_studente` "
                                                        . "WHERE `id_valutazione_studente` = $id_valutazione_studente";
                                                $Result1 = $conn->query ( $sql );
                                                if ($Result1) {
                                                    while ( $row = $Result1->fetch_assoc () ) {
                                                        $gestione_ambiente_spazio_lavoro = $row ["gestione_ambiente_spazio_lavoro"];
                                                        $collaborazione_comunicazione = $row ['collaborazione_comunicazione'];
                                                        $uso_strumenti = $row ['uso_strumenti'];
                                                        $complessita_compito_atteggiamento = $row ['rispetta_norme_vigenti'];
                                                        $valutazione_gestione_sicurezza = $row ['rispetto_ambiente'];
                                                        $competenze_linguistiche = $row ['puntualita'];
                                                        $conoscenza_coerenza_approfondimento = $row ['collaborazione_tutor'];
                                                        $efficacia_esposizone = $row ['lavoro_requisiti'];
                                                        $qualita_processo = $row ['conoscenze_tecniche'];
                                                        $efficacia_prodotto = $row ['acquisire_nuove_conoscenze'];
                                                        $commento = $row ['commento'];
                                                    }
                                                }
                                            }
                                            outputSelect ( "Capacita' di mantenere in ordine la postazione di lavoro", "gestione_ambiente_spazio_lavoro", $gestione_ambiente_spazio_lavoro );
                                            outputSelect ( "Capacita' di collaborare e comunicare correttamente", "collaborazione_comunicazione", $collaborazione_comunicazione );
                                            outputSelect ( "Capacita' di usare gli strumenti Harware e Software", "uso_strumenti", $uso_strumenti );
                                            outputSelect ( "Rispetto delle norme vigenti per la sicurezza nei luoghi di lavoro", "complessita_compito_atteggiamento", $complessita_compito_atteggiamento );
                                            outputSelect ( "Rispetto dell'ambiente e dei colleghi di lavoro","rispetto_ambiente", $valutazione_gestione_sicurezza );
                                            outputSelect ( "Puntualità e presenza sul lavoro", "competenze_linguistiche", $competenze_linguistiche );
                                            outputSelect ( "Capacita' di comunicare e di relazionarsi", "conoscenza_coerenza_approfondimento", $conoscenza_coerenza_approfondimento );
                                            outputSelect ( "Collaborazione con il tutor aziendale", "efficacia_esposizone", $efficacia_esposizone );
                                            outputSelect ( "Rispetto dei requisiti richiesti nel lavoro svolto", "qualita_processo", $qualita_processo );
                                            outputSelect ( "Dimostra di avere idonee conoscenze tecniche", "efficacia_prodotto", $efficacia_prodotto );
                                            echo <<<HTML
                                                <div class='row parametro-valutazione'>
                                                    <div class='col col-md-2 col-sm-4'>
                                                    	<label>Commento</label>
                                                    </div>
                                                    <div class='col col-md-10 col-sm-8'>
                                                    <textarea class = "form-control" name = "commento" maxlength = "250" rows = "7" placeholder = "Facoltativo">$commento</textarea>
                                                    </div>
                                                </div>
                                        	</div>
                                        	<div class="col col-sm-4">   
                                    			<div align="center">
                                        			<input class="btn btn-primary" type="button" value="$button_value" id="SalvaValutazione" onclick="$button_onClick">
                                				</div>
	                                            <div align="center">
			                                        <p id='media'> </p>
			                                    </div>
	                                        </div>
										</div>
HTML;
                                    }
                                }
                                echo <<<HTML
                                <input type="hidden" name="id_studente_has_stage" value="$idStudenteHasStage">
                                    <br>
HTML;
                    ?>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html("../../../");
?>
    
<?php
    function outputSelect($selectTitle, $selectName, $selectedValue) {
        echo <<<HTML
                <div class='row parametro-valutazione'>
                	<div class='col col-md-10 col-sm-8'>
                		<label>$selectTitle</label>
                	</div>
               	 <div class='col col-md-2 col-sm-4'>
               	 	<select class="form-control" name="$selectName">
HTML;
        for($i = 1; $i <= 10; $i ++) {
            $output = "<option value='$i'";
            if ($i == $selectedValue) {
                $output = $output . " selected";
            }
            $output = $output . ">$i</option>";
            echo $output;
        }            
        echo "</select></div></div>";
    }
?>