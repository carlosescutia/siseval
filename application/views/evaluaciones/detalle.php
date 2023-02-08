<main role="main" class="ml-sm-auto px-4">

    <div class="card mt-3 mb-3 tabla-datos">
        <div class="card-header text-white bg-primary">
            <?= $evaluacion['cve_proyecto'] ?> - <?= $evaluacion['periodo'] ?>: <?= $evaluacion['tipo_evaluacion'] ?> (<?= $evaluacion['dependencia_responsable'] ?>)
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label class="form-label">Fecha final del cronograma</label>
                    <?php
                    $myDate = $evaluacion['fecha_final_cronograma'];
                    $tempDate = date_create("$myDate");
                    $newDate = date_format($tempDate, 'd/m/Y'); ?>
                    <input type="text" class="form-control" value="<?= $newDate ?>" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Fecha final efectiva</label>
                    <?php
                    $myDate = $evaluacion['fecha_final_efectiva'];
                    $tempDate = date_create("$myDate");
                    $newDate = date_format($tempDate, 'd/m/Y'); ?>
                    <input type="text" class="form-control" value="<?= $newDate ?>" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Método de financiamiento</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['metodo_financiamiento'] ?>" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Evaluador</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['nom_evaluador'] ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label class="form-label">Costo total de la evaluación</label>
                    <input type="text" class="form-control" value="$ <?= number_format($evaluacion['costo_total_evaluacion'], 2) ?>" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Origen AAE</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['origen_aae'] ?>" readonly>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Documento probatorio del financiamiento</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['documento_probatorio_financiamiento'] ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <?php
                    $liga_general_informe_evaluacion = $evaluacion['liga_general_informe_evaluacion'];
                    ?>
                    <label class="form-label">Liga general del informe de la evaluacion</label>
                    <label class="form-control"><a href="<?=$liga_general_informe_evaluacion?>" target="_blank"><?= $liga_general_informe_evaluacion ?></a></label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <?php
                    $liga_directa_informe_evaluacion = $evaluacion['liga_directa_informe_evaluacion'];
                    ?>
                    <label class="form-label">Liga directa del informe de la evaluacion</label>
                    <label class="form-control"><a href="<?=$liga_directa_informe_evaluacion?>" target="_blank"><?= $liga_directa_informe_evaluacion ?></a></label>
                </div>
            </div>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos/detalle/<?=$proyecto['cve_proyecto']?>" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
