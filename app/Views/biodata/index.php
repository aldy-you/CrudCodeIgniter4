<!-- fungsi untuk menggabungkan content ke file template.php -->
<?= $this->extend('layout/template'); ?>
<!-- fungsi untuk section content -->
<?= $this->section('content'); ?>
<div class="container">
    <br />
    <h4>CRUD CI 4 Biodata </h4>
    <hr width="250px" align="left">
    <a href="/biodata/create" class="btn btn-primary btn-sm mt-4">Tambah</a>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success mt-4" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
    <table class="table table-bordered table-striped table-hover mt-4">
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th style="width: 157px;">Opsi</th>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($biodata as $b) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $b['nama'];; ?></td>
                    <td><?= $b['jk']; ?></td>
                    <td><?= $b['alamat']; ?></td>
                    <td>
                        <a href="/biodata/edit/<?= $b['slug']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="/biodata/delete/<?= $b['id_biodata']; ?>" method="post" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda ingin menghapus?');">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->EndSection(); ?>