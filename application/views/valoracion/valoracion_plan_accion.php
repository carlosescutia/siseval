<div class="card mt-0 mb-3 tabla-datos d-print-none">
    <div class="card-header text-white bg-primary">Valoraciones</div>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="col-sm-12">
                <div class="row small">
                    <div class="col-sm-3 text-start">
                        <strong>Dependen.</strong>
                    </div>
                    <div class="col-sm-5 text-start">
                        <strong>Observaciones</strong>
                    </div>
                    <div class="col-sm-3 text-start">
                        <strong>Status</strong>
                    </div>
                </div>
            </div>
            <ul class="list-unstyled">
                <div class="row">
                    <?php foreach ($valoraciones_plan_accion as $valoraciones_plan_accion_item) { ?>
                        <div class="col-sm-3">
                            <li><a href="<?=base_url()?>valoracion/valoracion_plan_accion_detalle/<?=$valoraciones_plan_accion_item['id_valoracion_plan_accion']?>">
                                <?= $valoraciones_plan_accion_item['nom_dependencia'] ?>
                            </a></li>
                        </div>
                        <div class="col-sm-5">
                            <li>
                                <?php if ($valoraciones_plan_accion_item['observaciones']) { ?>
                                    <?= substr($valoraciones_plan_accion_item['observaciones'], 0, 15) ?>...
                                <?php } else { ?>
                                        <i class="bi bi-check-circle boton-ok" ></i>
                                <?php } ?>
                            </li>
                        </div>
                        <div class="col-sm-3 small">
                            <li>
                                <?= $valoraciones_plan_accion_item['status'] ?>
                            </li>
                        </div>
                        <div class="col-sm-1">
                            <li>
                                <?php
                                    $permisos_requeridos = array(
                                    'plan_accion_valoracion.can_edit',
                                    'valoracion.etapa_activa',
                                    'anio_activo',
                                    );
                                ?>
                                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                    <?php if ($plan_accion['status'] == 'por_evaluar') { ?>
                                        <?php if ($cve_dependencia == $valoraciones_plan_accion_item['cve_dependencia']) { 
                                            $item_eliminar = 'Valoracion '.$valoraciones_plan_accion_item['nom_dependencia']; 
                                            $url = base_url() . "valoracion/valoracion_plan_accion_eliminar/". $valoraciones_plan_accion_item['id_valoracion_plan_accion']; ?>
                                            <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

                            </li>
                        </div>
                    <?php } ?>
                </div>
            </ul>
        </div>
    </div>
    <?php
        $permisos_requeridos = array(
        'plan_accion_valoracion.can_edit',
        'valoracion.etapa_activa',
        'anio_activo',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario) and ($num_valoraciones_plan_accion_dependencia == 0)) { ?>
        <?php if ( ($plan_accion['status'] == 'por_evaluar') ) { ?>
            <div class="card-footer text-end">
                <form method="post" action="<?= base_url() ?>valoracion/valoracion_plan_accion_nuevo">
                    <input type="hidden" name="id_plan_accion" id="id_plan_accion" value="<?=$plan_accion['id_plan_accion']?>">
                    <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>
