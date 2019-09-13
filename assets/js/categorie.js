
//on selectionné le dom auquel on associe la methode ready(), la fonction sexecutera lorske le dom sera chargé completement
$(document).ready(function(){
    $('.btn-categorie').click(function(event){
        event.preventDefault();  
        ajax();
    });

    function ajax()
    { 
        var categorie = $detail['id_categorie'].val();//on crée une variable pr recup l'id selectionné
        //on recupere le contenu de l'attribut value du selecteur , donc l'id de l'employe



        var parameters = "id_categorie="+categorie;//on definit les parametres a envoyes avec la requetes ajax "aller"
        //on transmet a la requete à la fois l'id et le prenom 
        //le signe & permet dajouter des parametres a la requete


 

        $.post("categorie.php", parameters, function(data){
            //je selectionne la div employe et on ecrase le selecteur par le selecteur mis a jour ds ajax3.php
            $('#resultat').html(data.resultat);
        }, 'json');
    }


});

