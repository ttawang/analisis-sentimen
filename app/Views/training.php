<?= $this->extend('container') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-black">
        <h5 class="text-center">Data Test</h5>
        
    </div>

    <div class="card-body table-responsive p-0" style="height: 380px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Klasifikasi</th>
                    <th>Tweet</th>
                    <?php ?>
                </tr>
            </thead>
            <tbody>
                <?php $n=1?>
                <?php if(isset($kalimat) && count($kalimat) > 0): ?> 
                    <?php foreach($kalimat as $a => $value):?>
                    <tr>
                        <td><?= $n ?></td>
                        <td><?= $tanggal[$a]; ?></td>
                        <?php if ($ket[$a] == 0): ?>
                            <td>positif</td>
                        <?php else : ?>
                            <td>negatif</td>
                        <?php endif ?>
                        <td><?= $kalimat[$a] ?></td>
                        <td></td>
                        <?php $n++ ?>
                    </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">No record found.</td>
                     </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
<!--
<a href=<!?= base_url('/home') ?>>
    <button type="button" class="btn btn-dark btn-lg col-3">Home</a></button>
</a>
<!?php foreach($k as $b):?>
    <a href=<!?= base_url('k/'.$b['id']) ?>> 
    <button type="button" class="btn btn-danger btn-lg col-3">Calculate</button>
</a>
<!?php endforeach ?>
-->
<?= $this->endSection() ?>