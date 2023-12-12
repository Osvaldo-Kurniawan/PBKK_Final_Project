<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor">Manager</h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></li>
				<li class="breadcrumb-item active">Kelola Manager</li>
			</ol>
		</div>
		<div class="col-md-7 align-self-center text-right d-none d-md-block">
			<a href="<?= base_url('admin/add_manager') ?>" class="btn btn-info">
				Tambah Manager
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- table responsive -->
			<div class="card ribbon-wrapper">
				<div class="ribbon ribbon-bookmark ribbon-default">Data manager</div>
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
									<th>Username</th>
									<th>Nama</th>
									<th>Jenis Kelamin</th>
									<th>Tanggal Lahir</th>
									<th>NIP</th>
									<th>Pendidikan Terakhir</th>
									<th>Agama</th>
									<th>No Handphone</th>
									<th>Alamat</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($managerS as $manager) : ?>
									<tr>
										<td><?= $no++ ?></td>
										<td><?= $manager['username'] ?></td>
										<td><?= $manager['nama'] ?></td>
										<td><?= $manager['jenis_kelamin'] ?></td>
										<td><?= $manager['tanggal_lahir'] ?></td>
										<td><?= $manager['nip'] ?></td>
										<td><?= $manager['pendidikan_terakhir'] ?></td>
										<td><?= $manager['agama'] ?></td>
										<td><?= $manager['no_hp'] ?></td>
										<td><?= $manager['alamat'] ?></td>
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
