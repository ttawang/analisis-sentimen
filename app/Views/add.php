<?= $this->extend('container') ?>

<?= $this->section('content') ?>

<form action="" method="post" id="text-editor">
    <div class="form-group col-6">
        <label for="title">Date</label>
        <!--input type="text" name="title" class="form-control" placeholder="News title" required-->
        <input type="date" name="tanggal"  class="form-control" id="date-input">
    </div>
    <div class="form-group col-6">
    <select class="form-control " name="ket">
        <option value="0">Positif</option>
        <option value="1">Negatif </option>
    </select>
    </div>
    <div class="form-group col-12">
        <label for="title">Tweet</label>
        <textarea name="kalimat" class="form-control" cols="30" rows="10" placeholder="Write a tweet here !" required></textarea>
    </div>
    <div class="form-group col-2">
        <button type="submit" name="status" class="btn btn-primary">Proses</button>
        <a href=<?= base_url('/home') ?>>
            <button type="button" class="btn btn-dark">Home</a></button>
        </a>
        
    </div>
</form>


<?= $this->endSection() ?>