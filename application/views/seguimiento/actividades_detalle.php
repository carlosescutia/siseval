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
            Actividad
        </div>
        <form method="post" action="<?= base_url() ?>seguimiento/avance_guardar">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-7">
                        <label for="desc_actividad">
                            Actividad
                        </label>
                        <textarea rows="2" class="form-control" name="desc_actividad" id="desc_actividad" readonly><?= $actividad['desc_actividad'] ?></textarea>
                    </div>
                    <div class="col-sm-2">
                        <label for="unidad_medida">
                            Unidad de medida
                        </label>
                        <input type="text" class="form-control" name="unidad_medida" id="unidad_medida" value="<?= $actividad['unidad_medida'] ?>" readonly >
                    </div>
                    <div class="col-sm-3">
                        <label for="resultados_esperados">
                            Resultados esperados
                        </label>
                        <input type="text" class="form-control" name="resultados_esperados" id="resultados_esperados" value="<?= $actividad['resultados_esperados'] ?>" readonly >
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-3">
                        <label for="fech_ini">
                            Fecha inicial
                        </label>
                        <input type="date" class="form-control" name="fech_ini" id="fech_ini" value="<?= $actividad['fech_ini'] ?>" readonly >
                    </div>
                    <div class="col-sm-3">
                        <label for="fech_fin">
                            Fecha final
                        </label>
                        <input type="date" class="form-control" name="fech_fin" id="fech_fin" value="<?= $actividad['fech_fin'] ?>" readonly >
                    </div>
                    <div class="col-sm-4">
                        <label for="area_responsable">
                            Área responsable
                        </label>
                        <input type="text" class="form-control" name="area_responsable" id="area_responsable" value="<?= $actividad['area_responsable'] ?>" readonly >
                    </div>
                    <div class="col-sm-2">
                        <label for="ponderacion">
                            Ponderación
                        </label>
                        <input type="text" class="form-control" name="ponderacion" id="ponderacion" value="<?= $actividad['ponderacion'] ?>" readonly >
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <label for="registro_avance">
                            Registro de avance
                        </label>
                        <input type="text" class="form-control" name="registro_avance" id="registro_avance" value="<?= $actividad['registro_avance'] ?>" >
                    </div>
                    <div class="col-sm-7">
                        <label for="comentarios_avance">
                            Comentarios sobre el avance
                        </label>
                        <textarea rows="2" class="form-control" name="comentarios_avance" id="comentarios_avance"><?= $actividad['comentarios_avance'] ?></textarea>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id_actividad" value="<?= $actividad['id_actividad'] ?>">
            <input type="hidden" name="cve_recomendacion" value="<?= $actividad['cve_recomendacion'] ?>">
            <input type="hidden" name="id_plan_accion" value="<?= $actividad['id_plan_accion'] ?>">

            <?php
                $permisos_requeridos = array(
                'seguimiento.can_edit',
                'seguimiento.etapa_activa',
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
        <a href="<?=base_url()?>seguimiento/detalle/<?=$actividad['id_plan_accion']?>" class="btn btn-secondary boton">Volver</a>
    </div>
</div>

