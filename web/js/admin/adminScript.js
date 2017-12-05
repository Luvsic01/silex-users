$(function () {

    addListenerBtnDelete();

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
                addViewNewUser(data.user);
                addListenerBtnDelete();
            })
            .fail(function (data) { // Si erreur lors de l'appel ajax on l'affiche dans la div info
                infoFormulaire.html(data.responseJSON.message).removeClass('valid').fadeIn();
            });
    });

    function addListenerBtnDelete() {
        $('.deleteBtn').on('click', function () {
            var id = $(this).data('id');
            var input = $(this);
            $.ajax({
                url: "admin/user/" + id,
                method: "DELETE"
            })
                .done(function (data) {
                    input.parent().parent().hide();
                })
        });
    }

    function addViewNewUser(user) {
        var tableUserList = $('.usersList').find('tbody');
        tableUserList.append(
            '<tr>' +
            '<td>' + user.id + '</td>' +
            '<td>' + user.firstname + '</td>' +
            '<td>' + user.lastname + '</td>' +
            '<td>' + user.username + '</td>' +
            '<td>' + user.roles + '</td>' +
            '<td> <input class="deleteBtn" type="submit" value="Delete" data-id="' + user.id + '"> </td> </tr>'
        );
    }

}); // Fin JQUERY