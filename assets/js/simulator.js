import "../libs/sweetalert/sweetalert.min.js";

const SLOTS_PER_REEL = 10;
// radius = Math.round( ( panelWidth / 2) / Math.tan( Math.PI / SLOTS_PER_REEL ) ); 
// current settings give a value of 149, rounded to 150
const REEL_RADIUS = 150;

function createSlots (ring) {
	
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

		var content = $(slot).append('<p>' + ((seed + i)%10)+ '</p>');

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
	for(var i = 1; i < 5; i ++) {
		var oldSeed = -1;
		/*
		checking that the old seed from the previous iteration is not the same as the current iteration;
		if this happens then the reel will not spin at all
		*/
		var oldClass = $('#ring-'+i).attr('class');
		if(oldClass.length > 4) {
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

$(document).ready(function() {
	$('.searching_series').hide();
	$('.pricing_and_fractions').hide();
	
	// initiate slots 
 	createSlots($('#ring-1'));
 	createSlots($('#ring-2'));
 	createSlots($('#ring-3'));
 	createSlots($('#ring-4'));

 	// hook start button
 	$('#btn-play').on('click',function(){
		$('.ring div p').removeClass('winner-number');
		$('.btn-purchase').addClass('invisible');
		var timer = 2;
		spin(timer);
		setTimeout(function(){
			perform_roulette();
		}, 6000);
	});

	function perform_roulette(){
		$.ajax({
			url: "Main/get_random_draw_number",
		})
		.done(function( data ) {
			var result = jQuery.parseJSON(data);
			var numbers = result.number.split('');
			var series = result.serie.split('');
			$('.ring').css('animation', '');
			for(var i = 1; i <= 4; i ++) {
				$('#ring-' + i + ' div:nth-child(1) p').html(numbers[i - 1]);
				$('#ring-' + i + ' div:nth-child(1) p').addClass('winner-number');
			}
			$('.serie-1').html(series[0]);
			$('.serie-2').html(series[1]);
			$('.serie-3').html(series[2]);
			$('.btn-purchase').attr('number', result.number);
			$('.btn-purchase').attr('serie', result.serie);
			$('.btn-purchase').attr('date', result.draw.date);
			$('.btn-purchase').attr('draw_number', result.draw.draw_number);
			$('.btn-purchase').attr('fractions_count', result.draw.fractions_count);
			$('.btn-purchase').attr('fractions_value', result.draw.fraction_value);
			$('.btn-purchase').attr('bill_value', (result.draw.fraction_value * result.draw.fractions_count));
			$('.btn-purchase').removeClass('invisible');
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
 });

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


function try_to_buy(btn) {
	var number = btn.getAttribute('number');
	var serie = btn.getAttribute('serie');
	var date = btn.getAttribute('date');
	var draw_number = btn.getAttribute('draw_number');
	var fractions_count = btn.getAttribute('fractions_count');
	var fractions_value = btn.getAttribute('fractions_value');
	var bill_value = btn.getAttribute('bill_value');
	var d = new Date(date);
	date = d.getDate()  + "/" + (d.getMonth()+1) + "/" + d.getFullYear() + " " ;

	var content = "<div class='buying'><div><label>Numero</label><p class='number-confirm'>" + number + "</p></div><div><label>Serie</label><p class='serie-confirm'>" + serie + "</p></div><div><label>Sorteo</label><p class='serie-confirm'>" + draw_number + "</p></div><div><label>Fecha de sorteo</label><p class='fecha-confirm'>" + date +"</p></div></div>";
	content += "<div class='buying-total w-100'><div>Cantidad de fracciones: <strong>" + fractions_count +"</strong></div><div>Valor de cada fracción: <strong>$" + fractions_value +"</strong></div><div class='mt-2'>Valor total de la compra: <strong>$" + bill_value +"</strong></div></div>";
	swal({
					title: '¿Deseas hacer esta compra?',
					html: true,
					text: content,
					showCancelButton: true,
					confirmButtonText: 'Si, comprar!',
					closeOnConfirm: false,
					showLoaderOnConfirm: true
			},
			function() {
				window.location.href = 'Main/set_session_draw_number/' + number + '/' + serie;
			});
}




set_card_lotto_height();