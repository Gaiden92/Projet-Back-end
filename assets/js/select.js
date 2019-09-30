
$(document).ready(function(){
    //Globales
    var offsetC = '';//variable remise a zero de l'offset  -  creation de la variable contenant l'offset
    var curReq='';//variable qui contiendra la req en cours  - création de la variable contenant l'identifiant de la requete en cours

    function resetOffset(){     //fonction ki definie le nb dannonces kon veut aff
        offsetC = 0;
    }
    function incOffset(){       //ca veu dire kin inc incremente
        offsetC +=2;  
    }
    function setCurReq(curentRequest){
        curReq = curentRequest;
    }
    function resetCurReq(){
        curReq = '';
    }
    
    
    //affichage de la graduation
    var slider = document.getElementById("formControlRange");
    var output = document.getElementById("rangeprice");
    output.innerHTML = 'Prix: '+slider.value+'€'; 

    slider.oninput = function() {
        output.innerHTML = 'Prix: '+this.value+'€';
        var prixSelected=this.value;
        var parameters="prix="+prixSelected;
        //console.log(parameters);
        $.post("assets/ajax/select.php", parameters, function(data){
            $('#details').html(data.resultat); 
            //console.log(data.resultat);
        }, 'json');
    }

    /////////////////////////////////////////////////////////////////////////
    $('#categorie').change(function(event){
        resetOffset();
        resetCurReq();
        var id = $('#categorie').val(); 
        // on récupère le contenu de l'attribut "value" du selecteur, donc l'id categorie
        var categorie = $('#categorie option:selected').text(); 
        // on récupère la valeur entre les balises '<option>' dc le titre de la categorie
        setCurReq(categorie); 
        var parameters = "id="+id+"&categorie="+categorie+"&offset="+offsetC;  
         // on définit les paramètres a envoyés avec la requete AJAX "aller" | on transmet à la requete à la fois l'id et la cat 
        // le signe "&" permet d'ajouter des paramètres à la requete AJAX "aller" 
        $.post("assets/ajax/select.php", parameters, function(data){
            $('#details').html(data.resultat); 
            // on remplace le selecteur de la page index.php par le selecteur que nous avons mis à jour dans le fichier select.php
            incOffset();
        }, 'json');
    });
////////////////////////////////////////////////////////////////////////////////////////
    $('#ville').change(function(event){
        resetOffset();
        resetCurReq();
        var ville = $('#ville option:selected').text(); 
        setCurReq(ville); 
         var parameters = "ville="+ville+"&offset="+offsetC;      
        $.post("assets/ajax/select.php", parameters, function(data){
            $('#details').html(data.resultat);
            incOffset(); 
        }, 'json');
    });  
/////////////////////////////////////////////////////////////////////////////////////
    $('#membre').change(function(event){
        resetOffset();
        resetCurReq();
        var membre = $('#membre option:selected').text(); 
        setCurReq(membre); 
        var parameters = "membre="+membre+"&offset="+offsetC;   
        $.post("assets/ajax/select.php", parameters, function(data){
            $('#details').html(data.resultat); 
            incOffset();
        }, 'json');
    });  
//////////////////////////////////////////////////////////////////////////
    $('#tri').change(function(event){
        resetOffset();
        resetCurReq();
        var tri = $('#tri option:selected').text(); 
        setCurReq(tri); 
        var parameters = "tri="+tri+"&offset="+offsetC;     
        $.post("assets/ajax/select.php", parameters, function(data){
            $('#details').html(data.resultat); 
            incOffset();
        }, 'json');
    });  
//////////////////////////////////////////////////////////////////////////
    $(document).on('click','button[id=voirplusbtn]',function(){
        console.log('type de req:'+curReq);
        var elem = document.querySelector('button[id=voirplusbtn]');
        elem.parentNode.removeChild(elem);
        switch(curReq){
            case 'trier par prix du moins cher au plus cher':
                var tri = 'trier par prix du moins cher au plus cher'; 
                var parameters = "tri="+tri+"&offset="+offsetC;
                $.post("assets/ajax/select.php", parameters, function(data){
                    $('#details').append(data.resultat); 
                    incOffset();
                }, 'json');
            break;
            case 'trier par prix du plus cher au moins cher':
                var tri = 'trier par prix du plus cher au moins cher'; 
                var parameters = "tri="+tri+"&offset="+offsetC;
                $.post("assets/ajax/select.php", parameters, function(data){
                    $('#details').append(data.resultat); 
                    incOffset();
                }, 'json');
            break;
            case 'trier par date de la plus ancienne à la plus récente':
                var tri = 'trier par date de la plus ancienne à la plus récente'; 
                var parameters = "tri="+tri+"&offset="+offsetC;
                $.post("assets/ajax/select.php", parameters, function(data){
                    $('#details').append(data.resultat); 
                    incOffset();
                }, 'json');
            break;
            case 'trier par date de la plus récente à la plus ancienne':
                var tri = 'trier par date de la plus récente à la plus ancienne'; 
                var parameters = "tri="+tri+"&offset="+offsetC;
                $.post("assets/ajax/select.php", parameters, function(data){
                    $('#details').append(data.resultat); 
                    incOffset();
                }, 'json');
            break;
            case 'Tous les membres':
                var membre = 'Tous les membres'; 
                var parameters = "membre="+membre+"&offset="+offsetC; 
                $.post("assets/ajax/select.php", parameters, function(data){
                    $('#details').append(data.resultat); 
                    incOffset();
                }, 'json');
            break;
            case "Toutes les villes":
                var ville = "Toutes les villes"; 
                var parameters ="ville="+ville+"&offset="+offsetC;   
                $.post("assets/ajax/select.php", parameters, function(data){
                    $('#details').append(data.resultat); 
                    incOffset();
                }, 'json');
            break;
        }
    });
    

    
});


