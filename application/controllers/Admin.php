<?php
defined('BASEPATH') or exit('No direct script access allowed');
// memanggil autoload library phpoffice
require('./application/third_party/phpoffice/vendor/autoload.php');

// Memanggil namespace class yang berada di library phpoffice
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Load Model
		// Parameter pertama load file model, Parameter kedua adalah nama alias dari model parameter pertama
		$this->load->model('manager_model', 'manager_m');
		$this->load->model('karyawan_model', 'karyawan_m');
		$this->load->model('proyek_model', 'proyek_m');
		$this->load->model('tahun_model', 'ta_m');
		$this->load->model('pekerjaan_model', 'pekerjaan_m');
		is_logged_not_in(); // Jika sudah login, lalu mengakses halaman login maka tidak akan bisa dan akan d alihkan ke halaman admin
	}
	public function index()
	{
		$data = [
			'judul' => 'Admin | Home',
			'viewUtama' => 'admin/contents/index',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
		];
		$this->load->view('admin/layouts/wrapperIndex', $data);
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
				'judul' => 'Admin | Tambah pekerjaan',
				'viewUtama' => 'admin/contents/profil',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->manager_m->ubahProfil();
			$this->session->set_flashdata('success', 'Profil berhasil diubah.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/profil'); // redirect ke halaman profil
		}
	}
	public function manager()
	{
		$data = [
			'judul' => 'Admin | Kelola manager',
			'viewUtama' => 'admin/contents/manager',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'managerS' => $this->db->get_where('tb_autentikasi', ['role' => 'manager'])->result_array()
		];
		$this->load->view('admin/layouts/wrapperData', $data);
	}
	public function add_manager()
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_dash|max_length[25]');
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[25]');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('nip', 'NIP', 'required|numeric|max_length[20]');
		$this->form_validation->set_rules('pendidikan_terakhir', 'Pendidikan', 'required|max_length[25]');
		$this->form_validation->set_rules('agama', 'Agama', 'required|max_length[25]');
		$this->form_validation->set_rules('no_hp', 'No Handphone', 'required|numeric|max_length[13]');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|max_length[100]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman manager
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_manager',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->manager_m->simpanmanager(); // Insert data manager
			$this->session->set_flashdata('success', 'Data berhasil dibuat.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/manager'); // redirect ke halaman manager
		}
	}
	public function karyawan()
	{
		$data = [
			'judul' => 'Admin | Kelola karyawan',
			'viewUtama' => 'admin/contents/karyawan',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'karyawanS' => $this->db->get('tb_data_karyawan')->result_array()
		];
		$this->load->view('admin/layouts/wrapperData', $data);
	}
	public function add_karyawan()
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[25]');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('nama_ibu', 'Nama ibu', 'required|max_length[13]');
		$this->form_validation->set_rules('tahun_masuk', 'Tahun Masuk', 'required|max_length[4]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman karyawan
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_karyawan',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->karyawan_m->simpankaryawan(); // Insert data karyawan
			$this->session->set_flashdata('success', 'Data berhasil dibuat.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/karyawan'); // redirect ke halaman karyawan
		}
	}
	public function update_karyawan($id_karyawan)
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[25]');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('nama_ibu', 'Nama ibu', 'required|max_length[13]');
		$this->form_validation->set_rules('tahun_masuk', 'Tahun Masuk', 'required|max_length[4]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman karyawan
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_karyawan',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
				'karyawan' => $this->db->get_where('tb_data_karyawan', ['id_karyawan' => $id_karyawan])->row_array()
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->karyawan_m->ubahkaryawan($id_karyawan); // Insert data karyawan
			$this->session->set_flashdata('success', 'Data berhasil diubah.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/karyawan'); // redirect ke halaman karyawan
		}
	}
	public function proyek()
	{
		$data = [
			'judul' => 'Admin | Kelola proyek',
			'viewUtama' => 'admin/contents/proyek',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'proyekS' => $this->db->get('tb_data_proyek')->result_array()
		];
		$this->load->view('admin/layouts/wrapperData', $data);
	}
	public function add_proyek()
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('kode_proyek', 'Kode proyek', 'required|max_length[10]|is_unique[tb_data_proyek.kode_proyek]');
		$this->form_validation->set_rules('proyek', 'proyek', 'required|max_length[25]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman proyek
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_proyek',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->proyek_m->simpanproyek(); // Insert data proyek
			$this->session->set_flashdata('success', 'Data berhasil dibuat.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/proyek'); // redirect ke halaman proyek
		}
	}
	public function update_proyek($id_proyek)
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('kode_proyek', 'Kode proyek', 'required|max_length[10]');
		$this->form_validation->set_rules('proyek', 'proyek', 'required|max_length[25]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman proyek
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_proyek',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
				'proyek' => $this->db->get_where('tb_data_proyek', ['id_proyek' => $id_proyek])->row_array()
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->proyek_m->ubahproyek($id_proyek); // Insert data proyek
			$this->session->set_flashdata('success', 'Data berhasil diubah.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/proyek'); // redirect ke halaman proyek
		}
	}
	public function tahun()
	{
		$data = [
			'judul' => 'Admin | Kelola tahun',
			'viewUtama' => 'admin/contents/tahun',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'tahunS' => $this->db->get('tb_data_tahun')->result_array()
		];
		$this->load->view('admin/layouts/wrapperData', $data);
	}
	public function add_tahun()
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('tahun', 'tahun', 'required|max_length[15]');
		$this->form_validation->set_rules('semester', 'Semester', 'required|numeric|max_length[5]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman tahun
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_tahun',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->ta_m->simpantahun(); // Insert data tahun
			$this->session->set_flashdata('success', 'Data berhasil dibuat.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/tahun'); // redirect ke halaman tahun
		}
	}
	public function update_tahun($id_ta)
	{
		// Parameter pertama untuk name input, Parameter kedua bebas, Parameter ketiga aturan input
		$this->form_validation->set_rules('tahun', 'tahun', 'required|max_length[15]');
		$this->form_validation->set_rules('semester', 'Semester', 'required|numeric|max_length[5]');

		// Jika validasi gagal, akan muncul error di input dan kembali ke halaman tahun
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul' => 'Admin',
				'viewUtama' => 'admin/contents/form_tahun',
				'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(),
				'tahun' => $this->db->get_where('tb_data_tahun', ['id_ta' => $id_ta])->row_array()
			];
			$this->load->view('admin/layouts/wrapperForm', $data);
			// Jika validasi tidak gagal
		} else {
			$this->ta_m->ubahtahun($id_ta); // Insert data tahun
			$this->session->set_flashdata('success', 'Data berhasil diubah.'); // Membuat pesan notif jika insert data berhasil
			redirect('admin/tahun'); // redirect ke halaman tahun
		}
	}
	public function pekerjaan()
	{
		$data = [
			'judul' => 'Admin | pekerjaan',
			'viewUtama' => 'admin/contents/pekerjaan',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'pekerjaanS' => $this->pekerjaan_m->getpekerjaan()->result_array()
		];
		$this->load->view('admin/layouts/wrapperData', $data);
	}
	public function lihat_nilai($pekerjaan_id)
	{
		$data = [
			'judul' => 'Admin | Nilai',
			'viewUtama' => 'admin/contents/lihat_nilai',
			'cekUser' => $this->db->get_where('tb_autentikasi', ['username' => $this->session->userdata('username')])->row_array(), // cek user yang login berdasarkan session username,
			'pekerjaan' => $this->pekerjaan_m->getpekerjaan($pekerjaan_id)->row_array(),
			'pekerjaanproyekS' => $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id),
			'pekerjaankaryawanS' => $this->pekerjaan_m->getpekerjaankaryawan($pekerjaan_id),
			'lihat_nilai' => $this->pekerjaan_m->lihatNilai($pekerjaan_id),
			'pekerjaan_id' => $pekerjaan_id
		];
		$this->load->view('admin/layouts/wrapperData', $data);
	}
	public function excel($pekerjaan_id)
	{
		$pekerjaan =  $this->pekerjaan_m->getpekerjaan($pekerjaan_id)->row_array();
		$pekerjaanproyekS = $this->pekerjaan_m->getpekerjaanproyek($pekerjaan_id);
		$pekerjaankaryawanS = $this->pekerjaan_m->getpekerjaankaryawan($pekerjaan_id);
		// Ini Instance untuk export Excel
		$excel = new Spreadsheet();

		$excel->getProperties()->setCreator('Kelompok11')
			->setLastModifiedBy('Kelompok11')
			->setTitle('Excel Penilaian')
			->setSubject("DAFTAR HASIL Penilaian Karyawan")
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
				$queryAs = "SELECT SUM(nilai) as jumlah, AVG(nilai) as total
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
				$queryJml = "SELECT SUM(nilai) as jumlah
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
				->setCellValue('A' . ($column + 1), 'Rata-Rata');
			foreach ($pekerjaanproyekS as $pekerjaanproyek) {
				$proyek = $pekerjaanproyek['proyek_id'];
				$queryJml = "SELECT AVG(nilai) as rata
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
