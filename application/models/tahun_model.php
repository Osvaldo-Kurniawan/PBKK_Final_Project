<?php
defined('BASEPATH') or exit('No direct script access allowed');

class tahun_model extends CI_Model
{
	public function simpantahun()
	{
		$data = [
			'tahun' => $this->input->post('tahun'),
			'semester' => $this->input->post('semester'),
			'created_at' => date('Y-m-d h:i:s'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$this->db->insert('tb_data_tahun', $data);
	}
	public function ubahtahun($id_ta)
	{
		$data = [
			'tahun' => $this->input->post('tahun'),
			'semester' => $this->input->post('semester'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$this->db->where('id_ta', $id_ta);
		$this->db->update('tb_data_tahun', $data);
	}
}
