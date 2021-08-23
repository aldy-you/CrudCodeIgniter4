<?php

namespace App\Controllers;

use App\Models\BiodataModel;

class Biodata extends BaseController
{
    //deklarasi variabel biodata
    protected $biodata;
    public function __construct()
    {
        //fungsi untuk menjalankan model 
        $this->biodata = new BiodataModel();
    }

    public function index()
    {
        //fungsi untuk mengambil semua data
        $result = $this->biodata->findAll();
        //fungsi passing data ke view
        $data = [
            'title' => 'Biodata',
            'biodata' => $result
        ];
        //fungsi untuk mengembalikan data ke view biodata
        return view('biodata/index', $data);
    }

    public function create()
    {
        //fungsi passing data ke view
        $data = [
            'title' => 'Tambah Data',
            'validation' => \Config\Services::validation()
        ];
        //fungsi untuk mengembalikan data ke view biodata
        return view('biodata/create', $data);
    }

    public function save()
    {
        //mengecek validasi setiap form pengisian
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[biodata.nama]',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                    'is_unique' => 'Nama sudah ada.'
                ]
            ],
            'jk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ]
        ])) {
            //fungsi mengaktifkan validation
            $validation = \Config\Services::validation();
            //fungsi untuk mengarahkan halaman edit jika form isian belom lengkap
            return redirect()->to('/biodata/create')->withInput()->with('validation', $validation);
        }

        //mengambil value nama dan mengubah ke lowercase dan menyimpannya ke slug
        $slug = url_title($this->request->getVar('nama'), '-', true);
        //fungsi untuk menyimpan data
        $this->biodata->save([
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'jk' => $this->request->getVar('jk'),
            'alamat' => $this->request->getVar('alamat')
        ]);
        //memberi notifikasi data berhasil disimpan
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');
        //kembali ke halaman awal
        return redirect()->to('/');
    }

    public function delete($id_biodata)
    {
        //fungsi hapus data
        $this->biodata->delete($id_biodata);
        //memberi notifikasi data berhasil dihapus
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        //kembali ke halaman awal
        return redirect()->to('/');
    }

    public function edit($slug)
    {
        //fungsi passing data ke view
        $data = [
            'title' => 'Ubah Data',
            'validation' => \Config\Services::validation(),
            'biodata' => $this->biodata->getBiodata($slug)
        ];
        //fungsi untuk mengembalikan data ke view biodata
        return view('biodata/update', $data);
    }

    public function update($id_biodata)
    {
        //fungsi untuk mengecek apakah ada nama yang sama
        $nama_old = $this->biodata->getbiodata($this->request->getVar('slug'));
        if ($nama_old['nama'] == $this->request->getVar('nama')) {
            //jika nama tidak diubah
            $nama = 'required';
        } else {
            //jika nama diubah
            $nama = 'required|is_unique[biodata.nama]';
        }
        //mengecek validasi setiap form pengisian
        if (!$this->validate([
            'nama' => [
                'rules' => $nama,
                'errors' => [
                    'required' => 'Nama harus diisi.',
                    'is_unique' => 'Nama sudah ada.'
                ]
            ],
            'jk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ]
        ])) {
            //fungsi mengaktifkan validation
            $validation = \Config\Services::validation();
            //fungsi untuk mengarahkan halaman edit jika form isian belom lengkap
            return redirect()->to('/biodata/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        //mengambil value nama dan mengubah ke lowercase dan menyimpannya ke slug
        $slug = url_title($this->request->getVar('nama'), '-', true);
        //fungsi untuk menyimpan data
        $this->biodata->save([
            'id_biodata' => $id_biodata,
            'nama' => $this->request->getVar('nama'),
            'slug' => $slug,
            'jk' => $this->request->getVar('jk'),
            'alamat' => $this->request->getVar('alamat')
        ]);
        //memberi notifikasi data berhasil diubah
        session()->setFlashdata('pesan', 'Data berhasil diubah!');
        //kembali ke halaman awal
        return redirect()->to('/');
    }
}
