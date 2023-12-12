<?php
defined('BASEPATH') or exit('No direct script access allowed');

class karyawan_model extends CI_Model
{
	public function simpankaryawan()
	{
		$data = [
			'nama' => $this->input->post('nama'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'nama_ibu' => $this->input->post('nama_ibu'),
			'tahun_masuk' => $this->input->post('tahun_masuk'),
			'created_at' => date('Y-m-d h:i:s'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$this->db->insert('tb_data_karyawan', $data);
	}
	public function ubahkaryawan($id_karyawan)
	{
		$data = [
			'nama' => $this->input->post('nama'),
			'jenis_kelamin' => $this->input->post('jenis_kelamin'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'nama_ibu' => $this->input->post('nama_ibu'),
			'tahun_masuk' => $this->input->post('tahun_masuk'),
			'updated_at' => date('Y-m-d h:i:s')
		];
		$this->db->where('id_karyawan', $id_karyawan);
		$this->db->update('tb_data_karyawan', $data);
	}
}
