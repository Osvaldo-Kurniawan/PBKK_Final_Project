<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pekerjaan_model extends CI_Model
{
	public function getpekerjaan($pekerjaan_id = null)
	{
		$this->db->select('*');
		$this->db->from('tb_pekerjaan a');
		$this->db->join('tb_autentikasi b', 'b.id = a.manager_id');
		$this->db->join('tb_data_tahun c', 'c.id_ta = a.ta_id');
		if ($this->session->userdata('role') == 'manager') {
			$this->db->where('a.manager_id', $this->session->userdata('id'));
		}
		if ($pekerjaan_id != null) {
			$this->db->where('a.id_pekerjaan', $pekerjaan_id);
		}
		return $this->db->get(); // tampilkan semua data
	}
	public function getpekerjaanproyek($pekerjaan_id)
	{
		$this->db->select('*');
		$this->db->from('tb_pekerjaan_proyek a');
		$this->db->join('tb_pekerjaan b', 'b.id_pekerjaan = a.pekerjaan_id');
		$this->db->join('tb_autentikasi c', 'c.id = b.manager_id');
		$this->db->join('tb_data_tahun d', 'd.id_ta = b.ta_id');
		$this->db->join('tb_data_proyek e', 'e.id_proyek = a.proyek_id');
		if ($this->session->userdata('role') == 'manager') {
			$this->db->where('b.manager_id', $this->session->userdata('id'));
		}
		$this->db->where('a.pekerjaan_id', $pekerjaan_id);
		return $this->db->get()->result_array(); // tampilkan semua data
	}
	public function getpekerjaankaryawan($pekerjaan_id)
	{
		$this->db->select('*');
		$this->db->from('tb_pekerjaan_karyawan a');
		$this->db->join('tb_pekerjaan b', 'b.id_pekerjaan = a.pekerjaan_id');
		$this->db->join('tb_autentikasi c', 'c.id = b.manager_id');
		$this->db->join('tb_data_tahun d', 'd.id_ta = b.ta_id');
		$this->db->join('tb_data_karyawan e', 'e.id_karyawan = a.karyawan_id');
		if ($this->session->userdata('role') == 'manager') {
			$this->db->where('b.manager_id', $this->session->userdata('id'));
		}
		$this->db->where('a.pekerjaan_id', $pekerjaan_id);
		return $this->db->get()->result_array(); // tampilkan semua data
	}
	public function simpanpekerjaan()
	{
		$data = [
			'manager_id' => $this->session->userdata('id'),
			'ta_id' => $this->input->post('ta_id'),
			'job' => $this->input->post('job'),
		];
		$this->db->insert('tb_pekerjaan', $data);
	}
	public function simpanpekerjaanproyek($proyek_id)
	{
		$data = [
			'pekerjaan_id' => $this->input->post('pekerjaan_id'),
			'proyek_id' => $proyek_id
		];
		$this->db->insert('tb_pekerjaan_proyek', $data);

		return ($this->db->affected_rows() != 1) ? false : true;
	}
	public function hapuspekerjaanproyek($proyek_id)
	{
		$this->db->delete('tb_pekerjaan_proyek', ['proyek_id' => $proyek_id, 'pekerjaan_id' => $this->input->post('pekerjaan_id')]);
	}
	public function simpanpekerjaankaryawan($karyawan_id, $pekerjaan_id)
	{
		$this->db->trans_start();
		$data = [
			'pekerjaan_id' => $this->input->post('pekerjaan_id'),
			'karyawan_id' => $karyawan_id
		];
		$this->db->replace('tb_pekerjaan_karyawan', $data);

		// Insert Nilai 0 pada proyek
		$pekerjaanproyekS = $this->db->get_where('tb_pekerjaan_proyek', ['pekerjaan_id' => $pekerjaan_id])->result_array();
		foreach ($pekerjaanproyekS as $pekerjaanproyek) {
			$data = [
				'pekerjaan_id' => $pekerjaan_id,
				'karyawan_id' => $karyawan_id,
				'proyek_id' => $pekerjaanproyek['proyek_id'],
				'nilai' => 0
			];
			$this->db->insert('tb_nilai', $data); // Insert data nilai
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}
	public function hapuspekerjaankaryawan($karyawan_id)
	{
		$this->db->delete('tb_pekerjaan_karyawan', ['karyawan_id' => $karyawan_id, 'pekerjaan_id' => $this->input->post('pekerjaan_id')]);
	}
	public function lihatNilai($pekerjaan_id)
	{
		$this->db->select('*');
		$this->db->from('tb_nilai a');
		$this->db->join('tb_pekerjaan b', 'b.id_pekerjaan = a.pekerjaan_id');
		$this->db->join('tb_data_karyawan c', 'c.id_karyawan = a.karyawan_id');
		$this->db->join('tb_data_proyek d', 'd.id_proyek = a.proyek_id');
		if ($this->session->userdata('role') == 'manager') {
			$this->db->where('b.manager_id', $this->session->userdata('id'));
		}
		$this->db->where('a.pekerjaan_id', $pekerjaan_id);
		return $this->db->get()->result_array(); // tampilkan semua data
	}
	public function pekerjaanproyekExcel($pekerjaan_id)
	{
	}
}
