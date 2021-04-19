

	<?php $lottopoints = get_user_profile()["lotto_points"] ?>
	<?php $points_for_play = get_setting('points_for_play') ?>
	<?php if($lottopoints >= $points_for_play) { ?>
		<link rel="stylesheet" href="<?= base_url() ?>assets/css/slot_game.css">


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
	
	<div class="row" id="rotate">
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
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-6  d-flex justify-content-center">
			<div class="text-center">
				<button class="btn btn-success  btn-simulator" id="btn-play"><i data-feather="play"></i> Jugar</button>
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
<script type="module" src="<?= base_url().'assets/js/slot_game.js' ?>"></script>
	<?php } ?>
