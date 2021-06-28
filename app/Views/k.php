<?= $this->extend('container') ?>

<?= $this->section('content') ?>

<form action="" method="post" id="text-editor">
    <input type="hidden" name="id" value="<?= $kk['id'] ?>" />
    <div class="form-group col-6">
        <label for="title">Masukkan Nilai (K)</label>
        <!--input type="text" name="title" class="form-control" placeholder="News title" required-->
        
        <select class="form-control " name="k">
        <option value="3">3</option>
        <option value="5">5 </option>
        <option value="7">7 </option>
        <option value="9">9 </option>
        <option value="11">11 </option>
    </select>
    </div>
    <div class="form-group col-2">
        <button type="submit" name="status" class="btn btn-primary">Proses</button>
        <a href=<?= base_url('/home') ?>>
            <button type="button" class="btn btn-dark">Home</a></button>
        </a>
    </div>
</form>

<?= $this->endSection() ?>