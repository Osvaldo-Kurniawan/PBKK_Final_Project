<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Tahun</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('admin/tahun') ?>">Kelola Tahun</a></li>
				<li class="breadcrumb-item active">Tambah/Ubah tahun</li>
			</ol>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Buat Data Tahun</h4>
					<h6 class="card-subtitle"> Data ini tidak akan bisa dihapus, maka dari itu perhatikan penulisan pada form. </h6>
					<hr>
					<form class="mt-4" method="POST">
						<div class="form-group">
							<label>Tahun</label>
							<input type="text" class="form-control <?= form_error('tahun') ? 'is-invalid' : '' ?>" name="tahun" value="<?= set_value('tahun', isset($tahun['tahun']) ? $tahun['tahun'] : '') ?>" placeholder="contoh: 2020/2021">
							<div class="invalid-feedback"><?= form_error('tahun') ?></div>
						</div>
						<div class="form-group">
							<label>Semester</label>
							<select class="form-control <?= form_error('semester') ? 'is-invalid' : '' ?>" name="semester">
								<option value="" disabled selected>Pilih</option>
								<option value="1" <?= set_value('semester', isset($tahun['semester']) ? $tahun['semester'] : '') != '1' ?: 'selected' ?>>1</option>
								<option value="2" <?= set_value('semester', isset($tahun['semester']) ? $tahun['semester'] : '') != '2' ?: 'selected' ?>>2</option>
							</select>
							<div class="invalid-feedback"><?= form_error('semester') ?></div>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- row -->
</div>
