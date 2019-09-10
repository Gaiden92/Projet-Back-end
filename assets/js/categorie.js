$(function () {


    $('.btn-categorie').click(function () {
            $.get(
                '/../assets/ajax/categorie.php',
                'id=' + $(this).data('id_categorie'),

                function (response) {
                    $('#detail').html(response);
                }

            );
        });

});

