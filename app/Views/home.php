<?= $this->extend('container') ?>

<?= $this->section('content') ?>
    <div class="container-fluid">
     <div class="row">
       <div class="col-md-12">
          <?php 
          // Display Response
          if(session()->has('message')){
          ?>
             <div class="alert <?= session()->getFlashdata('alert-class') ?>">
                <?= session()->getFlashdata('message') ?>
             </div>
          <?php
          }
          ?>

          <?php $validation = \Config\Services::validation(); ?>

          <form method="post" action="<?=base_url('home/importFile')?>" enctype="multipart/form-data">

             <?= csrf_field(); ?>
             <div class="form-group">
                <label for="file">File:</label>

                <input type="file" class="form-control" id="file" name="file" />
                <!-- Error -->
                <?php if( $validation->getError('file') ) {?>
                <div class='alert alert-danger mt-2'>
                   <?= $validation->getError('file'); ?>
                </div>
                <?php }?>

             </div>

             <input type="submit" class="btn btn-danger" name="submit" value="Import CSV">
          </form>
       </div>
     </div>

<br>
<div class="card">
    
    <div class="card-header bg-black">
        <h5 class="text-center">Data Tweet</h5>
    </div>
    
    <div class="card-body table-responsive p-0" style="height: 380px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <?php if(isset($tweet) && count($tweet) > 0): ?> 
                        <th><a class="nav-icon fas fa-plus-square" href=<?= base_url('/add') ?>></a></th>
                    <?php endif ?>
                    <th>No</th>
                    <th>Date</th>
                    <th>Klasifikasi</th>
                    <th>Tweet</th>
                    <?php ?>
                </tr>
            </thead>
            <tbody>
                <?php $n=1?>
                <?php if(isset($tweet) && count($tweet) > 0): ?>    
                    <?php foreach($tweet as $a):?>
                    <tr>
                        <td>
                            <a class="nav-icon fas fa-edit" href=<?= base_url('edit/'.$a['id']) ?>></a>
                            <a class="nav-icon fas fa-trash" href="#" data-href=<?= base_url('home/'.$a['id']) ?> onclick="confirmToDelete(this)" class="btn btn-sm btn-outline-danger"></a>
                            
                        </td>
                        <td><?= $n ?></td>
                        <td><?= $a['tanggal'] ?></td>
                        <?php if ($a['ket'] == 0): ?>
                            <td>positif</td>
                        <?php else : ?>
                            <td>negatif</td>
                        <?php endif ?>
                        <td><?= $a['kalimat'] ?></td>
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

<!--Delete-->
<div id="confirm-dialog" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h2 class="h2">Are you sure?</h2>
        <p>The data will be deleted and lost forever</p>
      </div>
      <div class="modal-footer">
        <a href="#" role="button" id="delete-button" class="btn btn-danger">Delete</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
function confirmToDelete(el){
    $("#delete-button").attr("href", el.dataset.href);
    $("#confirm-dialog").modal('show');
}

</script>
<?= $this->endSection() ?>