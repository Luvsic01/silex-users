$(function () {

    showAllUsers();

    // Lors de l'event submit sur le formulaire
    $('form').on('submit', function (e) {
        // On stop l'event
        e.preventDefault();
        // On serialize les données du formulaire à envoyer en ajax
        var dataForm = $(this).serialize();
        // On séléctionne la div d'info
        var infoFormulaire = $('.infoFormulaire');
        //On lance l'appel ajax
        $.ajax({
            url: "admin/user",
            method: "POST",
            data: dataForm, // On envoie les données serializé
            dataType: "JSON" // On récupère du json
        })
            .done(function (data) { // Si pas d'erreur lors de l'appel ajax
                // Si code 1 tout ok on affiche le message ok
                infoFormulaire.html(data.message).fadeIn().addClass('valid');
            })
            .fail(function (data) { // Si erreur lors de l'appel ajax on l'affiche dans la div info
                infoFormulaire.html(data.responseJSON.message).removeClass('valid').fadeIn();
            });
    });




    function showAllUsers() {
        $.ajax({
            url: "admin/users",
            method: "GET",
            dataType: "json" // On récupère du json
        })
            .done(function (data) { // Si pas d'erreur lors de l'appel ajax
                var tableUserList = $('.usersList').find('tbody');
                tableUserList.html('');
                $.each(data, function (key, value) {
                    tableUserList.append('<tr>');
                    tableUserList.append('<td>' + value.id + '</td>');
                    tableUserList.append('<td>' + value.firstname + '</td>');
                    tableUserList.append('<td>' + value.lastname + '</td>');
                    tableUserList.append('<td>' + '<input class="deleteBtn" type="submit" value="Delete" data-id="' + value.id + '">' + '</td>');
                    tableUserList.append('</tr>');
                });

                $('.deleteBtn').on('click', function () {
                    var id = $(this).data('id');
                    console.log(id);
                });
            })
    }


}); // Fin JQUERY