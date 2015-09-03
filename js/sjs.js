

$(document).ready(function(){
	
	
	
 $(".panneau").each(function(i){
	 var id_menu=$(this).attr('id');
	 var nav =$('#nav')
	 $('.mini_menu',this).append($('.bouton_'+id_menu+' ul',nav))
	 
	 $('.bouton_'+id_menu).append($(this));
	 $('.bouton_'+id_menu).hover(function(event){
		 if($(window).width()>768){
		 	$(this).addClass("hover");
			var position = $(this).position();
			$('#'+id_menu).css('left',position.left/2);
			$('#'+id_menu).stop(true,true).delay(20).slideDown();
		}
		},function(event){
			if($(window).width()>768){
			$(this).removeClass("hover");
			$('#'+id_menu).stop(true,true).delay(200).slideUp("fast");
			}
		});

 });
 $('.bloc_contact .texte_suppl').hide();
$('.bloc_contact').hover(function(){
	$('span',this).stop().animate({'line-height':1.2,'font-size':'0.9em','margin-left':'0.5em','margin-right':'0.5em'});
	$('.bloc_contact .texte_suppl').stop().fadeIn();

	},
	function(){
	$('span',this).stop().animate({'line-height':2.5,'font-size':'1em','margin-left':'0em','margin-right':'0em'});
	$('.bloc_contact .texte_suppl').stop().fadeOut();

	}
	
	
	
	
	);
	
	$('.carousel').carousel()
//$('#contenu img').ImageOverlay();
})



