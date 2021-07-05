<?= $this->extend('container') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-black">
        <h5 class="text-center">Data Prepocessing</h5>
        
    </div>

    <div class="card-body table-responsive p-0" style="height: 380px;">
        <table class="table table-head-fixed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tweet</th>
                    <th>Remove Url</th>
                    <th>Remove Username</th>
                    <th>Case Folding</th>
                    <th>Tokenizing</th>
                    <th>Stopword</th>
                    <th>Stemming</th>
                    <?php ?>
                </tr>
            </thead>
            <tbody>
                <?php $n=1?>    
                <?php if(isset($tweet) && count($tweet) > 0): ?> 
                    <?php foreach($tweet['kalimat'] as $a => $value):?>
                    <tr>
                        <td><?= $n ?></td>
                        <td><?= $tweet['kalimat'][$a] ?></td>
                        <td><?= $tweet['nourl'][$a] ?> </td>
                        <td><?= $tweet['nousername'][$a] ?> </td>
                        <td><?= $tweet['case folding'][$a] ?></td>
                        <td><?= $tweet['tokenizing'][$a] ?> </td>
                        <td><?= $tweet['stopword'][$a] ?></td>
                        <td><?= $tweet['stemming'][$a] ?></td>
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


<!--a href=<--?= base_url('/home') ?>>
    <button type="button" class="btn btn-dark btn-lg col-3">Home</a></button>
</a>
<--?php foreach($k as $b):?>
<a href=<--?= base_url('k/'.$b['id']) ?>> 
    <button type="button" class="btn btn-danger btn-lg col-3">Calculate</button>
</a>
<--?php endforeach ?>
<?= $this->endSection() ?>