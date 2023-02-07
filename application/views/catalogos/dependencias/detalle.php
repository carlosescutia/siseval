<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>dependencias/guardar/<?= $dependencias['cve_dependencia'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar dependencia</h1>
                </div>
                <div class="col-md-2 text-right">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="cve_dependencia" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cve_dependencia" id="cve_dependencia" value="<?=$dependencias['cve_dependencia'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_completo_dependencia" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_completo_dependencia" id="nom_completo_dependencia" value="<?=$dependencias['nom_completo_dependencia'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_dependencia" class="col-sm-2 col-form-label">Siglas</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_dependencia" id="nom_dependencia" value="<?=$dependencias['nom_dependencia'] ?>">
                </div>
            </div>
        </div>

    </form>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>dependencias" class="btn btn-secondary">Volver</a>
        </div>
    </div>

</main>
