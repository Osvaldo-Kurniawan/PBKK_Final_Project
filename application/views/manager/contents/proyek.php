<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Proyek</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('manager') ?>">Manager</a></li>
				<li class="breadcrumb-item"><a href="<?= base_url('manager/pekerjaan') ?>">Kelola Pekerjaan</a></li>
				<li class="breadcrumb-item active">Proyek</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Data Proyek Anda</div>
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
							<h3>Semua Data Proyek</h3>
							<hr>
							<div class="table-responsive">
								<table id="all-table" class="table display table-bordered table-striped no-wrap">
									<thead>
										<tr>
											<th>No</th>
											<th>Kode</th>
											<th>Proyek</th>
											<th style="text-align:center"></th>
										</tr>
									</thead>
									<tbody>
										<?php if (empty($proyekS)) : ?>
											<tr id="alert-data">
												<td colspan="3">
													<div class="alert alert-danger" role="alert">
														Belum ada data proyek
													</div>
												</td>
											</tr>
										<?php else : ?>
											<?php $no = 1;
											foreach ($proyekS as $proyek) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $proyek['kode_proyek'] ?></td>
													<td><?= $proyek['proyek'] ?></td>
													<td style="text-align:center">
														<form action="<?= base_url('manager/add_proyek/' . $proyek['id_proyek']) ?>" method="POST">
															<input type="hidden" name="pekerjaan_id" value="<?= $pekerjaan_id ?>">
															<button type="submit" class="btn btn-secondary btn-sm">+</button>
														</form>
													</td>
												</tr>
											<?php endforeach ?>
										<?php endif ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<h3>Proyek Yang Diambil</h3>
							<hr>
							<div class="table-responsive">
								<table id="my-table" class="table display table-bordered table-striped no-wrap">
									<thead>
										<tr>
											<th>No</th>
											<th>Kode</th>
											<th>Proyek</th>
											<th style="text-align:center"></th>
										</tr>
									</thead>
									<tbody>
										<?php if (empty($pekerjaanproyekS)) : ?>
											<tr id="alert-data">
												<td colspan="4">
													<div class="alert alert-danger" role="alert">
														Belum ada proyek yang anda ambil
													</div>
												</td>
											</tr>
										<?php else : ?>
											<?php $no = 1;
											foreach ($pekerjaanproyekS as $pekerjaanproyek) : ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $pekerjaanproyek['kode_proyek'] ?></td>
													<td><?= $pekerjaanproyek['proyek'] ?></td>
													<td style="text-align:center">
														<form action="<?= base_url('manager/remove_proyek/' . $pekerjaanproyek['proyek_id']) ?>" method="POST" onsubmit="return confirm('Jika anda menghapus proyek ini, maka anda setuju akan hilangnya data nilai pada karyawan yang bersangkutan dengan proyek ini. Namun anda tidak perlu khawatir, data proyek di dalam pekerjaan lain tidak akan ikut terhapus.');">
															<input type="hidden" name="pekerjaan_id" value="<?= $pekerjaan_id ?>">
															<button type="submit" class="btn btn-secondary btn-sm">-</button>
														</form>
													</td>
												</tr>
											<?php endforeach ?>
										<?php endif ?>
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
