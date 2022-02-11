<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<style>
	.twitter-icon,
	.facebook-icon,
	.instagram-icon,
	.googlemail-icon,
	.whatsapp-icon {
		margin-top: .625em;
		width: 40px;
		height: 40px;
		opacity: .9;
		filter: alpha(opacity=90);
		/* For IE8 and earlier */
		border-radius: 25px;
	}

	.footer-nav p {
		text-align: center;
	}
</style>
<div class="row">
	<div class="container" style="max-width: 100%;">
		<div class="alert-info mb-3">
			<h3>Anda harus login terlebih dahulu sebelum dapat mengakses Website</h3>
			<a href=" <?= site_url('Auth/login') ?>" class="text-decoration-none">Klik Disini Untuk Melakukan Login</a>
		</div>
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
			<h5 class="text-left text-muted">Rahmat, Jl. Basuki Rahmat No.18, Kenayan, Kec. Tulungagung, Kabupaten Tulungagung, Jawa Timur 66212</h5>
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
<div class="row justify-content-md-center pb-5">
	<ul class="list group list-group-horizontal-md" style="padding-bottom: 5;list-style-type: none;margin: 0;padding: 0;overflow: hidden;">
		<li class="list-group-item">
			<strong>Hubungi Kami Melalui :</strong>
		</li>
		<li class="list-group-item p-2 float-left">
			<a href="https://www.instagram.com/cindy.babyshop/" target="_blank">
				<img src="<?= base_url('icons/instagram.png') ?>" alt="Instagram Logo" class="instagram-icon"></a>
			<div class="text-muted">
				Instagram : <a href="https://www.instagram.com/cindy.babyshop/" target="_blank">@cindy.babyshop</a>
			</div>
		</li>
		<li class="list-group-item  p-2 float-left">
			<a href="https://www.facebook.com/tokocindy.tulungagung/" target="_blank">
				<img src="<?= base_url('icons/facebook.ico') ?>" alt="Facebook Logo" class="facebook-icon"></a>
			<div class="text-muted">
				Facebook : <a href="https://www.facebook.com/tokocindy.tulungagung/" target="_blank">@tokocindy.tulungagung </a>
			</div>
		</li>
		<li class="list-group-item p-2 float-left">
			<a href="mailto:tokocindy@gmail.com" target="_blank">
				<img src="<?= base_url('icons/gmail.svg') ?>" alt="GoogleMail Logo" class="googlemail-icon"></a>
			<div class="text-muted">
				Email : <a href="mailto:tokocindy@gmail.com" target="_blank">tokocindy@gmail.com </a>
			</div>
		</li>
		<li class="list-group-item p-2 float-left">
			<a href="https://wa.me/628155051048" target="_blank">
				<img src="<?= base_url('icons/whatsapp.png') ?>" alt="Whatsapp Logo" class="whatsapp-icon"></a>
			<div class="text-muted">
				Whatsapp : <a href="https://wa.me/628155051048" target="_blank">0815-5051-048 </a>
			</div>
		</li>
	</ul>
</div>

<?= $this->endSection() ?>