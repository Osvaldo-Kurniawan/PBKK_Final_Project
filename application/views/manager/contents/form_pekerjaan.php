<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Pekerjaan</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('manager') ?>">Manager</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('manager/pekerjaan') ?>">Kelola Pekerjaan</a></li>
				<li class="breadcrumb-item active">Tambah Pekerjaan</li>
			</ol>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Tambah Data Pekerjaan</h4>
					<h6 class="card-subtitle"> Data ini tidak akan bisa dihapus, maka dari itu perhatikan penulisan pada form. </h6>
					<hr>
					<form class="mt-4" method="POST">
						<div class="form-group">
							<label>Nama Manager</label>
							<input type="text" class="form-control" value="<?= $cekUser['nama'] ?>">
						</div>
						<div class="form-group">
							<label>Tahun</label>
							<select class="form-control <?= form_error('ta_id') ? 'is-invalid' : '' ?>" name="ta_id">
								<option value="" disabled selected>Pilih</option>
								<?php foreach ($tahunS as $tahun) : ?>
									<option value="<?= $tahun['id_ta'] ?>" <?= set_value('ta_id') != $tahun['id_ta'] ?: 'selected' ?>><?= $tahun['tahun'] . ' - Semester ' .  $tahun['semester'] ?></option>
								<?php endforeach ?>
							</select>
							<div class="invalid-feedback"><?= form_error('ta_id') ?></div>
						</div>
						<div class="form-group">
							<label>Job</label>
							<input type="text" class="form-control <?= form_error('job') ? 'is-invalid' : '' ?>" name="job" value="<?= set_value('job', isset($tahun['job']) ? $tahun['job'] : '') ?>" placeholder="contoh: 1">
							<div class="invalid-feedback"><?= form_error('job') ?></div>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- row -->
</div>
