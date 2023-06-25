<?php $this->load->view('layouts/header_admin'); ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-fw fa-cube"></i> Data Kriteria</h1>

    <div>
		<a href="#import" data-toggle="modal" class="btn btn-primary"> <i class="fa fa-upload"></i> Import Data EXCEL </a>
		<a href="<?= base_url('Kriteria/create'); ?>" class="btn btn-success"> <i class="fa fa-plus"></i> Tambah Data </a>
		<a href="<?= base_url('Kriteria/generate'); ?>" class="btn btn-primary"> <i class="fa fa-check"></i> Generate Bobot </a>
	</div>
</div>


<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Import Data EXCEL</h5>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<?= form_open_multipart('Kriteria/import_excel') ?>
				<div class="modal-body">
					<div class="form-group">
						<label>Pilih File Excel</label>
						<input required accept=".xls, .xlsx" type="file" class="form-control" name="fileExcel">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Import Sekarang</button>
				</div>
			<?php echo form_close() ?>
		</div>
	</div>
</div>


<?= $this->session->flashdata('message'); ?>

<div class="alert alert-info">
	Bila melakukan tambah, edit dan hapus data, maka silahkan melakukan <b>Generate Bobot</b> untuk mengupdate nilai bobot kriteria.
</div>

<div class="card shadow mb-4">
    <!-- /.card-header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-warning"><i class="fa fa-table"></i> Daftar Data Kriteria</h6>
    </div>

    <div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead class="bg-warning text-white">
					<tr align="center">
						<th width="5%">No</th>
						<th>Kode Kriteria</th>
						<th>Nama Kriteria</th>
						<th>Bobot</th>
						<th>Jenis</th>
						<th>Tingkat Prioritas</th>
						<th width="15%">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$no=1;
						foreach ($list as $data => $value) {
					?>
					<tr align="center">
						<td><?=$no ?></td>
						<td><?php echo $value->kode_kriteria ?></td>
						<td><?php echo $value->nama_kriteria ?></td>
						<td>
							<?php 
								if($value->bobot == NULL){
									echo "-";
								}elseif($value->bobot == "0"){
									echo "-";
								}else{
									echo $value->bobot;
								}
							?>
						</td>
						<td><?php echo $value->jenis ?></td>
						<td><?php echo $value->prioritas ?></td>
						<td>
							<div class="btn-group" role="group">
								<a data-toggle="tooltip" data-placement="bottom" title="Edit Data" href="<?=base_url('Kriteria/edit/'.$value->id_kriteria)?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
								<a  data-toggle="tooltip" data-placement="bottom" title="Hapus Data" href="<?=base_url('Kriteria/destroy/'.$value->id_kriteria)?>" onclick="return confirm ('Apakah anda yakin untuk meghapus data ini')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
							</div>
						</td>
					</tr>
					<?php
						$no++;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<?php $this->load->view('layouts/footer_admin'); ?>