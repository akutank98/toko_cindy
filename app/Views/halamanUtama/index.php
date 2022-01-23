<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container">
	<div class="row">
		<div class="container" style="max-width: 100%;">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-100 img-fluid" src="<?= base_url('itemCarousel/FotoDepan.jpeg'); ?>" alt="First slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-fluid" src="<?= base_url('itemCarousel/FotoDalam.jpeg'); ?>" alt="Second slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-100 img-fluid" src="<?= base_url('itemCarousel/FotoProduk.jpeg'); ?>" alt="Third slide">
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<div class="mapouter mt-3">
				<h4 class="text-left mt-3">Lokasi Toko Cindy</h4>
				<div class="gmap_canvas"><iframe width="100%" height="65%" id="gmap_canvas" src="https://maps.google.com/maps?q=toko%20cindy%20tulungagung&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
					<style>
						.mapouter {
							position: relative;
							text-align: right;
							width: 100%;
							margin-bottom: 5px;
						}
					</style>
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

</div>

<?= $this->endSection() ?>