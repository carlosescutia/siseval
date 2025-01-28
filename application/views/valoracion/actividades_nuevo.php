<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<div class="col-sm-8 offset-sm-2 mt-3">
    <div class="card mt-0 mb-3">
        <div class="card-header text-white bg-primary">
            Nueva actividad
        </div>
        <form method="post" action="<?= base_url() ?>valoracion/actividades_guardar">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <label for="desc_actividad">
                            Actividad
                        </label>
                        <textarea rows="4" class="form-control" name="desc_actividad" id="desc_actividad" required></textarea>
                    </div>
                    <div class="col-sm-2">
                        <label for="unidad_medida">
                            Unidad de medida
                        </label>
                        <input type="text" class="form-control" name="unidad_medida" id="unidad_medida" required >
                    </div>
                    <div class="col-sm-5">
                        <label for="resultados_esperados">
                            Resultados esperados
                        </label>
                        <textarea rows="4" class="form-control" name="resultados_esperados" id="resultados_esperados" required></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="fech_ini">
                            Fecha inicial
                        </label>
                        <input type="date" class="form-control" name="fech_ini" id="fech_ini" required >
                    </div>
                    <div class="col-sm-3">
                        <label for="fech_fin">
                            Fecha final
                        </label>
                        <input type="date" class="form-control" name="fech_fin" id="fech_fin" required >
                    </div>
                    <div class="col-sm-4">
                        <label for="area_responsable">
                            Área responsable
                        </label>
                        <input type="text" class="form-control" name="area_responsable" id="area_responsable" required >
                    </div>
                    <div class="col-sm-2">
                        <label for="ponderacion">
                            Ponderación
                        </label>
                        <input type="text" class="form-control" name="ponderacion" id="ponderacion" required >
                    </div>
                </div>
                <div class="row mb-3">
                </div>
            </div>

            <input type="hidden" name="cve_dependencia" value="<?= $cve_dependencia ?>">
            <input type="hidden" name="id_plan_accion" value="<?= $id_plan_accion ?>">
            <input type="hidden" name="cve_recomendacion" value="<?= $cve_recomendacion ?>">
            <?php
            $permisos_requeridos = array(
                'plan_accion.can_edit',
                'valoracion.etapa_activa',
                'anio_activo',
            );
            ?>
            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                <div class="card-footer text-end">
                    <div class="row">
                        <div class="col-sm-12 text-end">
                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </form>
    </div>
</div>

<hr />

<div class="form-group row">
    <div class="col-sm-10">
        <a href="<?=base_url()?>valoracion/plan_accion_detalle/<?=$id_plan_accion?>" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
