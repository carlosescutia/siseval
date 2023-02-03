<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Histórico de evaluaciones</div>
    <div class="card-body">
        <div class="col-sm-12 alternate-color">
            <?php foreach ($evaluaciones as $evaluaciones_item) { ?>
                <p><a href="<?=base_url()?>evaluaciones/detalle/<?= $evaluaciones_item['id_evaluacion'] ?>"><?= $evaluaciones_item['periodo'] ?> <?= $evaluaciones_item['tipo_evaluacion'] ?> <?= $evaluaciones_item['dependencia_responsable'] ?></a></p>
            <?php } ?>
        </div>
    </div>
</div>
