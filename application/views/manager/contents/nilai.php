<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Detail Pekerjaan</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('manager') ?>">Manager</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('manager/pekerjaan') ?>">Kelola Pekerjaan</a></li>
				<li class="breadcrumb-item active">Detail Pekerjaan</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Detail Pekerjaan</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-lg-3">
							<h3>Nama manager : <?= $pekerjaan['nama'] ?></h3>
						</div>
						<div class="col-12 col-lg-3">
							<h3>tahun : <?= $pekerjaan['tahun'] ?></h3>
						</div>
						<div class="col-12 col-lg-3">
							<h3>Semester : <?= $pekerjaan['semester'] ?></h3>
						</div>
						<div class="col-12 col-lg-3">
							<h3>job : <?= $pekerjaan['job'] ?></h3>
						</div>
					</div>
					<hr>
					<h4>Proyek Yang Diambil</h4>
					<hr>
					<table class="table display table-bordered table-striped no-wrap">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Proyek</th>
							</tr>
						</thead>
						<tbody>
							<?php if (empty($pekerjaanproyekS)) : ?>
								<tr id="alert-data">
									<td colspan="4">
										<div class="alert alert-danger" role="alert">
											Belum ada proyek yang anda ambil <a href="<?= base_url('manager/proyek/' . $pekerjaan_id) ?>">Klik Disini</a> untuk menambahkan proyek
										</div>
									</td>
								</tr>
							<?php else : ?>
								<?php $no = 1;
								foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
									<tr>
										<td scope="row"><?= $no++ ?></td>
										<td><?= $pekerjaanproyek['proyek'] ?></td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
					<h4>Data Karyawan Yang Diambil</h4>
					<hr>
					<a href="<?= base_url('manager/lihat_nilai/' . $pekerjaan_id) ?>" class="btn btn-secondary btn-sm mb-2">Lihat semua nilai</a>
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php elseif ($this->session->flashdata('error')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('error') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table id="all-table" data-all="all" class="table display table-bordered table-striped no-wrap">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Karyawan</th>
									<th>Jenis Kelamin</th>
									<th>Tanggal Lahir</th>
									<th>Nama Ibu</th>
									<th>Tahun Masuk</th>
									<th style="text-align:center"></th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($pekerjaankaryawanS as $pekerjaankaryawan) : ?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $pekerjaankaryawan['nama'] ?></td>
										<td><?= $pekerjaankaryawan['jenis_kelamin'] ?></td>
										<td><?= $pekerjaankaryawan['tanggal_lahir'] ?></td>
										<td><?= $pekerjaankaryawan['nama_ibu'] ?></td>
										<td><?= $pekerjaankaryawan['tahun_masuk'] ?></td>
										<td style="text-align:center">
											<a href="<?= base_url('manager/input/' . $pekerjaan_id . '/' . $pekerjaankaryawan['id_karyawan']) ?>" class="btn btn-secondary btn-sm">Input Nilai</a>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?= base_url() ?>assets/template/adminwrap/assets/node_modules/jquery/jquery.min.js"></script>
<script>
	$(function() {
		$('#all-table').DataTable({
			"autoWidth": false,
			"responsive": true,
			"columnDefs": [{
				"targets": [-1],
				"orderable": false
			}]
		})
	});
</script>
