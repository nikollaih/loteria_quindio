import "../libs/sweetalert/sweetalert.min.js";

var SLOTS_PER_REEL = 8;
// radius = Math.round( ( panelWidth / 2) / Math.tan( Math.PI / SLOTS_PER_REEL ) ); 
// current settings give a value of 149, rounded to 150
const REEL_RADIUS = 150;

var current_user = '';
var lotto_points = 0;

var products = [];
// var products = [
//   {
//     id_game_product: 111,
//     g_product_path: "https://images.unsplash.com/photo-1581235720704-06d3acfcb36f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 281,
//     g_product_path:  "https://images.unsplash.com/photo-1593642532973-d31b6557fa68?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 333,
//     g_product_path:  "https://images.unsplash.com/photo-1587840171670-8b850147754e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 444,
//     g_product_path: "https://images.unsplash.com/photo-1583312708610-fe16a34b0826?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 555,
//     g_product_path: "https://images.unsplash.com/photo-1542144761-531051972ae0?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 666,
//     g_product_path: "https://images.unsplash.com/photo-1600375226700-5ce19fbe1a6f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 777,
//     g_product_path: "https://images.unsplash.com/photo-1587145717184-e7ee5311253d?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   },
//   {
//     id_game_product: 888,
//     g_product_path: "https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
//   }
// ];

function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
  }

  return array;
}


function createSlots (ring) {
  var shufle_products = shuffleArray(products);
	var slotAngle = 360 / SLOTS_PER_REEL;

	var seed = getSeed();

	for (var i = 0; i < SLOTS_PER_REEL; i ++) {
		var slot = document.createElement('div');
		
		slot.className = 'slot';

		// compute and assign the transform for this slot
		var transform = 'rotateX(' + (slotAngle * i) + 'deg) translateZ(' + REEL_RADIUS + 'px)';

		slot.style.transform = transform;

		// setup the number to show inside the slots
		// the position is randomized to 

		if(i >= shufle_products.length){
			var random = Math.floor(Math.random()*(shufle_products.length));
			$(slot).append('<img src="../' + shufle_products[random].g_product_path + '" class="image-' + shufle_products[random].id_game_product +'"></img>');
		}else {
			$(slot).append('<img src="../' + shufle_products[i].g_product_path + '" class="image-' + shufle_products[i].id_game_product +'"></img>');
		}
		// add the poster to the row
		ring.append(slot);
	}
}

function getSeed() {
	// generate random number smaller than 13 then floor it to settle between 0 and 12 inclusive
	return Math.floor(Math.random()*(SLOTS_PER_REEL));
}

function spin(timer) {
	//var txt = 'seeds: ';
	for(var i = 1; i < 4; i ++) {
		var oldSeed = -1;
		/*
		checking that the old seed from the previous iteration is not the same as the current iteration;
		if this happens then the reel will not spin at all
		*/
		var oldClass = $('#ring-'+i).attr('class');
		if(oldClass.length > 3) {
			oldSeed = parseInt(oldClass.slice(10));
		}
		var seed = getSeed();
		while(oldSeed == seed) {
			seed = getSeed();
		}

		$('#ring-'+i)
			.css('animation','back-spin 3s, spin-' + seed + ' ' + (timer + i*0.5) + 's infinite')
			.add('ring spin-' + seed);
	}
}

function initialize_game(){

	// initiate slots 
 	createSlots($('#ring-1'));
 	createSlots($('#ring-2'));
 	createSlots($('#ring-3'));

 	// hook start button
 	$('#btn-play').on('click',function(){
		$('#btn-play').hide();
		var timer = 2;
		spin(timer);
	
		setTimeout(function(){
			fetchDataForGame();
		}, 6000);
 	
	})
	 

	function fetchDataForGame(){
		$.ajax({
			url: "../GameProducts/get_result_for_game",
			type: 'POST',
			data: { products: products, user: current_user },
		})
		.done(function( data ) {
      var result = jQuery.parseJSON(data);
			lotto_points = result['lotto_points'];
			$('.ring').css('animation', '');
			if(lotto_points > 0) {
        var won = result['won'];

        if(won == false) {
          var suffle_products = shuffleArray(products);
          var selected = [suffle_products[1], suffle_products[2], suffle_products[3]];
          for(var i = 1; i <= 3; i ++) {
            $('#ring-' + i + ' div:nth-child(1)').html('');
            $('#ring-' + i + ' div:nth-child(1)').append('<img src="../' + suffle_products[i].g_product_path + '" class="image-' + suffle_products[i].id_game_product +'"></img>');
          }
          not_won(selected);
        }else{
          var product = result['ids'][0];
          var img = '';
          for (var i = 0; i < products.length; i ++) {
            if(products[i].id_game_product == product){
              img = products[i].g_product_path;
            }
          }
          for(var i = 1; i <= 3; i ++) {
            $('#ring-' + i + ' div:nth-child(1)').html('');
            $('#ring-' + i + ' div:nth-child(1)').append('<img src="../' + img + '" class="image-' + product +'"></img>');
          }

          $.ajax({
            url: "../GameProducts/validate_result_for_game",
            method: 'POST',
            data: { salt: result['salt'], product: product, user: current_user }
          })
          .done(function( data ) {
            var result = jQuery.parseJSON(data);
            
            if(result['result'] == true){
              winner(img);
            }
          });
        }
      }else{
        not_points();
      }

			$('#btn-play').show();
		});
	}
	$('#btn-stop').on('click',function(){
		$('.ring').css('animation', '');
	})

 	// hook xray checkbox
 	$('#xray').on('click',function(){
 		//var isChecked = $('#xray:checked');
 		var tilt = 'tiltout';
 		
    if($(this).is(':checked')) {
 			tilt = 'tiltin';
 			$('.slot').addClass('backface-on');
 			$('#rotate').css('animation',tilt + ' 2s 1');

			setTimeout(function(){
			  $('#rotate').toggleClass('tilted');
			},2000);
 		} else {
      tilt = 'tiltout';
 			$('#rotate').css({'animation':tilt + ' 2s 1'});

			setTimeout(function(){
	 			$('#rotate').toggleClass('tilted');
	 			$('.slot').removeClass('backface-on');
	 		},1900);
 		}
 	})

 	// hook perspective
 	$('#perspective').on('click',function(){
 		$('#stage').toggleClass('perspective-on perspective-off');
 	})	
 }

jQuery(document).on("click", ".btn-purchase", function() {
	try_to_buy(this);
});

function set_card_lotto_height() {
	var cw = $('.card-loto').first().width();
	$('.card-loto').css({'height':cw+'px'});
}

$(window).resize(function() {
	set_card_lotto_height();
});


function not_points(){
  swal({
    title: 'No tienes intentos disponibles.',
    showCancelButton: false,
    confirmButtonText: 'Volver a inicio',
    showLoaderOnConfirm: true
  },
  function() {
    window.location.href = '../Panel';
  });
}

function not_won(selected){
	$('#btn-play').hide();
  var images = "<div class='images'><img src='../" + selected[0].g_product_path +"'></img><img src='../" + selected[1].g_product_path +"'></img><img src='../" + selected[2].g_product_path +"'></img></div>"
  var tries = "<div class='tries'>Te quedan " + (lotto_points - 1) +" intentos.</div>"
  var content = "<div class='game-modal'><div class='title'></div>" + images +  tries +"</div>";
  var play_again = false;
  if(lotto_points > 1) { play_again = true; }
	swal({
      title: '¡Intentalo de nuevo!',
      html: true,
      text: content,
      showCancelButton: play_again,
      cancelButtonText: 'Jugar de nuevo',
      confirmButtonText: 'Volver a inicio',
      closeOnConfirm: false,
			showLoaderOnConfirm: true,
			showLoaderOnCancel: true
  },
  function(goToHome) {
    if (goToHome) {
			window.location.href = '../Panel';
		} else {
			$('#btn-play').hide();
			$.ajax({
				url: "../GameProducts/get_products_for_game",
				beforeSend: function( xhr ) {
			
				}
			})
			.done(function( data ) {
				var result = jQuery.parseJSON(data);
				
				current_user = result.current_user;
				products = result.products;
				if(products.length < 4) {
					not_products();
				}
				$('#btn-play').show();
			});
		}
	});

	
}

function not_products(){
	var content = "<div class='game-modal'><div class='title'>No hay productos para sortear.</div><br/><br/><p>Te estamos redireccionando al inicio...</p></div>";
	swal({
      title: '¡Lo sentimos!',
      html: true,
      text: content,
			showCancelButton: false,
			showConfirmButton: false,
      cancelButtonText: 'Jugar de nuevo',
      confirmButtonText: 'Volver a inicio',
      closeOnConfirm: false,
      showLoaderOnConfirm: true
  },
  function() {
    window.location.href = '../Panel';
	});
	
	setTimeout(function(){
		window.location.href = '../Panel';
 	}, 5000);
}

function winner(img){
  var images = "<div class='images'><img src='../" + img +"'></img><img src='../" + img +"'></img><img src='../" + img +"'></img></div>"
  var winner = "<br/><br/><div class='winner'>Ganaste este producto, nos comunicaremos contigo para coordinar el proceso de entrega, gracias por hacer parte de nosotros.</div>"
  var content = "<div class='game-modal'><div class='title'></div>" + images + winner  +"<br/><br/><p>Te estamos redireccionando a tus premios...</p></div>";
	swal({
      title: '¡Felicidades!',
      html: true,
      text: content,
			showCancelButton: false,
			showConfirmButton: false,
      cancelButtonText: 'Jugar de nuevo',
      confirmButtonText: 'Volver a inicio',
      closeOnConfirm: false,
      showLoaderOnConfirm: true
  },
  function() {
    window.location.href = '../Panel';
	});
	
	setTimeout(function(){
		window.location.href = '../games/my_rewards';
 	}, 7000);
}


function set_products() {
	$('#btn-play').hide();
	$.ajax({
		url: "../GameProducts/get_products_for_game",
		beforeSend: function( xhr ) {
	
		}
	})
	.done(function( data ) {
    var result = jQuery.parseJSON(data);
    
    current_user = result.current_user;
		products = result.products;
		if(products.length < 4) {
			not_products();
		}
		initialize_game();
		$('#btn-play').show();
	});
}

$(document).ready(function() {
	set_card_lotto_height();
	set_products();
});

