<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<div class="card mt-0 mb-3">
    <div class="card-body">
        <table class="table table-striped table-sm">
            <tbody>
                <tr>
                    <td>Fecha de elaboración</td>
                    <td><label><?= date('d/m/Y', strtotime($plan_accion['fecha_elaboracion'])) ?></label></td>
                </tr>
                <tr>
                    <td>Nombre de la dependencia responsable</td>
                    <td><label><?=$propuesta_evaluacion['nom_dependencia'] ?></label></td>
                </tr>
                <tr>
                    <td>Nombre de la intervención pública</td>
                    <td><label><?=$propuesta_evaluacion['nom_proyecto'] ?></label></td>
                </tr>
                <tr>
                    <td>Tipo de evaluación</td>
                    <td><label><?=$propuesta_evaluacion['nom_tipo_evaluacion'] ?></label></td>
                </tr>
                <tr>
                    <td>Año de aplicación de la evaluación</td>
                    <td><label><?=$propuesta_evaluacion['periodo'] ?></label></td>
                </tr>
                <tr>
                    <td>Instancia evaluadora</td>
                    <td><label><?=$documento_opinion['instancia_evaluadora'] ?></label></td>
                </tr>
                <tr>
                    <td>Elaborado por</td>
                    <td><label><?=$documento_opinion['elaborado_por'] ?></label></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><label><?=$plan_accion['status'] ?></label>
                        <?php
                            $permisos_requeridos = array(
                            'plan_accion.can_edit',
                            'valoracion.etapa_activa',
                            'anio_activo',
                            );
                        ?>
                        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                            <?php if ($plan_accion['status'] == 'en_proceso' and $recomendaciones_tienen_actividad) { ?>
                                <a href="<?=base_url()?>valoracion/plan_accion_revision/<?=$plan_accion['id_plan_accion']?>" class="btn btn-success btn-sm">Enviar a revisión</a>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
        </form>
        <div class="col-12">
            <div class="row text-danger text-center">
                <p class="mb-0"><?= $error_ponderaciones ?></p>
            </div>
        </div>
    </div>
</div>
