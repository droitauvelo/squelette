

questionList = '<div class="result">' +
    '<table class="table table-hover">' +
    '{{#questions}}' +
    '<tr><td><a href="{{url}}">{{ titre }}</a></td><td>{{ nature }}</td></tr>' +
    '{{/questions}}' +
    '</table>' +
    '</div>';





var data_lunr_loaded = false;

var index = lunr(function () {

    this.use(lunr.fr);
    this.field('titre', {boost: 10})
    this.field('mots')
    this.ref('id')

});



function calcule_url(ref, nature) {

    if (parseInt(ref) > 0) {

        if (nature == 'rubrique')
            return url_rubrique + ref
        else
            return url_article + ref

    }
    return '';
}






var renderQuestionListRecherche = function (qs) {
    if (qs) {

        truc = $("input#recherche").val()

        $("#result_recherche_acces_rapide")
            .empty()
            .append(Mustache.to_html(questionList, {questions: qs}))
        if (truc != ''){
            $("#result_recherche_acces_rapide").append('<div class="lien_recherche"><a  class="btn btn-primary btn-block" href="'+url_recherche+ truc +'">Rechercher "' + truc + '" dans l\'ensemble du site</a></div>')
            $(".lunr-submit").remove();
        }


    }
}




function charge_data_lunr(){

    if (!data_lunr_loaded){

        $.getJSON(  url_lunr_data, function( data ) {

            data_lunr_loaded=true;
            var longueur = data.length;
            for (i = 0; i < longueur; i++) {
                index.add(data[i]);
            }


            var debounce = function (fn) {
                var timeout
                return function () {
                    var args = Array.prototype.slice.call(arguments),
                        ctx = this

                    clearTimeout(timeout)
                    timeout = setTimeout(function () {
                        fn.apply(ctx, args)
                    }, 200)
                }
            };


            $('input#recherche').bind('keyup', debounce(function () {
                console.log('dddd');
                results = index.search($(this).val()).slice(0, 8).map(function (result) {
                    truc = data.filter(function (q) {
                        return q.id == parseInt(result.ref, 10)
                    })[0]
                    truc['url'] = calcule_url(result.ref, truc['nature'])
                    if ( truc['titre'].length>80)
                        truc['titre']=truc['titre'].substring(0,77)+'...'
                    return truc
                })

                renderQuestionListRecherche(results)
            }))




        });
    }
}





$(document).ready(function () {

    $('input#recherche').after('<div id="result_recherche_acces_rapide"></div>');
    $('input#recherche').focus(charge_data_lunr);


});



