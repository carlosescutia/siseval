<main role="main" class="ml-sm-auto px-4">

    <form method="post" action="<?= base_url() ?>justificaciones_evaluacion/guardar/<?= $justificacion_evaluacion['id_justificacion_evaluacion'] ?>">

        <div class="col-md-12 mb-3 pb-2 pt-3 border-bottom">
            <div class="row">
                <div class="col-md-10">
                    <h1 class="h2">Editar justificación de evaluación</h1>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group row">
                <label for="id_justificacion_evaluacion" class="col-sm-2 col-form-label">Clave</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_justificacion_evaluacion" id="id_justificacion_evaluacion" value="<?=$justificacion_evaluacion['id_justificacion_evaluacion'] ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nom_justificacion_evaluacion" class="col-sm-2 col-form-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nom_justificacion_evaluacion" id="nom_justificacion_evaluacion" value="<?=$justificacion_evaluacion['nom_justificacion_evaluacion'] ?>">
                </div>
            </div>
        </div>

    </form>

    <hr />

    <div class="form-group row">
        <div class="col-sm-10">
            <a href="<?=base_url()?>justificaciones_evaluacion" class="btn btn-secondary boton">Volver</a>
        </div>
    </div>

</main>
