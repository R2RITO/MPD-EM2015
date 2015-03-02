$(document).ready(function(){
	
	var actualPage = document.getElementsByClassName("nav-active")[0];

	$(".main").slideDown(500);
	
	$(".extra").prepend("<div class='exit'><a href='#'><span class='fa fa-angle-left fa-lg icon'></span><span>Regresar</span></a></div>");
	
	// Nav activo
	$(".nav a").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(this).parent().addClass("nav-active");
	});
	
	// Main
	$(".main-button").click(function(){
		$(".content").slideUp(500);
		$(".main").delay( 500 ).slideDown(500);	
	});
	
	// Mensajes de usuario
	$(".message-button").click(function(){
		$(".content").slideUp(500);
		$(".message").delay(500).slideDown(500);	
	});

	// Agregar lenguaje
	$(".language-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".add-language").delay( 500 ).slideDown(500);
	});
	
	// Agregar amigo
	$(".friend-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".add-friend").delay( 500 ).slideDown(500);
	});	

	// Ver vocabulario
	$(".voc-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".practice-voc").delay( 500 ).slideDown(500);
	});	

	// Ver repaso de lecciones
	$(".repass-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".practice-lesson").delay( 500 ).slideDown(500);
	});	

	// Aprender lección
	$(".lesson-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".learn").delay( 500 ).slideDown(500);
	});	


	// Abrir discusión
	$(".to-be-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".to-be").delay( 500 ).slideDown(500);
	});	


	// Iniciar discusion
	$(".add-dis-button").click(function(){
		$(".nav-active").removeClass("nav-active");
		$(".content").slideUp(500);	
		$(".add-discussion").delay( 500 ).slideDown(500);
	});	
	
	// Cerrar extras
	$(".exit").click(function(){
		$(".nav-main").addClass("nav-active");
		$(".content").slideUp(500);	
		$(".main").delay(500).slideDown(500);
	});	
	
	// Unidad activa
	$(".unit").click(function(){
		$(".unit-active").removeClass("unit-active");
		$(this).addClass("unit-active");
	});
	
	// Unidades básicas
	$(".unit-basic").click(function(){
		$(".lessons").slideUp(500);
		$(".lesson-basic").delay(500).slideDown(500);	
	});

	// Unidades media
	$(".unit-mid").click(function(){
		$(".lessons").slideUp(500);
		$(".lesson-mid").delay(500).slideDown(500);	
	});

	// Unidades avanzada
	$(".unit-hard").click(function(){
		$(".lessons").slideUp(500);
		$(".lesson-hard").delay(500).slideDown(500);	
	});
	
	// Follow y Unfollow
	$(".follow, .unfollow").click(function(){
		$(this).toggleClass("follow");
		$(this).toggleClass("unfollow");
		$(this).text( $(this).text() == "Seguir" ? "Siguiendo" : "Seguir");
	});
	
	// Like Dislike
	$(".point").each(function(){
		var p = $(this);
		var pts = p.find(".pts");
		var count = parseInt(pts.text(),10);
		var up = p.find(".up");
		var down = p.find(".down");
		
		up.click(function(){			
			if (up.hasClass("on")) {
				pts.text(count);
				up.removeClass("on");				
			} else {
				pts.text(count+1);
				up.addClass("on");
				down.removeClass("on");				
			}
		});
		
		down.click(function(){
			if (down.hasClass("on")) {
				pts.text(count);
				down.removeClass("on");				
			} else {
				pts.text(count-1);
				down.addClass("on");
				up.removeClass("on");				
			}			
		});
	});
	
	// Resultados
	$(".new-check").click(function(){
		$(".new").slideToggle(500);
	});
	$(".pop-check").click(function(){
		$(".pop").slideToggle(500);
	});
	$(".follow-check").click(function(){
		$(".following").slideToggle(500);
	});
	$(".my-check").click(function(){
		$(".my").slideToggle(500);
	});
	$(".en-check").click(function(){
		$(".en").slideToggle(500);
	});
	$(".fr-check").click(function(){
		$(".fr").slideToggle(500);
	});


	$(".btn1").click(function(){
		$(".btns1").slideUp(200);
		$(".ans1, .cont1").delay(200).slideDown(200);
	});
	$(".btn2").click(function(){
		$(".btns2").slideUp(200);
		$(".ans2, .cont2").delay(200).slideDown(200);
	});
	$(".btn3").click(function(){
		$(".btns3").slideUp(200);
		$(".ans3, .cont3").delay(200).slideDown(200);
	});
	$(".btn4").click(function(){
		$(".btns4").slideUp(200);
		$(".ans4, .cont4").delay(200).slideDown(200);
	});
	$(".btn5").click(function(){
		$(".btns5").slideUp(200);
		$(".ans5, .cont5").delay(200).slideDown(200);
	});
	$(".btn6").click(function(){
		$(".btns6").slideUp(200);
		$(".ans6, .cont6").delay(200).slideDown(200);
	});

	$(".cont1").click(function(){
		$(".part1").slideUp(200);
		$(".part2").delay(200).slideDown(200);
	});
	$(".cont2").click(function(){
		$(".part2").slideUp(200);
		$(".part3").delay(200).slideDown(200);
	});
	$(".cont3").click(function(){
		$(".part3").slideUp(200);
		$(".part4").delay(200).slideDown(200);
	});
	$(".cont4").click(function(){
		$(".part4").slideUp(200);
		$(".part5").delay(200).slideDown(200);
	});
	$(".cont5").click(function(){
		$(".part5").slideUp(200);
		$(".part6").delay(200).slideDown(200);
	});
	$(".cont6").click(function(){
		$(".part6").slideUp(200);
		$(".finish").delay(200).slideDown(200);
	});

});