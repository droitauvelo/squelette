function initialisation_modal_event(conteneur) {

    if (conteneur == undefined)
        conteneur = 'body';

    conteneur = $(conteneur);


    $('a[data-event]', conteneur).click(function (ev) {


        modal_event = $('#modal_evt')
        if (!$(modal_event).length) {
            $('body').append('' +
                '<div class="modal fade" id="modal_evt" tabindex="-1" role="dialog" aria-labelledby="modal_evt_label">' +
                '<div class="modal-dialog modal-lg">' +
                '<div class="modal-content">' +
                '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<h4 class="modal-title">Évenement</h4>' +
                '</div>' +
                '<div class="modal-body"></div>' +
                '</div><!-- /.modal-content -->' +
                '</div><!-- /.modal-dialog -->' +
                '</div><!-- /.modal -->')
            modal_event = $('#modal_evt')

        }

        $("#modal_evt .modal-body").load($(this).attr('data-event'), function (response, status, xhr) {
            if (status == "error") {
            } else {
                $('#modal_evt').modal('show');


                $(modal_event).modal({show: true});

            }
        });
        return false;
    });

}


$(document).ready(function () {


    jQuery("#responsive-menu-button").sidr({
        name: "sidr-main",
        source: "#menuhaut .navbar"
    });

    $('#sonnette').hover(function () {
        ion.sound.play("sonnette");

    })


    ion.sound({
        sounds: [
            {
                name: "sonnette"
            }
        ],
        volume: 0.5,
        path: "/squelettes/son/"
    });


    $('[data-toggle="tooltip"]').tooltip();
    $('#bouton_recherche').tooltip();

    largeur_fenetre = $(window).width();
    largeur_page = $('.page').width();

    $(".panneau").each(function (i) {

        var id_menu = $(this).attr('id');
        var nav = $('#nav');
        $('.mini_menu', this).append($('.bouton_' + id_menu + ' ul', nav));

        $('.bouton_' + id_menu).append($(this)).hover(function (event) {

            if (largeur_fenetre > 992) {
                $(this).addClass("hover");
                var position = $(this).position();
                largeur_panneau = $(this).children('.panneau').width();

                if (largeur_page < (position.left + largeur_panneau)) {
                    largeur_container = $('.page .container').width();

                    posx = largeur_container - ( largeur_panneau) - 15;
                    $('#' + id_menu).css('left', posx);
                }

                $('#' + id_menu).stop(true, true).delay(20).slideDown();
            }
        }, function (event) {
            if (largeur_fenetre > 992) {
                $(this).removeClass("hover");
                $('#' + id_menu).stop(true, true).delay(200).slideUp("fast");
            }
        });

    });

    $('.bloc_contact .texte_suppl').hide();





    if (largeur_fenetre<768){
        $("#haWidget").css('height','2500px');
    }



    $('.bloc_contact').hover(function () {
            $('span', this).stop().animate({
                'margin-top': '2px',
                'line-height': 1.2,
                'font-size': '0.9em',
                'margin-left': '0.5em',
                'margin-right': '0.5em'
            });
            $('.bloc_contact .texte_suppl').stop().fadeIn();

        },
        function () {
            $('span', this).stop().animate({
                'margin-top': '1em', 'line-height': 2.5, 'font-size': '1em', 'margin-left': '0em', 'margin-right': '0em'
            });
            $('.bloc_contact .texte_suppl').stop().fadeOut();

        }
    );


    $('.carousel').carousel({interval: 5000})
    $('.carousel .item .carousel-caption a').each(function () {
        item = $(this).parents('.carousel  .item');
        $('>img', item).wrap('<a href="' + $(this).attr('href') + '"></a>')


    });

    initialisation_modal_event();


});








