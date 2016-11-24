<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci tutor" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>
    
<script>
    addSelectionsFor('tutor','azienda');
</script>
    
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <link rel="stylesheet" href="../InsertStyle.css">
        
    <script> 
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        };      
        
        var check = setInterval(function(){
            if ($("#usernameTutor").val().isEmpty() || $("#passwordTutor").val().isEmpty() || $("#confermaPasswordTutor").val().isEmpty() || $("#nomeTutor").val().isEmpty()
                    || $("#cognomeTutor").val().isEmpty() || $("#telefonoTutor").val().isEmpty() || $("#emailTutor").val().isEmpty() || $("#aziendaTutor").val().isEmpty() 
                    || $("#userexists").val() === "1" || $("#passworderror").val() === "1")
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
        },1);
    </script>
    <input type="hidden" id="userexists" value="0">
    <input type="hidden" id="passworderror" value="0">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento tutor</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b id = "usr">Username*</b> 
                                <div class="form-group">
                                    <div class="form-group has-error has-feedback" id="usernameregulator">                                      
                                        <input class="form-control" id="usernameTutor"> 
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="usernamespanregulator"></span> 
                                    </div>
                                </div>
                                <b id = "psw">Password (Minimo 8 caratteri)*</b> 
                                <div class="form-group"> 
                                    <div class="form-group has-error has-feedback" id="passwordregulator"> 
                                        <input type="password" class="form-control" id="passwordTutor"> 
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="passwordspanregulator"></span> 
                                    </div>
                                </div>
                                <b>Conferma Password*</b> <div class="form-group"> <input type="password" class="form-control" id="confermaPasswordTutor"> </div>
                                <b>Nome*</b> <div class="form-group"> <input class="form-control" id="nomeTutor"> </div>
                                <b>Cognome*</b> <div class="form-group"> <input class="form-control" id="cognomeTutor"> </div>
                                <b>Telefono*</b> <div class="form-group"> <input class="form-control" id="telefonoTutor"> </div>
                                <b>E-mail*</b> <div class="form-group"> <input class="form-control" id="emailTutor"> </div>
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input class="btn btn-primary" value="Invia" onclick="sendSingleData('tutor');">
                            </div>
                                
                            <div class="col col-sm-6">
                                <b>Azienda*</b> <div class="form-group"> <select class="form-control" id="aziendaTutor"> </select> </div>
                            </div>
                        </form>
                    </div>
                </div>
                    
                <div class="panel">
                    <div class="row">
                        <div class="col-sm-6">
                            
                            <form enctype="multipart/form-data" method="post" action="" name="uploadform">
                                Seleziona il file contenente i tutor da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="file1">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                            </form>
                                
                            <script>
                                $("#usernameTutor").on('input',function (){
                                    $.ajax({
                                        type : 'POST',
                                        url : '../ajaxOps/ajaxCheckUserExistence.php',
                                        data : {'user' : $("#usernameTutor").val()},
                                        cache : false,
                                        success : function (msg)
                                        {
                                            if (msg === "trovato")
                                            {
                                                $("#userexists").val("1");
                                                $("#usr").html("Username (già in uso)*");
                                                $("#usr").css("color","red");
                                                $("#usernameregulator").removeClass("has-warning");
                                                $("#usernameregulator").removeClass("has-success");
                                                $("#usernameregulator").addClass("has-error");
                                                $("#usernamespanregulator").removeClass("glyphicon-ok");
                                                $("#usernamespanregulator").addClass("glyphicon-remove");  
                                            }
                                            else
                                            {
                                                if ($("#usernameTutor").val().isEmpty())
                                                {
                                                    $("#userexists").val("1");
                                                    $("#usr").css("color","red");
                                                    $("#usernameregulator").removeClass("has-warning");
                                                    $("#usernameregulator").removeClass("has-success");
                                                    $("#usernameregulator").addClass("has-error");
                                                    $("#usernamespanregulator").removeClass("glyphicon-ok");
                                                    $("#usernamespanregulator").addClass("glyphicon-remove");
                                                    return;
                                                }
                                                $("#userexists").val("0");
                                                $("#usr").html("Username*");
                                                $("#usr").css("color","#828282");
                                                $("#usernameregulator").removeClass("has-warning");
                                                $("#usernameregulator").removeClass("has-error");
                                                $("#usernameregulator").addClass("has-success");
                                                $("#usernamespanregulator").removeClass("glyphicon-remove");
                                                $("#usernamespanregulator").addClass("glyphicon-ok");  
                                            }
                                        }
                                    });
                                });
                                
                                var checkpw = setInterval(function (){
                                    if ($("#passwordTutor").val() !== $("#confermaPasswordTutor").val() || $("#passwordTutor").val().length < 8)
                                    {
                                        $("#passworderror").val("1");
                                        $("#psw").html("Password (Minimo 8 caratteri)* troppo corta o non coincide");
                                        $("#psw").css("color","red");
                                        $("#passwordregulator").removeClass("has-warning");
                                        $("#passwordregulator").removeClass("has-success");
                                        $("#passwordregulator").addClass("has-error");
                                        $("#passwordspanregulator").removeClass("glyphicon-ok");
                                        $("#passwordspanregulator").addClass("glyphicon-remove");
                                    }
                                    else
                                    {
                                        $("#passworderror").val("0");
                                        $("#psw").css("color","#828282"); 
                                        $("#psw").html("Password (Minimo 8 caratteri)*");
                                        $("#passwordregulator").removeClass("has-warning");
                                        $("#passwordregulator").removeClass("has-error");
                                        $("#passwordregulator").addClass("has-success");
                                        $("#passwordspanregulator").removeClass("glyphicon-remove");
                                        $("#passwordspanregulator").addClass("glyphicon-ok");   
                                    }
                                }, 1);
                            </script>
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