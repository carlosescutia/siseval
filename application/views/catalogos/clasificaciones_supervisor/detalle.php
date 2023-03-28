<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>clasificaciones_supervisor/guardar/<?= $clasificacion_supervisor['id_clasificacion_supervisor'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar clasificación de supervisor</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_clasificacion_supervisor" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_clasificacion_supervisor" id="id_clasificacion_supervisor" value="<?=$clasificacion_supervisor['id_clasificacion_supervisor'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_clasificacion_supervisor" class="col-sm-2 col-form-label">Clasificación</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_clasificacion_supervisor" id="nom_clasificacion_supervisor" value="<?=$clasificacion_supervisor['nom_clasificacion_supervisor'] ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="orden" class="col-sm-2 col-form-label">Orden</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="orden" id="orden" value="<?=$clasificacion_supervisor['orden'] ?>">
                </div>
            </div>
        </div>

    </form>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>clasificaciones_supervisor" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
