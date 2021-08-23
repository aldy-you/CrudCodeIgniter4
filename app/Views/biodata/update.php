<!-- fungsi untuk menggabungkan content ke file template.php -->
<?= $this->extend('layout/template'); ?>
<!-- fungsi untuk section content -->
<?= $this->section('content'); ?>
<div class="container">
    <br />
    <h4>Ubah Data</h4>
    <hr width="250px" align="left">
    <div class="row mt-4">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <a href="/" class="btn btn-secondary btn-sm my-3">Kembali</a>
            <form action="/biodata/update/<?= $biodata['id_biodata']; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="hidden" name="slug" value="<?= $biodata['slug']; ?>">
                    <input type="text" name="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" value="<?= old(('nama')) ? old('nama') : $biodata['nama']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jk" class="form-control">
                        <option value="Laki-Laki" <?= ($biodata['jk'] == "Laki-Laki" ? "selected" : ""); ?>>Laki-Laki</option>
                        <option value="Perempuan" <?= ($biodata['jk'] == "Perempuan" ? "selected" : ""); ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" cols="30" rows="10"><?= old(('alamat')) ? old('alamat') : $biodata['alamat']; ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->EndSection(); ?>