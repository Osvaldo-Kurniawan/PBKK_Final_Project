<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Karyawan</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('manager') ?>">Manager</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('manager/pekerjaan') ?>">Kelola Pekerjaan</a></li>
				<li class="breadcrumb-item active">Karyawan</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Data Karyawan Anda</div>
				<div class="card-body">
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
					<div class="row">
						<div class="col-12 col-lg-6">
							<h3>Semua Data Karyawan</h3>
							<hr>
							<div class="table-responsive">
								<table id="all-table" class="table display table-bordered table-striped no-wrap">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Jenis Kelamin</th>
											<th>Ibu</th>
											<th>Tahun Masuk</th>
											<th style="text-align:center"></th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
										foreach ($karyawanS as $karyawan) : ?>
											<?php $exists = $this->db->get_where('tb_pekerjaan_karyawan', ['pekerjaan_id' => $pekerjaan_id, 'karyawan_id' => $karyawan['id_karyawan']]) ?>
											<?php if (!$exists->num_rows() > 0) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $karyawan['nama'] ?></td>
													<td><?= $karyawan['jenis_kelamin'] ?></td>
													<td><?= $karyawan['nama_ibu'] ?></td>
													<td><?= $karyawan['tahun_masuk'] ?></td>
													<td style="text-align:center">
														<form action="<?= base_url('manager/add_karyawan/' . $karyawan['id_karyawan']) ?>" method="POST">
															<input type="hidden" name="pekerjaan_id" value="<?= $pekerjaan_id ?>">
															<button type="submit" class="btn btn-secondary btn-sm">+</button>
														</form>
													</td>
												</tr>
											<?php endif ?>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<h3>Karyawan Proyek</h3>
							<hr>
							<div class="table-responsive">
								<table id="my-table" class="table display table-bordered table-striped no-wrap">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Jenis Kelamin</th>
											<th>Ibu</th>
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
												<td><?= $pekerjaankaryawan['nama_ibu'] ?></td>
												<td><?= $pekerjaankaryawan['tahun_masuk'] ?></td>
												<td style="text-align:center">
													<form action="<?= base_url('manager/remove_karyawan/' . $pekerjaankaryawan['id_karyawan']) ?>" method="POST" onsubmit="return confirm('Jika anda menghapus karyawan ini, maka anda setuju akan hilangnya data karyawan dan nilai-nilai yang bersangkutan dengan karyawan ini. Namun anda tidak perlu khawatir, data karyawan di dalam pekerjaan lain tidak akan ikut terhapus.');">
														<input type="hidden" name="pekerjaan_id" value="<?= $pekerjaan_id ?>">
														<button type="submit" class="btn btn-secondary btn-sm">-</button>
													</form>
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
		$('#my-table').DataTable({
			"autoWidth": false,
			"responsive": true,
			"columnDefs": [{
				"targets": [-1],
				"orderable": false
			}]
		})
	});
</script>
