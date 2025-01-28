<div class="mt-5 col-sm-8 offset-sm-2">
    <div class="card mt-3 mb-3">
        <div class="card-header text-bg-primary">
            <?= $dependencia['nom_dependencia'] ?> <?= $dependencia['nom_completo_dependencia'] ?>
        </div>
        <form method="post" action="<?= base_url() ?>dependencias_periodos/guardar/<?= $dependencia_periodo['id_dependencia_periodo'] ?>">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-2 mb-3">
                        <label for="periodo" class="form-label">Periodo</label>
                        <input type="text" class="form-control text-start" name="periodo" id="periodo" value="<?= $dependencia_periodo['periodo'] ?>">
                    </div>
                    <div class="col-sm-5 mb-3">
                        <label for="nom_completo_dependencia" class="form-label">Nombre</label>
                        <input type="text" class="form-control text-start" name="nom_completo_dependencia" id="nom_completo_dependencia" value="<?=$dependencia_periodo['nom_completo_dependencia'] ?>">
                    </div>
                    <div class="col-sm-2 mb-3">
                        <label for="nom_dependencia" class="form-label">Siglas</label>
                        <input type="text" class="form-control text-start" name="nom_dependencia" id="nom_dependencia" value="<?= $dependencia_periodo['nom_dependencia'] ?>">
                    </div>
                </div>
            </div>
            <input type="hidden" name="cve_dependencia" id="cve_dependencia" value="<?= $dependencia_periodo['cve_dependencia'] ?>">
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </div>
        </form>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?= base_url() ?>dependencias/detalle/<?= $dependencia['cve_dependencia'] ?>" class="btn btn-secondary">Volver</a>
    </div>
</div>
