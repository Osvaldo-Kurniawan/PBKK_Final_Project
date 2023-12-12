<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Pekerjaan</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('manager') ?>">Manager</a></li>
				<li class="breadcrumb-item active">Kelola Pekerjaan</li>
			</ol>
		</div>
		<div class="col-md-7 align-self-center text-right d-none d-md-block">
			<a href="<?= base_url('manager/add_pekerjaan') ?>" class="btn btn-info">
				Tambah Pekerjaan
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Data Pekerjaan</div>
				<div class="card-body">
					<div class="table-responsive">
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
						<table id="all-table" data-all="all" class="table display table-bordered table-striped no-wrap">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama manager</th>
									<th>Tahun</th>
									<th>Semester</th>
									<th>Job</th>
									<th style="text-align:center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($pekerjaanS as $pekerjaan) : ?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $pekerjaan['nama'] ?></td>
										<td><?= $pekerjaan['tahun'] ?></td>
										<td><?= $pekerjaan['semester'] ?></td>
										<td><?= $pekerjaan['job'] ?></td>
										<td style="text-align:center">
											<a href="<?= base_url('manager/nilai/' . $pekerjaan['id_pekerjaan']) ?>" class="btn btn-secondary btn-sm"><i class="icon-File-Search"></i> Detail</a>
											<a href="<?= base_url('manager/proyek/' . $pekerjaan['id_pekerjaan']) ?>" class="btn btn-secondary btn-sm"><i class="icon-Pen-2"></i> Input proyek</a>
											<a href="<?= base_url('manager/karyawan/' . $pekerjaan['id_pekerjaan']) ?>" class="btn btn-secondary btn-sm"><i class="icon-Pen-2"></i> Input karyawan</a>
											<a href="<?= base_url('manager/hapus/' . $pekerjaan['id_pekerjaan']) ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Jika anda menghapus pekerjaan ini, maka anda setuju akan hilangnya semua data yang ada pada pekerjaan ini');"><i class="icon-Delete-File"></i> Hapus</a>
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
