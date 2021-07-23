<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container" ;">
	<div class="row">
		<p class="h4 text-center mb-2">
			Selamat datang, <?php echo session()->get('username'); ?>
		</p>


		<div class="mapouter mt-3">
			<h4 class="text-left">Lokasi Toko Cindy</h4>
			<div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q=toko%20cindy%20tulungagung&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://fmovies-online.net">fmovuies</a><br>
				<style>
					.mapouter {
						position: relative;
						text-align: right;
						width: 100%;
						margin-bottom: 5px;
					}
				</style><a href="https://www.embedgooglemap.net">add google map location to website</a>
				<style>
					.gmap_canvas {
						overflow: hidden;
						background: none !important;
						height: 45vh;
						width: 100%;
					}
				</style>
			</div>
		</div>
	</div>

</div>

<?= $this->endSection() ?>