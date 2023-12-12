<?php
defined('BASEPATH') or exit('No direct script access allowed');

class proyek_model extends CI_Model
{
	public function simpanproyek()
	{
		$data = [
			'kode_proyek' => $this->input->post('kode_proyek'),
			'proyek' => $this->input->post('proyek'),
			'created_at' => date('Y-m-d h:i:s'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$this->db->insert('tb_data_proyek', $data);
	}
	public function ubahproyek($id_proyek)
	{
		$data = [
			'kode_proyek' => $this->input->post('kode_proyek'),
			'proyek' => $this->input->post('proyek'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$this->db->where('id_proyek', $id_proyek);
		$this->db->update('tb_data_proyek', $data);
	}
}
