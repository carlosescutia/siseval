<?php $num_rec = 0; ?>

<?php foreach ($recomendaciones as $recomendaciones_item) { ?>
    <?php $num_rec += 1; ?>
    <div class="card mt-3 mb-5">
        <div class="card-header text-bg-success">
            Recomendación <?=$num_rec?>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <label for="desc_recomendacion">
                        Recomendación
                    </label>
                    <textarea rows="4" class="form-control" name="desc_recomendacion" id="desc_recomendacion" readonly><?=$recomendaciones_item['desc_recomendacion']?></textarea>
                </div>
                <div class="col-sm-6">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label>
                                Clasificación por tipo de actor involucrado:
                            </label>
                            <label><strong><?=$recomendaciones_item['desc_tipo_actor']?></strong><label>
                        </div>
                        <div class="col-sm-6">
                            <label>
                                Nivel de prioridad de la recomendación:
                            </label>
                            <label><strong><?=$recomendaciones_item['nivel_prioridad']?></strong><label>
                        </div>
                    </div>
                    <form method="post" action="<?= base_url() ?>valoracion/recomendaciones_ponderacion">
                        <div class="row">
                            <div class="row">
                                <label class="col-sm-6 col-form-label">
                                    Ponderación de la recomendación:
                                </label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="ponderacion" id="ponderacion" value="<?= $recomendaciones_item['ponderacion'] ?>">
                                </div>
                                <div class="col-sm-1">
                                    %
                                </div>
                                <div class="col-sm-2">
                                    <?php
                                        $permisos_requeridos = array(
                                        'plan_accion.can_edit',
                                        'valoracion.etapa_actual',
                                        );
                                    ?>
                                    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                        <?php if ($plan_accion['status'] == 'en_proceso') { ?>
                                            <div class="text-end d-print-none">
                                                <input type="hidden" name="id_plan_accion" id="id_plan_accion" value="<?= $plan_accion['id_plan_accion'] ?>">
                                                <input type="hidden" name="cve_recomendacion" id="cve_recomendacion" value="<?= $recomendaciones_item['cve_recomendacion'] ?>">
                                                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <?php if (in_array($recomendaciones_item['cve_recomendacion'], array_column($actividades, 'cve_recomendacion'))) { ?>
                <h5 class="mt-5 mb-2 border-bottom border-success">Actividades para atender la recomendación</h5>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <?php include 'actividades.php' ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php
            $permisos_requeridos = array(
            'plan_accion.can_edit',
            'valoracion.etapa_actual',
            );
        ?>
        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
            <?php if ($plan_accion['status'] == 'en_proceso') { ?>
                <div class="card-footer">
                    <form method="post" action="<?= base_url() ?>valoracion/actividades_nuevo">
                        <input type="hidden" name="cve_recomendacion" id="cve_recomendacion" value="<?= $recomendaciones_item['cve_recomendacion'] ?>">
                        <input type="hidden" name="id_plan_accion" id="id_plan_accion" value="<?= $plan_accion['id_plan_accion'] ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Nueva actividad</button>
                    </form>
                </div>
            <?php } ?>
        <?php } ?>

    </div>
<?php } ?>
