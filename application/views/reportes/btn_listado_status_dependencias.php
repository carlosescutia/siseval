<?php
    $periodo = $userdata['anio_sesion'];
?>
<a href="<?= base_url() ?>reportes/listado_status_dependencias" style="text-decoration: none; color: black">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h3>Estatus de dependencias</h3>
                    <p>Estatus de dependencias durante proceso <?=$periodo?></p>
                </div>
                <div class="col-md-4">
                    <img src="<?=base_url();?>img/status_dependencias.png" class="img-fluid img-thumbnail p-0 m-0">
                </div>
            </div>
        </div>
    </div>
</a>
