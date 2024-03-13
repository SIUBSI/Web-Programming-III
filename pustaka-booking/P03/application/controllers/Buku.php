<?php


class Buku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }
    
    // Region Kategori
    public function kategori()
    {
        $data['judul'] = 'Kategori Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();
        $this->form_validation->set_rules(
            'kategori', 
            'Kategori',
            'required', [
                'required' => 'Judul Buku harus diisi'
        ]);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = ['kategori' => $this->input->post('kategori')];
            $this->ModelBuku->simpanKategori($data);
            redirect('buku/kategori');
        }
    }

    public function ubahkategori()
    {
        $data['judul'] = 'Ubah Kategori Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $where = ['id_kategori' =>  $this->uri->segment(3)];
        $data['kategori'] = $this->ModelBuku->kategoriWhere($where)->row_array();
        
        
        $this->form_validation->set_rules(
            'kategori', 
            'Kategori',
            'required', [
                'required' => 'Judul Buku harus diisi'
        ]);

        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/ubah_kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = ['kategori' => $this->input->post('kategori')];
            $this->ModelBuku->updateKategori(['id_kategori' => $this->input->post('id_kategori')], $data);
            redirect('buku/kategori');
        }
    }

    public function hapusKategori()
    {
        $where = ['id_kategori' => $this->uri->segment(3)];
        $this->ModelBuku->hapusKategori($where);
        redirect('buku/kategori');
    }


    // Region Buku
    public function index()
    {
        $data['judul'] = 'Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('buku/index', $data);
        $this->load->view('templates/footer');
        
    }

    public function ubahBuku()
    {
        $data['judul'] = 'Ubah Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->bukuWhere(['id' => $this->uri->segment(3)])->row_array();
        $kategori = $this->ModelBuku->joinKategoriBuku(['buku.id' => $this->uri->segment(3)])->result_array();
        
        foreach ($kategori as $k) 
        {
            $data['id'] = $k['id_kategori'];
            $data['k'] = $k['kategori'];
        }
        
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();


        $this->form_validation->set_rules(
            'judul_buku', 
            'Judul Buku', 
            'required|min_length[3]', [
                'required' => 'Judul Buku harus diisi',
                'min_length' => 'Judul buku terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'id_kategori', 
            'Kategori',
            'required', [
                'required' => 'Kategori Buku harus diisi',
        ]);
        $this->form_validation->set_rules(
            'pengarang', 
            'Nama Pengarang', 
            'required|min_length[3]', [
                'required' => 'Nama pengarang harus diisi', 
                'min_length' => 'Nama pengarang terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'penerbit', 
            'Nama Penerbit', 
            'required|min_length[3]', [
                'required' => 'Nama penerbit harus diisi',
                'min_length' => 'Nama penerbit terlalu pendek'
        ]);
        $this->form_validation->set_rules(
            'tahun_terbit', 
            'Tahun Terbit',
            'required|min_length[3]|max_length[4]|numeric', [
                'required' => 'Tahun terbit harus diisi',
                'min_length' => 'Tahun terbit terlalu pendek',
                'max_length' => 'Tahun terbit terlalu panjang',
                'numeric' => 'Hanya boleh diisi angka'
        ]);
        $this->form_validation->set_rules(
            'isbn',
            'Nomor ISBN',
            'required|min_length[3]|numeric', [
                'required' => 'Nama ISBN harus diisi',
                'min_length' => 'Nama ISBN terlalu pendek',
                'numeric' => 'Yang anda masukkan bukan angka'
        ]);
        $this->form_validation->set_rules(
            'stok', 
            'Stok',
            'required|numeric', [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukkan bukan angka'
        ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '1024';
        $config['max_height'] = '1000';
        $config['file_name'] = 'img' . time();

        //memuat atau memanggil library upload
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/ubah_buku', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) 
            {
                $image = $this->upload->data();
                unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE));
                $gambar = $image['file_name'];
            } else {
                $gambar = $this->input->post('old_pict', TRUE);
            }
            
            // data postingan
            $data = [
                'judul_buku' => $this->input->post('judul_buku'),
                'id_kategori' => $this->input->post('id_kategori'),
                'pengarang' => $this->input->post('pengarang'),
                'penerbit' => $this->input->post('penerbit'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'isbn' => $this->input->post('isbn'),
                'stok' => $this->input->post('stok'),
                'image' => $gambar
            ];
            // $this->ModelBuku->updateBuku($data, ['id' => $this->input->post('id')]);
            $this->ModelBuku->updateBuku(['id' => $this->input->post('id')], $data);
            redirect('buku');
        }
    }
    public function hapusBuku()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelBuku->hapusBuku($where);
        redirect('buku');
    }

}