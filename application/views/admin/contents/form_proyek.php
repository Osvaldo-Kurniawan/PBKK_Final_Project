<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Proyek</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('admin/proyek') ?>">Kelola Proyek</a></li>
				<li class="breadcrumb-item active">Tambah/Ubah proyek</li>
			</ol>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Buat Data Proyek</h4>
					<h6 class="card-subtitle"> Data ini tidak akan bisa dihapus, maka dari itu perhatikan penulisan pada form. </h6>
					<hr>
					<form class="mt-4" method="POST">
						<div class="form-group">
							<label>Kode proyek</label>
							<input type="text" class="form-control <?= form_error('kode_proyek') ? 'is-invalid' : '' ?>" name="kode_proyek" value="<?= set_value('kode_proyek', isset($proyek['kode_proyek']) ? $proyek['kode_proyek'] : '') ?>" placeholder="contoh: BTQ">
							<div class="invalid-feedback"><?= form_error('kode_proyek') ?></div>
						</div>
						<div class="form-group">
							<label>Nama proyek</label>
							<input type="text" class="form-control <?= form_error('proyek') ? 'is-invalid' : '' ?>" name="proyek" value="<?= set_value('proyek', isset($proyek['proyek']) ? $proyek['proyek'] : '') ?>" placeholder="contoh: Baca Tulis Qur'an">
							<div class="invalid-feedback"><?= form_error('proyek') ?></div>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- row -->
</div>
