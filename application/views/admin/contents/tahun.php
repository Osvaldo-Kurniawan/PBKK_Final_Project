<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Tahun Project</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
				<li class="breadcrumb-item active">Kelola Tahun</li>
			</ol>
		</div>
		<div class="col-md-7 align-self-center text-right d-none d-md-block">
			<a href="<?= base_url('admin/add_tahun') ?>" class="btn btn-info">
				Buat Tahun Project
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Data Tahun Project</div>
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
									<th>Tahun</th>
									<th>Semester</th>
									<th>Dibuat</th>
									<th>Terakhir Diubah</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($tahunS as $tahun) : ?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $tahun['tahun'] ?></td>
										<td><?= $tahun['semester'] ?></td>
										<td><?= $tahun['created_at'] ?></td>
										<td><?= $tahun['updated_at'] ?></td>
										<td><a href="<?= base_url('admin/update_tahun/' . $tahun['id_ta']) ?>" class="btn btn-secondary btn-sm">Ubah</a></td>
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
		})
	});
</script>
