<main role="main" class="ml-sm-auto px-4">

    <div class="card mt-3 mb-3 tabla-datos">
        <div class="card-header text-white header-nivel2">
            <?= $evaluacion['cve_proyecto'] ?> - <?= $evaluacion['periodo'] ?>: <?= $evaluacion['tipo_evaluacion'] ?> (<?= $evaluacion['dependencia_responsable'] ?>)
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-4">
                    <label class="form-label">Tipo de evaluación</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['tipo_evaluacion'] ?>" readonly>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Periodo</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['periodo'] ?>" readonly>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Dependencia responsable</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['dependencia_responsable'] ?>" readonly>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-sm-4">
                    <label class="form-label">Método de financiamiento</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['metodo_financiamiento'] ?>" readonly>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Evaluador</label>
                    <input type="text" class="form-control" value="<?= $evaluacion['nom_evaluador'] ?>" readonly>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">Costo de evaluación</label>
                    <input type="text" class="form-control" value="$ <?= number_format($evaluacion['costo_total_evaluacion'], 0) ?>" readonly>
                </div>
            </div>
            <hr class="pb-3"/>
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
            <div class="row mb-3">
                <div class="col-sm-12">
                    <?php
                    $liga_conag = $evaluacion['liga_conag'];
                    ?>
                    <label class="form-label">Liga conag</label>
                    <label class="form-control"><a href="<?=$liga_conag?>" target="_blank"><?= $liga_conag ?></a></label>
                </div>
            </div>
        </div>
    </div>

    <hr />
    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>proyectos/detalle/<?=$proyecto['cve_proyecto']?>" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
