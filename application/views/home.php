<link rel="stylesheet" href="<?= base_url() ?>assets/css/powerball.css">


<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="header">
				<div class="header-item text-center">
          <img class="text-center logo" src="<?= base_url().'assets/images/logo.png' ?>" alt="" height="72">
				</div>
				<div class="header-item">
					|
					<a href="<?= base_url() . 'usuarios/login' ?>" class="btn btn-link" type="submit">Iniciar sesión</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h1 class="title"></h1>
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
	<div class="row justify-content-end">
		<div class="col-md-6 d-flex align-items-center">
			
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
	<div class="row justify-content-center">
		<div class="col-md-6  d-flex justify-content-center">
			<div class="text-center">
				<button class="btn btn-yellow btn-simulator invisible btn-purchase mr-4"><i data-feather="shopping-cart"></i>  Comprar</button>
				<button class="btn btn-success  btn-simulator" id="btn-play"><i data-feather="play"></i> Jugar</button>
			</div>
		</div>

	</div>
</div>

<script type="module" src="<?= base_url().'assets/js/vendor.min.js' ?>"></script>
<script type="module" src="<?= base_url().'assets/js/app.min.js' ?>"></script>
<script type="module" src="<?= base_url().'assets/js/simulator.js' ?>"></script>