<?= $this->extend('container') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header bg-black">
        <h5 class="text-center">MKNN/KNN</h5>
        
    </div>

    <div class="card-body table-responsive p-0" style="height: 380px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Manual</th>
                    <th>MKNN</th>
                    <th>KNN</th>
                    <th>Tweet</th>
                    <?php ?>
                </tr>
            </thead>
            <tbody>
                <?php $n=0?>    
                <?php foreach($kalimat as $a => $value):?>
                <tr>
                    
                        <td><?= $n+1 ?></td>
                        
                        <?php if ($ket[$a] == 0): ?>
                            <td>positif</td>
                        <?php else : ?>
                            <td>negatif</td>
                        <?php endif; ?>
                        
                        <?php if ($hasilmknn[3][$a] == 0): ?>
                            <td>positif</td>
                        <?php else : ?>
                            <td>negatif</td>
                        <?php endif; ?>

                        <?php if ($hasilknn[3][$a] == 0): ?>
                            <td>positif</td>
                        <?php else : ?>
                            <td>negatif</td>
                        <?php endif; ?>

                        <td><?= $kalimat[$a] ?></td>
                        <td></td>
                        <?php $n++ ?>
                    
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    
</div>



<div class="card">
    <!--div class="card-header bg-black">
        <h5 class="text-center">Comparing Method</h5>
        
    </div-->
    <!-- /.card-header -->
    <div class="card-body" style="height: 230px;">
        <div class="row">
            <div class="col-6">
                <!--div style="display:inline;width:90px;height:90px; ">
                    <canvas width="90" height="90"></canvas>
                    <input type="text" class="knob" value="100" data-width="150" data-height="150" data-fgcolor="#3c8dbc" data-readonly="true" readonly="readonly" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px; appearance: none;">
                    </div-->
                <div class="col-5">
                    <h3>MKNN</h3>
                    <table class="table table-head-fixed text-nowrap">
                        <tbody>
                            <tr>
                                <td>Accuracy</td>
                                <td><?php echo $hasilmknn[0] ?>%</td>
                            </tr>
                            <tr>
                                <td>Precission</td>
                                <td><?php echo $hasilmknn[1] ?>%</td>
                            </tr>
                            <tr>
                                <td>Recall</td>
                                <td><?php echo $hasilmknn[2] ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <!--div style="display:inline;width:90px;height:90px;">
                    <canvas width="90" height="90"></canvas>
                    <input type="text" class="knob" value="100" data-width="150" data-height="150" data-fgcolor="#f56954" data-readonly="true" readonly="readonly" style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px; background: none; font: bold 18px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;">
                    </div-->
                <div class="col-5">
                    <h3>KNN</h3>
                    <table class="table table-head-fixed text-nowrap">
                        <tbody>
                            <tr>
                                <td>Accuracy</td>
                                <td><?php echo $hasilknn[0] ?>%</td>
                            </tr>
                            <tr>
                                <td>Precission</td>
                                <td><?php echo $hasilknn[1] ?>%</td>
                            </tr>
                            <tr>
                                <td>Recall</td>
                                <td><?php echo $hasilknn[2] ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>  
        </div>
    </div>
    <!-- /.card-body -->
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