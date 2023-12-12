<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Nilai</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
				<li class="breadcrumb-item active">Nilai</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Detail pekerjaan</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-lg-6">
							<h3>Nama manager : <?= $pekerjaan['nama'] ?></h3>
						</div>
						<div class="col-12 col-lg-6">
							<h3>Tahun : <?= $pekerjaan['tahun'] ?></h3>
						</div>
					</div>
					<hr>
					<h4>Proyek Yang Diambil</h4>
					<hr>
					<table class="table display table-bordered table-striped no-wrap">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">proyek</th>
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
					<h4>Data karyawan Project</h4>
					<hr>
					<div class="table-responsive">
						<table id="all-table" data-all="all" class="table display table-bordered table-striped no-wrap">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama karyawan</th>
									<th>Jenis Kelamin</th>
									<th>Tanggal Lahir</th>
									<th>Nama ibu</th>
									<th>Tahun Masuk</th>
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
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Data Nilai</div>
				<div class="card-body">
					<div class="text-center">
						<h3>Daftar Skor Pegawai</h3>
					</div>
					<table class="table table-bordered table-hover table-responsive-xl">
						<tbody>
							<tr>
								<td rowspan="2" style="vertical-align : middle;text-align:center;">No</td>
								<td rowspan="2" style="vertical-align : middle;text-align:center;">Nama karyawan</td>
								<td colspan="<?= count($pekerjaanproyekS) ?>" style="text-align: center;">Proyek</td>
								<td colspan="2" style="text-align: center;">Total</td>
							</tr>
							<tr>
								<?php if (empty($pekerjaanproyekS)) : ?>
									<td class="text-danger text-center">proyek tidak ditemukan!</td>
								<?php else : ?>
									<?php foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
										<td><?= $pekerjaanproyek['proyek'] ?></td>
									<?php endforeach ?>
								<?php endif ?>
								<td>Jumlah</td>
								<td>Nilai</td>
							</tr>
							<?php if (empty($pekerjaankaryawanS)) : ?>
								<td class="text-danger text-center" colspan="15">karyawan tidak ditemukan!</td>
							<?php else : ?>
								<?php $no = 1;
								foreach ($pekerjaankaryawanS as $pekerjaankaryawan) : ?>
									<?php $karyawan = $pekerjaankaryawan['karyawan_id']; ?>
									<tr>
										<td style="text-align: center;"><?= $no++ ?></td>
										<td><?= $pekerjaankaryawan['nama'] ?></td>
										<?php foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
											<?php
											$proyek = $pekerjaanproyek['proyek_id'];
											$query = "SELECT *
													FROM `tb_nilai`
													JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
													JOIN `tb_data_karyawan` ON `tb_data_karyawan`.`id_karyawan` = `tb_nilai`.`karyawan_id`
													JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
													WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
													AND `tb_nilai`.`karyawan_id` = $karyawan
													AND `tb_nilai`.`proyek_id` = $proyek
													GROUP BY `tb_nilai`.`karyawan_id`
												";
											$nilai = $this->db->query($query)->row_array();
											?>
											<td><?= isset($nilai['nilai']) ? $nilai['nilai'] : '<span class="text-danger">Belum ada nilai!</span>' ?></td>
										<?php endforeach ?>
										<?php
										$queryAs = "SELECT SUM(nilai) as jumlah, AVG(nilai) as total
												FROM `tb_nilai`
												JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
												JOIN `tb_data_karyawan` ON `tb_data_karyawan`.`id_karyawan` = `tb_nilai`.`karyawan_id`
												JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
												WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
												AND `tb_nilai`.`karyawan_id` = $karyawan
												GROUP BY `tb_nilai`.`karyawan_id`
										";
										$cari = $this->db->query($queryAs)->row_array();
										?>
										<?php if (!empty($cari)) : ?>
											<td><?= $cari['jumlah'] ?></td>
											<td><?= round($cari['total'], 1) ?></td>
										<?php else : ?>
											<td><span class="text-danger">Belum ada total!</span></td>
											<td><span class="text-danger">Belum ada total!</span></td>
										<?php endif ?>
									</tr>
								<?php endforeach ?>
							<?php endif ?>

							<tr>
								<td colspan="2">Jumlah</td>
								<?php foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
									<?php
									$proyek = $pekerjaanproyek['proyek_id'];
									$queryJml = "SELECT SUM(nilai) as jumlah
												FROM `tb_nilai`
												JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
												JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
												WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
												AND `tb_nilai`.`proyek_id` = $proyek
												GROUP BY `tb_nilai`.`proyek_id`
										";
									$cariTotal = $this->db->query($queryJml)->result_array();
									?>
									<?php foreach ($cariTotal as $cari) : ?>
										<td><?= $cari['jumlah'] ?></td>
									<?php endforeach ?>
								<?php endforeach ?>
							</tr>
							<tr>
								<td colspan="2">Rata-Rata nilai</td>
								<?php foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
									<?php
									$proyek = $pekerjaanproyek['proyek_id'];
									$queryJml = "SELECT AVG(nilai) as rata
												FROM `tb_nilai`
												JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
												JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
												WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
												AND `tb_nilai`.`proyek_id` = $proyek
												GROUP BY `tb_nilai`.`proyek_id`
										";
									$cariTotal = $this->db->query($queryJml)->result_array();
									?>
									<?php foreach ($cariTotal as $cari) : ?>
										<td><?= round($cari['rata'], 1) ?></td>
									<?php endforeach ?>
								<?php endforeach ?>
							</tr>
						</tbody>
					</table>
					<a href="<?= base_url('admin/excel/' . $pekerjaan_id) ?>" class="btn btn-secondary btn-sm">Export to Excel</a>
				</div>
			</div>
		</div>
	</div>
</div>
