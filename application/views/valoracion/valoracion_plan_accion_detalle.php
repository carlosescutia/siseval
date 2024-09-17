<div class="col-sm-8 offset-sm-2">
    <div class="card mt-3 mb-3">
        <div class="card-header text-bg-primary">
            Valoración
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>valoracion/valoracion_plan_accion_guardar" id="valoracion">
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <label for="actividades_cumplimiento">
                            ¿Las recomendaciones cuentan con actividades que efectivamente permiten su cumplimiento?
                        </label>
                        <select class="form-select" name="actividades_cumplimiento" id="actividades_cumplimiento" required>
                            <option value=""></option>
                            <option value="1" <?= $valoracion_plan_accion['actividades_cumplimiento'] == '1' ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= $valoracion_plan_accion['actividades_cumplimiento'] == '0' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="plazo_adecuado" class="mb-4">
                            ¿El plazo establecido es el adecuado para atender las recomendaciones?
                        </label>
                        <select class="form-select" name="plazo_adecuado" id="plazo_adecuado" required>
                            <option value=""></option>
                            <option value="1" <?= $valoracion_plan_accion['plazo_adecuado'] == '1' ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= $valoracion_plan_accion['plazo_adecuado'] == '0' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="resultados_pertinentes">
                            ¿Los resultados esperados son pertinentes para atender la recomendación?
                        </label>
                        <select class="form-select" name="resultados_pertinentes" id="resultados_pertinentes" required>
                            <option value=""></option>
                            <option value="1" <?= $valoracion_plan_accion['resultados_pertinentes'] == '1' ? 'selected' : '' ?> >Si</option>
                            <option value="0" <?= $valoracion_plan_accion['resultados_pertinentes'] == '0' ? 'selected' : '' ?> >No</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label for="observaciones">
                            Observaciones
                        </label>
                        <textarea rows="4" class="form-control" name="observaciones" id="observaciones"><?=$valoracion_plan_accion['observaciones']?></textarea>
                    </div>
                </div>
                <input type="hidden" name="id_valoracion_plan_accion" id="id_valoracion_plan_accion" value="<?=$valoracion_plan_accion['id_valoracion_plan_accion']?>">
                <input type="hidden" name="id_plan_accion" id="id_plan_accion" value="<?=$valoracion_plan_accion['id_plan_accion']?>">
            </form>
        </div>
        <?php
            $permisos_requeridos = array(
            'plan_accion_valoracion.can_edit',
            'valoracion.etapa_actual',
            );
        ?>
        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
            <?php if ($plan_accion['status'] == 'por_evaluar') { ?>
                <?php if ($cve_dependencia == $valoracion_plan_accion['cve_dependencia']) { ?>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary btn-sm" form="valoracion">Guardar</button>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<hr />
<div class="form-group row">
    <div class="col-sm-10 d-print-none">
        <a href="<?=base_url()?>valoracion/plan_accion_detalle/<?=$valoracion_plan_accion['id_plan_accion']?>" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
