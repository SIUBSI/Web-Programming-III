<?php
defined('BASEPATH') or exit('No Direct script access allowed');
class Laporan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function laporan_buku()
	{
		$data['judul'] = 'Laporan Data Buku';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['buku'] = $this->ModelBuku->getBuku()->result_array();
		$data['kategori'] = $this->ModelBuku->getKategori()->result_array();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('buku/laporan_buku', $data);
		$this->load->view('templates/footer');
	}

	public function cetak_laporan_buku()
	{
		$data['buku'] = $this->ModelBuku->getBuku()->result_array();
		$data['kategori'] = $this->ModelBuku->getKategori()->result_array();

		$this->load->view('buku/laporan_print_buku', $data);
	}

	public function laporan_buku_pdf()
	{
		$this->load->library('Dompdf_gen');

		$data['buku'] = $this->ModelBuku->getBuku()->result_array();

		$this->load->view('buku/laporan_pdf_buku', $data);

		$paper = 'A4';
		$orien = 'landscape';
		$html = $this->output->get_output();
		
		$this->dompdf->set_paper($paper, $orien);
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		$this->dompdf->stream('laporan_data_buku.pdf');
	}

	public function export_excel()
	{
		$data = array(
			'title' => 'Laporan Buku',
			'buku' => $this->ModelBuku->getBuku()->result_array()
		);
		
		$this->load->view('buku/export_excel_buku', $data);
	}

}