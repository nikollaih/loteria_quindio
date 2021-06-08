<link rel="stylesheet" href="<?= base_url() ?>assets/css/powerball.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/floating-wpp.min.css">

<style>
	body {
		background: url(<?= base_url().get_setting("main_background") ?>);
		background-size: cover;
    background-position: center;
	}

	.btn-wpp{
		position: fixed;
		right: 30px;
		bottom: 30px;
		z-index: 100;
		cursor: pointer;
		animation: float 800ms infinite alternate;
	}

	@keyframes float {
  from {
    bottom: 30px;
  }
  to {
    bottom: 40px;
  }
}
</style> 
<div id="WAButton"></div>  
<!-- <div class="btn-wpp">
        <a href="https://api.whatsapp.com/send?phone=57<?= get_setting("whatsapp_number") ?>" target="_blank"><img style="margin-right: 5px;" width="50px" src="<?= base_url() ?>assets/images/whatsapp_icon.png" alt="Whatsapp icon" srcset=""></a>
    </div> -->

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="header">
				<div class="header-item text-center">
          <img class="text-center logo" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
				</div>
				
				<div class="header-item">
					|
					<a href="<?php echo (isset($this->session->userdata("logged_in")["first_name"])) ? base_url() . 'panel' : base_url() . 'usuarios/login' ?>" class="btn btn-link" type="submit"><?php echo (isset($this->session->userdata("logged_in")["first_name"])) ? "Ir al inicio" : "Iniciar sesión" ?></a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h1 class="title"></h1>
		</div>
	</div>
	<div class="row not-lucky">
		<div class="col-md-12">
			<div class="roulette">
				<div class="label-title">¡Elige un número y gana!</div>
				<div class="card-form">
					<div class="searching_series">
						Buscando series...
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail4">Número de 4 digitos</label>
							<input type="number"  onKeyUp="if(this.value.length==4){ searchSerieByNumber(this.value);}" onKeyPress="if(this.value.length==4){ return false; }" min="0" max="9999" class="form-control" id="number-not-lucky" placeholder='0000'>
						</div>
						<div class="form-group col-md-6">
							<label for="inputPassword4">Serie</label>
							<select name="serie_input" onChange="setBuyForNotLucky(this.value);" id="serie_input" class="form-control">
								<option disabled selected value>...</option>
							</select>
						</div>
					</div>
				</div>
				<div class="pricing_and_fractions">
					<div class="fractions">Cantidad de fracciones: <strong class="fractions_count_not_lucky"></strong></div>
					<div class="pricing">Total: <strong class="bill_value_not_lucky"></strong></div>
				</div>
				<div class="get-lucky-container">
					Tambien puedes
					<button class="btn get-lucky mr-4" onClick="getLucky()">Probar suerte</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row lucky" id="rotate">
		<div class="col-md-12">
		
			<div class="roulette">
				
				<div class="card-loto">
					<div class="board">
						<div class="right-arrow"></div>
						<div class="left-arrow"></div>
						<div class="top-shadow"><div class="line"></div></div>
						<div class="content-board reel">
							<div class="numbers ring" id="ring-1">
							</div>
						</div>
						<div class="bottom-shadow"><div class="line"></div></div>
					</div>
				</div>	
				<div class="card-loto">
					<div class="board">
						<div class="right-arrow"></div>
						<div class="left-arrow"></div>
						<div class="top-shadow"><div class="line"></div></div>
						<div class="content-board reel">
							<div class="numbers ring" id="ring-2">
							</div>
						</div>
						<div class="bottom-shadow"><div class="line"></div></div>
					</div>
				</div>
				<div class="card-loto">
					<div class="board">
						<div class="right-arrow"></div>
						<div class="left-arrow"></div>
						<div class="top-shadow"><div class="line"></div></div>
						<div class="content-board reel">
							<div class="numbers ring" id="ring-3">
							</div>
						</div>
						<div class="bottom-shadow"><div class="line"></div></div>
					</div>
				</div>	
				<div class="card-loto">
					<div class="board">
						<div class="right-arrow"></div>
						<div class="left-arrow"></div>
						<div class="top-shadow"><div class="line"></div></div>
						<div class="content-board reel">
							<div class="numbers ring" id="ring-4">
							</div>
						</div>
						<div class="bottom-shadow"><div class="line"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-end lucky">
		<div class="col-md-6">
			<div class="get-not-lucky-container d-flex align-items-center">
				Tambien puedes
				<button class="btn get-lucky mr-4" onClick="getNotLucky()">Elegir número</button>
			</div>
		</div>
		<div class="col-md-6">
			<div class="series">
				<div class="label">
					<div class="serie-title">
						Serie
					</div>
				</div>
				<div class="round serie-1">
					0
				</div>
				<div class="round serie-2">
					0
				</div>
				<div class="round serie-3">
					0
				</div>
			</div>
		</div>
	</div>
	<div class="row justify-content-center lucky">
		<div class="col-md-6  d-flex justify-content-center">
			<div class="text-center">
				<button class="btn btn-yellow btn-simulator invisible btn-purchase mr-4"><i data-feather="shopping-cart" class="mr-2"></i>  Comprar</button>
				<button class="btn btn-success  btn-simulator" id="btn-play"><i data-feather="repeat" class="mr-2"></i> Dame suerte</button>
			</div>
		</div>
	</div>
	<div class="row justify-content-center not-lucky">
		<div class="col-md-6  d-flex justify-content-center">
			<div class="text-center">
			<button class="btn btn-yellow btn-simulator invisible btn-new-search mr-4" onClick="resetFormForNotLucky()"><i data-feather="x-circle" class="mr-2"></i>Elegir nuevo</button>
				<button class="btn btn-yellow btn-simulator invisible btn-purchase mr-4"><i data-feather="shopping-cart" class="mr-2"></i>  Comprar</button>
			</div>
		</div>
	</div>
	<div class="p-3">
		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6 text-right">
					<a href="https://www.placetopay.com/web" target="_blank"><img width="120" src="https://static.placetopay.com/placetopay-logo-dark-background.svg" alt="PlaceToPay" srcset=""></a>
			</div>
		</div>
	</div>
</div>

<script type="module" src="<?= base_url().'assets/js/vendor.min.js' ?>"></script>
<script type="module" src="<?= base_url().'assets/js/app.min.js' ?>"></script>
<script type="module" src="<?= base_url().'assets/js/simulator.js' ?>"></script>
<script type="module" src="<?= base_url().'assets/js/floating-wpp.min.js' ?>"></script>
<script type="module">  
  jQuery(function () {
		jQuery('#WAButton').floatingWhatsApp({
			phone: '57<?= get_setting("whatsapp_number") ?>', //WhatsApp Business phone number
			headerTitle: '¡Bienvenido!', //Popup Title
			popupMessage: '¿Como podemos ayudarte? Escribenos.', //Popup Message
			showPopup: true, //Enables popup display
			buttonImage: '<img src="assets/images/whatsapp.svg" />', //Button Image
			//headerColor: 'crimson', //Custom header color
			//backgroundColor: 'crimson', //Custom background button color
			position: "right" //Position: left | right

		});
	});
</script>
<script>
		function searchSerieByNumber(number){
			$( "#number-not-lucky" ).prop( "disabled", true );
			$('.btn-purchase').addClass('invisible');
			$('.searching_series').show();
			console.log('antes de envuar');
			$.ajax({
				url: "Blends/available_series/" + number,
			})
			.done(function( data ) {
				var result = jQuery.parseJSON(data).object;
				var series = result.series;
				var serie_input = $('#serie_input');
				console.log(result);
				serie_input.empty();
				serie_input.append('<option disabled selected value >Selecciona...</option>');
				for (var i = 0; i < series.length; i++) {
					serie_input.append('<option id=' + series[i] + ' value=' + series[i] + '>' + series[i] + '</option>');
				}
				$('.searching_series').hide();
				$('.btn-purchase').attr('number', result.number);
				$('.btn-purchase').attr('date', result.draw.date);
				$('.btn-purchase').attr('draw_number', result.draw.draw_number);
				$('.btn-purchase').attr('fractions_count', result.draw.fractions_count);
				$('.btn-purchase').attr('fractions_value', result.draw.fraction_value);
				var total = (result.draw.fraction_value * result.draw.fractions_count);
				$('.btn-purchase').attr('bill_value', total);
				$('.fractions_count_not_lucky').html(result.draw.fractions_count)
				$('.bill_value_not_lucky').html('$' + total)
				$('.pricing_and_fractions').show();
				$( ".btn-new-search" ).removeClass('invisible');
			});
		}

		function setBuyForNotLucky(serie){
			$('.btn-purchase').attr('serie', serie);
			$('.btn-purchase').removeClass('invisible');
		}

		function resetFormForNotLucky(){
			$('.btn-purchase').addClass('invisible');
			$("#number-not-lucky").val('');
			$('.pricing_and_fractions').hide();
			$('#serie_input').empty();
			$('#serie_input').append('<option disabled selected value >...</option>');
			$( ".btn-new-search" ).addClass('invisible');
			$("#number-not-lucky").prop( "disabled", false );
		}

		function getLucky(){
			resetFormForNotLucky();
			$('.btn-purchase').addClass('invisible');
			$('.not-lucky').removeClass('d-flex');
			$('.not-lucky').hide();
			$('.lucky').addClass('d-flex');
		}

		function getNotLucky(){
			$('.btn-purchase').addClass('invisible');
			$('.lucky').removeClass('d-flex');
			$('.lucky').hide();
			$('.not-lucky').addClass('d-flex');
		}
</script>