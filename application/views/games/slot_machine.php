

	<?php $lottopoints = get_user_profile()["lotto_points"] ?>
	<?php $points_for_play = get_setting('points_for_play') ?>
	<?php if($lottopoints >= $points_for_play) { ?>
		<link rel="stylesheet" href="<?= base_url() ?>assets/css/slot_machine.css">
		<body class="prueba" >
			<div class="big_container header-container">

			</div>
			<div class="big_container">
				<div id="left_light" class="side_light">
					<img src="<?= base_url() ?>assets/images/light-a.png" style="opacity: 0.999744;">
					<img src="<?= base_url() ?>assets/images/light-b.png" class="no-display" style="display: inline; opacity: 0.000256;">
				</div>		
				<div class="container slots">
					<div class="slot"></div>
					<div class="slot"></div>
					<div class="slot"></div>
					<div class="play-container">
						<div class="lose">
							<div class="meh">Oh! Mala suerte</div>
							<div class="try">Intentalo de nuevo</div>
						</div>
						<button id="btn-play">Jugar</button>
					</div>
				</div>
				<div id="right_light" class="side_light">
					<img src="<?= base_url() ?>assets/images/light-a.png">
					<img src="<?= base_url() ?>assets/images/light-b.png" class="no-display">
				</div>
			</div>
		</body>

		<script  src="<?= base_url().'assets/js/jquery.min.js' ?>"></script>
		<script  src="<?= base_url().'assets/js/slot_machine.js' ?>"></script>
			
	<?php } ?>
