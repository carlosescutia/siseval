<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>criterios_calificacion/guardar/<?= $criterio_calificacion['id_criterio_calificacion'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar criterio de calificacion</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_criterio_calificacion" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control" name="id_criterio_calificacion" id="id_criterio_calificacion" value="<?=$criterio_calificacion['id_criterio_calificacion'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_criterio" class="col-sm-2 col-form-label">Criterio de calificación</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_criterio" id="nom_criterio" value="<?=$criterio_calificacion['nom_criterio'] ?>">
                </div>
            </div>
        </div>

    </form>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>criterios_calificacion" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
