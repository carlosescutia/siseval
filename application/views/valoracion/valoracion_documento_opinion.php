<div class="card mt-0 mb-3 tabla-datos">
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
                    <?php foreach ($valoraciones_documento_opinion as $valoraciones_documento_opinion_item) { ?>
                        <div class="col-sm-3">
                            <li><a href="<?=base_url()?>valoracion/valoracion_documento_opinion_detalle/<?=$valoraciones_documento_opinion_item['cve_valoracion_documento_opinion']?>">
                                <?= $valoraciones_documento_opinion_item['nom_dependencia'] ?>
                            </a></li>
                        </div>
                        <div class="col-sm-5">
                            <li>
                                <?php if ($valoraciones_documento_opinion_item['observaciones']) { ?>
                                    <?= substr($valoraciones_documento_opinion_item['observaciones'], 0, 15) ?>...
                                <?php } else { ?>
                                        <i class="bi bi-check-circle boton-ok" ></i>
                                <?php } ?>
                            </li>
                        </div>
                        <div class="col-sm-3 small">
                            <li>
                                <?= $valoraciones_documento_opinion_item['status'] ?>
                            </li>
                        </div>
                        <div class="col-sm-1">
                            <li>
                                <?php
                                    $permisos_requeridos = array(
                                    'documento_opinion_valoracion.can_edit',
                                    'valoracion.etapa_actual',
                                    );
                                ?>
                                <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                    <?php if ($documento_opinion['status'] == 'por_evaluar') { ?>
                                        <?php if ($cve_dependencia == $valoraciones_documento_opinion_item['cve_dependencia']) { 
                                            $item_eliminar = 'Valoracion '.$valoraciones_documento_opinion_item['nom_dependencia']; 
                                            $url = base_url() . "valoracion/valoracion_documento_opinion_eliminar/". $valoraciones_documento_opinion_item['cve_valoracion_documento_opinion']; ?>
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
        'documento_opinion_valoracion.can_edit',
        'valoracion.etapa_actual',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <?php if ( ($documento_opinion['status'] == 'por_evaluar') and ($num_valoraciones_documento_opinion_dependencia == 0) ) { ?>
            <div class="card-footer text-end">
                <form method="post" action="<?= base_url() ?>valoracion/valoracion_documento_opinion_nuevo">
                    <input type="hidden" name="cve_documento_opinion" id="cve_documento_opinion" value="<?=$documento_opinion['cve_documento_opinion']?>">
                    <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>
