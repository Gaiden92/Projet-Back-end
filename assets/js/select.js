$(function(){
    $('#submit').change(function(){
        event.preventDefault();
       var id = $(this).val();

       if (id != ''){

        $.get(
            '/assets/ajax/select.php',
            'id=' =id,
            function(response){
                $('#detail').html(response);
            });
       }else{
        $('#detail').html('');
       }
    });
});
