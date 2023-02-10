<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Histórico de evaluaciones</div>
    <div class="card-body">
        <?php foreach ($evaluaciones as $evaluaciones_item) { ?>
            <div class="col-sm-12 ps-3 alternate-color">
                <div class="row">
                    <p><a href="<?=base_url()?>evaluaciones/detalle/<?= $evaluaciones_item['id_evaluacion'] ?>"><?= $evaluaciones_item['periodo'] ?>: <?= $evaluaciones_item['dependencia_responsable'] ?> - <?= $evaluaciones_item['tipo_evaluacion'] ?></a></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
