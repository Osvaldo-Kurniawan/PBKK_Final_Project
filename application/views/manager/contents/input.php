<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Input Nilai</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('manager') ?>">Manager</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('manager/pekerjaan') ?>">Kelola Pekerjaan</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('manager/nilai/' . $pekerjaan_id) ?>">Detail Pekerjaan</a></li>
				<li class="breadcrumb-item active">Input Nilai</li>
			</ol>
		</div>
	</div>
	<!-- row -->
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-lg-6">
							<h3>Nama manager : <?= $pekerjaan['nama'] ?></h3>
						</div>
						<div class="col-12 col-lg-6">
							<h3>tahun : <?= $pekerjaan['tahun'] ?></h3>
						</div>
					</div>
					<hr>
					<h3>Data Karyawan</h3>
					<table class="table">
						<tbody>
							<tr>
								<td>Nama karyawan</td>
								<td>:</td>
								<td><?= $karyawan['nama'] ?></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td><?= $karyawan['jenis_kelamin'] ?></td>
							</tr>
							<tr>
								<td>Tanggal Lahir</td>
								<td>:</td>
								<td><?= $karyawan['tanggal_lahir'] ?></td>
							</tr>
							<tr>
								<td>Nama ibu</td>
								<td>:</td>
								<td><?= $karyawan['nama_ibu'] ?></td>
							</tr>
							<tr>
								<td>Tahun Masuk</td>
								<td>:</td>
								<td><?= $karyawan['tahun_masuk'] ?></td>
							</tr>
						</tbody>
					</table>
					<form class="mt-4" method="POST">
						<?php foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
							<?php
							$proyek = $pekerjaanproyek['proyek_id'];
							$karyawans = $karyawan['id_karyawan'];
							$query = "SELECT *
													FROM `tb_nilai`
													JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
													JOIN `tb_data_karyawan` ON `tb_data_karyawan`.`id_karyawan` = `tb_nilai`.`karyawan_id`
													JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
													WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
													AND `tb_nilai`.`karyawan_id` = $karyawans
													AND `tb_nilai`.`proyek_id` = $proyek
													GROUP BY `tb_nilai`.`karyawan_id`
												";
							$nilai = $this->db->query($query)->row_array();
							?>
							<input type="hidden" name="pekerjaan_id" value="<?= $pekerjaan_id ?>">
							<div class="form-group">
								<label><?= $pekerjaanproyek['proyek'] ?></label>
								<input type="text" name="<?= $pekerjaanproyek['id_proyek'] ?>" class="form-control <?= form_error($pekerjaanproyek['id_proyek']) ? 'is-invalid' : '' ?>" value="<?= set_value($pekerjaanproyek['id_proyek'], isset($nilai['nilai']) ? $nilai['nilai'] : null) ?>">
								<div class="invalid-feedback"><?= form_error($pekerjaanproyek['id_proyek']) ?></div>
							</div>
						<?php endforeach ?>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- row -->
</div>
