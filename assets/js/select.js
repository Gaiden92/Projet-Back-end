

$(document).ready(function(){
    $('#submit').change(function(event){
        //event.preventDefault();  
        ajax();
    });

    function ajax()
    { 
        var categorie = $('#categorie').val();

        var parameters = "categorie="+categorie;

        $.post("assets/ajax/select.php", parameters, function(data){

            $('#detail').html(data.resultat);
            
        }, 'json');
    }


});