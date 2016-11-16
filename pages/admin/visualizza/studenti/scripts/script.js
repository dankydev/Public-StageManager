studente = {
    'id'            : '',
    'password'      : '',
    'username'      : '',
    'nome'          : '',
    'cognome'       : '',
    'citta'         : '',
    'mail'          : '',
    'telefono'      : '',
    'classe'        : ''
};

function openEdit(id, idStudente, classe, anno)
{
    id = id+'';
    var numberId = id.replace('VisibleBox','');
    //alert(numberId)
    
    $("#modifica"+numberId).prop("disabled",true);
    $("#registro"+numberId).prop("disabled",true);
    $('#'+id).append("<div id=\"HiddenBox"+numberId+"\">\n\
<div class=\"row\">\n\
 <div class=\"col col-sm-12\">\n\
 <div class=\"row\"> \n\
<div class=\"col col-sm-6\"> \n\
                <div ><label id=\"userlabel"+numberId+"\">username</label> <input placeholder=\"Username\" class=\"form-control\" type=\"text\" id=\"username"+numberId+"\"></div>\n\
                <div ><label> nome </label><input placeholder=\"Nome\" class=\"form-control\" type=\"text\" id=\"nome"+numberId+"\"></div> \n\
                <div ><label>cognome </label><input placeholder=\"Cognome\" class=\"form-control\" type=\"text\" id=\"cognome"+numberId+"\"></div>\n\
                <div ><label>citta</label> <input placeholder=\"Citta'\" class=\"form-control\" type=\"text\" id=\"citta"+numberId+"\"></div>\n\
\n\</div>\n\
<div class=\"col col-sm-6\">\n\
\n\<div class=\"form-group\"><label>password</label> <input placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\"></div>\n\
                <div ><label>e-mail</label> <input placeholder=\"E-Mail\" class=\"form-control\" type=\"text\" id=\"email"+numberId+"\"></div> \n\
                <div ><label>telefono</label> <input placeholder=\"Telefono\" class=\"form-control\" type=\"number\" id=\"telefono"+numberId+"\"></div>\n\
                <div ><label>preferenze</label> <br><input style=\"display:block\" disabled=\"true\" onkeydown=\"return false\" id=\"preferenze"+numberId+"\" class=\"form-control\" type=\"text\" value=\"\" data-role=\"tagsinput\" /></div>\n\
                <div > <br>  \n\
                    <form method=\"POST\" action=\"dettagliostage/index.php\">\n\
                        <div align=\"center\"><input type=\"submit\" class=\"btn btn-info\" value=\"Vai al dettaglio delle esperienze\" /></div> \n\
                        <input type=\"hidden\" value=\""+idStudente+"\" name=\"studente\">\n\
                        <input type=\"hidden\" value=\""+classe+"\" name=\"classe\">\n\
                        <input type=\"hidden\" value=\""+anno+"\" name=\"anno_scolastico\">\n\
                    </form>\n\
                </div>");
    
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append("<button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idStudente+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button> </div></div></div></div><br><br><br>");
    $("#iniziostage"+numberId).datepicker({ dateFormat: 'yy-mm-dd' });    
    setOnChangeEvents(numberId);    
    
    toget = {
        'id' : idStudente,
        'idanno' : anno,
        'idclasse' : classe
    };
    
    $.ajax(
            {
                type : 'POST',
        url : 'ajaxOpsPerStudente/getData.php',
        data : toget,
        success : function (xml)
        {
            $("#username"+numberId).attr('value',$(xml).find('username').text());
            $("#username"+numberId).attr('name',$(xml).find('username').text());
            $("#nome"+numberId).attr('value',$(xml).find('nome').text());
            $("#cognome"+numberId).attr('value',$(xml).find('cognome').text());
            $("#citta"+numberId).attr('value',$(xml).find('citta').text());
            $("#email"+numberId).attr('value',$(xml).find('email').text());
            $("#telefono"+numberId).attr('value',$(xml).find('telefono').text());
            var idazienda = $(xml).find("azienda").find('id').text() + '';
            
            if ($(xml).find('visita_azienda').text() === "0") $("#visitaazienda"+numberId).attr('checked',false); else $("#visitaazienda"+numberId).attr('checked',true);
            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            }; 
            $.ajax({
                type : 'POST',
                data : { 'classe' : classe },
                url : 'ajaxOpsPerStudente/ajaxClasse.php',
                success : function (classi)
                {
                    $(classi).find('classi').find('classe').each(function (){
                        $("#classe"+numberId).append("<option value = \""+ $(this).find('id').text()+"\"> "+ $(this).find('nome').text() +" </option>");
                    });
                    
                    var rightindex = 0;
                    $("#classe"+numberId+" > option").each(function() {
                        if (this.value === classe) 
                            rightindex = this.index;
                        
                        $("#classe"+numberId).prop('selectedIndex', rightindex);
                    });
                }
            });
            
            var first = true;
            $(xml).find("preferenze").find("preferenza").each(function (){
                if (first) {$("#preferenze"+numberId).tagsinput('add', ''+$(this).text()); first = false;}
                $("#preferenze"+numberId).tagsinput('add', ''+$(this).text());
            });
            $("span[data-role=\"remove\"]").css("visibility","hidden");
        }
    });  
    
    $("#username"+numberId).on("input", function (){
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxCheckUserExistence.php',
            cache : false,
            data : { 'user' : $("#username"+numberId).val(), 'original' : $("#username"+numberId).attr("name") },
            success : function(msg){
                if (msg === "trovato")
                {                    
                    $("#userlabel"+numberId).css("color", "red");
                    $("#userlabel"+numberId).html("username (esiste gia')");
                }
                else
                {
                    $("#userlabel"+numberId).css("color", "#828282");
                    $("#userlabel"+numberId).html("username");
                }
            }
        });
    });
    
    $("#nome"+numberId).keypress(function (event){
        if (event.which === 13) sendData(idStudente, numberId);
    });
    
    $("#HiddenBox"+numberId).fadeIn("slow")
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
}

function sendData(idStudente, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    studente.id = idStudente;
    studente.username = $("#username"+numberId+"").val();
    studente.nome = $("#nome"+numberId+"").val();
    studente.cognome = $("#cognome"+numberId+"").val();
    studente.citta = $("#citta"+numberId+"").val();
    studente.mail = $("#email"+numberId+"").val();
    studente.telefono = $("#telefono"+numberId+"").val();
    
    var appoggio = $("#classe"+numberId+"").find(':selected').attr('value') + '';
    studente.classe = (!appoggio.isEmpty()) ? $("#classe"+numberId+"").find(':selected').attr('value') : '';
    
    studente.password = ($("#password"+numberId).val().isEmpty()) ? 'immutato' : $("#password"+numberId).val();
    
    if (!studente.username.isEmpty() && !studente.nome.isEmpty() && !studente.cognome.isEmpty() && !studente.citta.isEmpty() && !studente.mail.isEmpty())
    {
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxInvia.php',
            data : studente,
            success : function (xml)
            {      
                var query    = $(xml).find("query").text();
                $("#label"+numberId).html(studente.cognome + " " + studente.nome + " ("+studente.username+")");
                resetColors(numberId);
            },
            error : function ()
            {
                alert("errore")
            }
        })
    }
}

function deleteData(idClasse, idStudente)
{
    var confirmed = confirm("Confermare l'eliminazione dello studente?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxCancella.php',
            data : {'id' : idStudente},
            success : function (msg)
            {
                location.href = "index.php?idclasse="+idClasse;
            }
        });
    }
}

function closeEdit(numberId)
{
    $("#ButtonBox"+numberId).height($("#VisibleBox"+numberId).height() - $("#HiddenBox"+numberId).height());
    $( "#HiddenBox"+numberId ).remove("br");
    $( "#HiddenBox"+numberId ).remove();
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on('input',((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#password"+numberId).on('input',((function (e){ $("#password"+numberId).css('color','red'); })));
    $("#nome"+numberId).on('input',((function (e){ $("#nome"+numberId).css('color','red'); })));
    $("#cognome"+numberId).on('input',((function (e){ $("#cognome"+numberId).css('color','red'); })));
    $("#citta"+numberId).on('input',((function (e){ $("#citta"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input',((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#telefono"+numberId).on('input',((function (e){ $("#telefono"+numberId).css('color','red'); })));
    $("#classe"+numberId).change('input',((function (e){ $("#classe"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#cognome"+numberId).css('color','#555');
    $("#citta"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#classe"+numberId).css('color','#555');
    $("#username"+numberId).css('color','#555');
}

function openRegistro(id, idStudente)
{
    id = id+'';
    var numberId = id.replace('registro','');
    $("#modifica"+numberId).prop("disabled",true);
    $("#registro"+numberId).prop("disabled",true);
    
    $('#VisibleBox'+numberId).append("<div id=\"RegistroBox"+numberId+"\"> </div>");    
    
    idstudente = {
        'studente' : idStudente
    };
    
    $.ajax({
        url : 'ajaxOpsPerStudente/ajaxRegistro.php',
        type : 'POST',
        cache : false,
        data : idstudente,
        success : function (xml)
        {
            $("#RegistroBox"+numberId).html('');
            $("#RegistroBox"+numberId).append("<table class=\"table\" id=\"table"+numberId+"\"> <thead><th style=\"min-width : 100px\"> Data </th> <th> Descrizione </th> </thead> </table>");
            $(xml).find('registro').find('lavorogiornaliero').each(function (){
                var data = $(this).find('data').text();
                var descrizione = $(this).find('descrizione').text();
                $("#table"+numberId).append("<tr> <td> "+data+" </td> <td> "+descrizione+" </td> </tr>");
            });
            $("#table"+numberId).hide();
            $("#table"+numberId).fadeIn("slow")
            $("#RegistroBox"+numberId).append("<button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeRegistro("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <br><br><br>")            
            $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#RegistroBox"+numberId).height());
        }
    });
}

function closeRegistro (numberId)
{
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#RegistroBox"+numberId).height())
    $( "#RegistroBox"+numberId ).remove();    
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
}

function openInfo()
{
    
}