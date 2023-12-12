<?php
defined('BASEPATH') or exit('No direct script access allowed');
// memanggil autoload library phpoffice
require('./application/third_party/phpoffice/vendor/autoload.php');

// Memanggil namespace class yang berada di library phpoffice
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class manager extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Load Model
		// Parameter pertama load file model, Parameter kedua adalah nama alias dari model parameter pertama
		$this->load->model('manager_model', 'manager_m');
		$this->load->model('pekerjaan_model', 'pekerjaan_m');
		is_logged_not_in(); // Jika sudah login, lalu mengakses halaman login maka tidak akan bisa dan akan d alihkan ke halaman manager
	}
	public function index()
	{
		$data = [
			'judul' => 'manager | Home',
			'viewUtama' => 'manager/contents/index',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
		];
		$this->load->view('manager/layouts/wrapperIndex', $data);
	}
	public function profil()
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[25]');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('nip', 'NIP', 'required|numeric|max_length[20]');
		$this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan', 'required|max_length[25]');
		$this->form_validation->set_rules('agama', 'Agama', 'required|max_length[25]');
		$this->form_validation->set_rules('no_hp', 'No Handphone', 'required|numeric|max_length[13]');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'min_length[5]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman profil
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'manager | Tambah pekerjaan',
				'viewUtama' => 'manager/contents/profil',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
			];
			$this->load->view('manager/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->manager_m->ubahProfil();
			$this->session->set_flashdata('success', 'Profil berhasil diubah.'); // Membuat pesan notif jika insert data berhasil
			redirect('manager/profil'); // redirect ke halaman profil
		}
	}
	public function pekerjaan()
	{
		$data = [
			'judul' => 'manager | pekerjaan',
			'viewUtama' => 'manager/contents/pekerjaan',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'pekerjaanS' => $this->pekerjaan_m->getpekerjaan()->result_array()
		];
		$this->load->view('manager/layouts/wrapperData', $data);
	}
	public function add_pekerjaan()
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('ta_id', 'tahun', 'required');
		$this->form_validation->set_rules('job', 'job', 'required|max_length[6]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman pekerjaan
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'manager | Tambah pekerjaan',
				'viewUtama' => 'manager/contents/form_pekerjaan',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
				'tahunS' => $this->db->get('tb_data_tahun')->result_array()
			];
			$this->load->view('manager/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->pekerjaan_m->simpanpekerjaan(); // Insert data pekerjaan
			$this->session->set_flashdata('success', 'Data berhasil dibuat.'); // Membuat pesan notif jika insert data berhasil
			redirect('manager/pekerjaan'); // redirect ke halaman pekerjaan
		}
	}
	public function hapus($id_pekerjaan)
	{
		$this->db->delete('tb_pekerjaan', ['id_pekerjaan' => $id_pekerjaan]);
		$this->session->set_flashdata('success', 'pekerjaan berhasil dihapus.'); // Membuat pesan notif jika insert data berhasil
		redirect('manager/pekerjaan'); // redirect ke halaman pekerjaan
	}
	public function proyek($pekerjaan_id)
	{
		$data = [
			'judul' => 'manager | proyek',
			'viewUtama' => 'manager/contents/proyek',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'proyekS' => $this->db->get('tb_data_proyek')->result_array(),
			'pekerjaanproyekS' => $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id),
			'pekerjaan_id' => $pekerjaan_id
		];
		$this->load->view('manager/layouts/wrapperData', $data);
	}
	public function add_proyek($proyek_id)
	{
		$pekerjaan_id = $this->input->post('pekerjaan_id');

		if ($this->pekerjaan_m->simpanpekerjaanproyek($proyek_id) == false) { // Insert data pekerjaan
			$this->session->set_flashdata('error', 'proyek sudah dimasukkan'); // Membuat pesan notif jika insert data berhasil
			redirect('manager/proyek/' . $pekerjaan_id); // redirect ke halaman pekerjaan
		}
		$this->session->set_flashdata('success', 'proyek berhasil dibuat'); // Membuat pesan notif jika insert data berhasil
		redirect('manager/proyek/' . $pekerjaan_id); // redirect ke halaman pekerjaan
	}
	public function remove_proyek($proyek_id)
	{
		$pekerjaan_id = $this->input->post('pekerjaan_id');

		$this->pekerjaan_m->hapuspekerjaanproyek($proyek_id); // Delete data pekerjaan
		$this->session->set_flashdata('success', 'proyek berhasil dihapus'); // Membuat pesan notif jika delete data berhasil
		redirect('manager/proyek/' . $pekerjaan_id); // redirect ke halaman pekerjaan
	}
	public function karyawan($pekerjaan_id)
	{
		$data = [
			'judul' => 'manager | karyawan',
			'viewUtama' => 'manager/contents/karyawan',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'karyawanS' => $this->db->get('tb_data_karyawan')->result_array(),
			'pekerjaankaryawanS' => $this->pekerjaan_m->getpekerjaankaryawan($pekerjaan_id),
			'pekerjaan_id' => $pekerjaan_id
		];
		$this->load->view('manager/layouts/wrapperData', $data);
	}
	public function add_karyawan($karyawan_id)
	{
		$pekerjaan_id = $this->input->post('pekerjaan_id');
		$this->pekerjaan_m->simpanpekerjaankaryawan($karyawan_id, $pekerjaan_id);

		$this->session->set_flashdata('success', 'karyawan berhasil dibuat'); // Membuat pesan notif jika insert data berhasil
		redirect('manager/karyawan/' . $pekerjaan_id); // redirect ke halaman pekerjaan
	}
	public function remove_karyawan($karyawan_id)
	{
		$pekerjaan_id = $this->input->post('pekerjaan_id');

		$this->pekerjaan_m->hapuspekerjaankaryawan($karyawan_id); // Delete data pekerjaan
		$this->session->set_flashdata('success', 'karyawan berhasil dihapus'); // Membuat pesan notif jika delete data berhasil
		redirect('manager/karyawan/' . $pekerjaan_id); // redirect ke halaman pekerjaan
	}
	public function nilai($pekerjaan_id)
	{
		$data = [
			'judul' => 'manager | Detail pekerjaan',
			'viewUtama' => 'manager/contents/nilai',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'pekerjaan' => $this->pekerjaan_m->getpekerjaan($pekerjaan_id)->row_array(),
			'pekerjaanproyekS' => $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id),
			'pekerjaankaryawanS' => $this->pekerjaan_m->getpekerjaankaryawan($pekerjaan_id),
			'pekerjaan_id' => $pekerjaan_id
		];
		$this->load->view('manager/layouts/wrapperData', $data);
	}
	public function input($pekerjaan_id, $karyawan_id)
	{
		$pekerjaanproyekS = $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id);
		$karyawan = $this->db->get_where('tb_data_karyawan', ['id_karyawan' => $karyawan_id])->row_array();
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		foreach ($pekerjaanproyekS as $pekerjaanproyek) {
			$this->form_validation->set_rules($pekerjaanproyek['id_proyek'], 'Input', 'numeric|greater_than_equal_to[0]|less_than_equal_to[100]');
		}

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman pekerjaan
		if ($this->form_validation->run() == FALSE) {
			$pekerjaan_karyawan = $this->db->get_where('tb_pekerjaan_karyawan', ['pekerjaan_id' => $pekerjaan_id, 'karyawan_id' => $karyawan_id])->row_array();
			if ($pekerjaan_karyawan) {
				$data = [
					'judul' => 'manager | Input Nilai',
					'viewUtama' => 'manager/contents/input',
					'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
					'pekerjaan' => $this->pekerjaan_m->getpekerjaan($pekerjaan_id)->row_array(),
					'pekerjaanproyekS' => $pekerjaanproyekS,
					'karyawan' => $karyawan,
					'pekerjaan_id' => $pekerjaan_id
				];
				$this->load->view('manager/layouts/wrapperForm', $data);
			}
		} else {
			foreach ($pekerjaanproyekS as $pekerjaanproyek) {
				$data = [
					'pekerjaan_id' => $pekerjaan_id,
					'karyawan_id' => $karyawan_id,
					'proyek_id' => $pekerjaanproyek['proyek_id'],
					'nilai' => $this->input->post($pekerjaanproyek['id_proyek'])
				];
				$this->db->replace('tb_nilai', $data); // Insert data pekerjaan
			}
			$this->session->set_flashdata('success', 'Nilai ' . $karyawan['nama'] . ' berhasil di input.'); // Membuat pesan notif jika insert data berhasil
			redirect('manager/nilai/' . $pekerjaan_id); // redirect ke halaman pekerjaan
		}
	}
	public function lihat_nilai($pekerjaan_id)
	{
		$data = [
			'judul' => 'manager | Nilai',
			'viewUtama' => 'manager/contents/lihat_nilai',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'pekerjaan' => $this->pekerjaan_m->getpekerjaan($pekerjaan_id)->row_array(),
			'pekerjaanproyekS' => $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id),
			'pekerjaankaryawanS' => $this->pekerjaan_m->getpekerjaankaryawan($pekerjaan_id),
			'lihat_nilai' => $this->pekerjaan_m->lihatNilai($pekerjaan_id),
			'pekerjaan_id' => $pekerjaan_id
		];
		$this->load->view('manager/layouts/wrapperData', $data);
	}
	public function excel($pekerjaan_id)
	{
		$pekerjaan =  $this->pekerjaan_m->getpekerjaan($pekerjaan_id)->row_array();
		$pekerjaanproyekS = $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id);
		$pekerjaankaryawanS = $this->pekerjaan_m->getpekerjaankaryawan($pekerjaan_id);
		// Ini Instance untuk export Excel
		$excel = new Spreadsheet();

		$excel->getProperties()->setCreator('Muhammad Alfansa Yazib')
			->setLastModifiedBy('Muhammad Alfansa Yazib')
			->setTitle('SEKOLAH DINIYYAH TARBIYYATUL FALAAH TUGU')
			->setSubject("DAFTAR HASIL TES BELAJAR DINIYYAH TARBIYYATUL FALAAH TUGU")
			->setCategory("Daftar Nilai");

		$excel->setActiveSheetIndex(0)
			->setCellValue('A1', 'No')
			->setCellValue('B1', 'Nama Murid');

		$no = 67;
		foreach ($pekerjaanproyekS as $pekerjaanproyek) {
			$excel->setActiveSheetIndex(0)
				->setCellValue(chr($no++) . '1', $pekerjaanproyek['proyek']);
		}
		$excel->setActiveSheetIndex(0)
			->setCellValue(chr($no++) . '1', 'Jumlah')
			->setCellValue(chr($no++) . '1', 'Nilai');
		$column = 2;
		$urutan = 1;
		$noB = 67;
		if (is_array($pekerjaankaryawanS)) {
			foreach ($pekerjaankaryawanS as $pekerjaankaryawan) {
				$karyawan = $pekerjaankaryawan['karyawan_id'];
				$excel->setActiveSheetIndex(0)
					->setCellValue('A' . $column, $urutan++)
					->setCellValue('B' . $column, $pekerjaankaryawan['nama']);
				foreach ($pekerjaanproyekS as $pekerjaanproyek) {
					$proyek = $pekerjaanproyek['proyek_id'];
					$query = "SELECT *
								FROM `tb_nilai`
								JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
								JOIN `tb_data_karyawan` ON `tb_data_karyawan`.`id_karyawan` = `tb_nilai`.`karyawan_id`
								JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
								WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
								AND `tb_nilai`.`karyawan_id` = $karyawan
								AND `tb_nilai`.`proyek_id` = $proyek
								GROUP BY `tb_nilai`.`karyawan_id`
							";
					$nilai = $this->db->query($query)->row_array();
					$excel->setActiveSheetIndex(0)
						->setCellValue(chr($noB++) . $column, $nilai['nilai']);
				}
				$queryAs = "SELECT *,SUM(nilai) as jumlah, AVG(nilai) as total
								FROM `tb_nilai`
								JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
								JOIN `tb_data_karyawan` ON `tb_data_karyawan`.`id_karyawan` = `tb_nilai`.`karyawan_id`
								JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
								WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
								AND `tb_nilai`.`karyawan_id` = $karyawan
								GROUP BY `tb_nilai`.`karyawan_id`
							";
				$cariTotal = $this->db->query($queryAs)->row_array();
				$excel->setActiveSheetIndex(0)
					->setCellValue(chr($noB++) . $column, $cariTotal['jumlah'])
					->setCellValue(chr($noB++) . $column, round($cariTotal['total'], 1));
				$noB = 67;
				$column++;
			}

			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . $column, 'Jumlah');
			foreach ($pekerjaanproyekS as $pekerjaanproyek) {
				$proyek = $pekerjaanproyek['proyek_id'];
				$queryJml = "SELECT *,SUM(nilai) as jumlah
							FROM `tb_nilai`
							JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
							JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
							WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
							AND `tb_nilai`.`proyek_id` = $proyek
							GROUP BY `tb_nilai`.`proyek_id`
					";
				$cariS = $this->db->query($queryJml)->result_array();
				foreach ($cariS as $cari) {
					$excel->setActiveSheetIndex(0)
						->setCellValue(chr($noB++) . $column, $cari['jumlah']);
				}
			}
			$noB = 67;
			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . ($column + 1), 'Rata-Rata job');
			foreach ($pekerjaanproyekS as $pekerjaanproyek) {
				$proyek = $pekerjaanproyek['proyek_id'];
				$queryJml = "SELECT *,AVG(nilai) as rata
							FROM `tb_nilai`
							JOIN `tb_pekerjaan` ON `tb_pekerjaan`.`id_pekerjaan` = `tb_nilai`.`pekerjaan_id`
							JOIN `tb_data_proyek` ON `tb_data_proyek`.`id_proyek` = `tb_nilai`.`proyek_id`
							WHERE `tb_nilai`.`pekerjaan_id` = $pekerjaan_id
							AND `tb_nilai`.`proyek_id` = $proyek
							GROUP BY `tb_nilai`.`proyek_id`
					";
				$cariR = $this->db->query($queryJml)->result_array();
				foreach ($cariR as $cari) {
					$excel->setActiveSheetIndex(0)
						->setCellValue(chr($noB++) . ($column + 1), round($cari['rata'], 1));
				}
			}
			$noB = 67;
			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . ($column + 3), 'Daftar Skor Pegawai');
			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . ($column + 4), 'SEMESTER ' . $pekerjaan['semester'] . ' tahun ' . $pekerjaan['tahun']);
			$excel->setActiveSheetIndex(0)
				->setCellValue('A' . ($column + 5), 'job ' . $pekerjaan['job']);
		}
		$writer = new Xlsx($excel);
		$fileName = bin2hex(random_bytes(12));

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		exit;
	}
}
