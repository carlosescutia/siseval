<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Calificaciones de la propuesta</div>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-12 ps-3">
                        <div class="row small">
                            <div class="col-sm-6">
                                <strong>Dependencia</strong>
                            </div>
                            <div class="col-sm-6 text-center">
                                <strong>Puntaje</strong>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($calificaciones_propuesta as $calificaciones_propuesta_item) { ?>
                        <div class="col-sm-12 ps-3 alternate-color">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><a href="<?=base_url()?>calificaciones_propuesta/detalle/<?= $calificaciones_propuesta_item['id_calificacion_propuesta'] ?>"><?= $calificaciones_propuesta_item['nom_dependencia'] ?></a>
                                    <?php
                                        $permisos_requeridos = array(
                                        'calificacion_propuesta.can_edit',
                                        'planificacion.etapa_actual',
                                        );
                                    ?>
                                    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                        <?php if ($cve_dependencia == $calificaciones_propuesta_item['cve_dependencia']) { 
                                            $item_eliminar = 'Calificación de la propuesta de '. $calificaciones_propuesta_item['nom_dependencia'] ;
                                            $url = base_url() . "calificaciones_propuesta/eliminar/". $calificaciones_propuesta_item['id_calificacion_propuesta']; ?>
                                            <a class="ps-3" href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a></p>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <p><?= $calificaciones_propuesta_item['puntaje'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-8 d-flex text-center">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card h-100 ms-3">
                                <div class="card-header">Puntaje total</div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <?php if ($calificacion_final_propuesta_evaluacion) { ?>
                                    <h3 class="display-3"><?= $calificacion_final_propuesta_evaluacion['puntaje'] ?></h3>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card h-100 ms-3">
                                <div class="card-header">Probabilidad de inclusión en la Agenda Anual de Evaluación</div>
                                <div class="card-body d-flex align-items-center justify-content-center">
                                    <?php if ($calificacion_final_propuesta_evaluacion) { ?>
                                    <h1><?= $calificacion_final_propuesta_evaluacion['probabilidad'] ?></h1>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $permisos_requeridos = array(
        'calificacion_propuesta.can_edit',
        'planificacion.etapa_actual',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <?php if ( $num_calificaciones_propuesta_dependencia['num'] == 0 ) { ?>
            <div class="card-footer text-start">
                <form method="post" action="<?= base_url() ?>calificaciones_propuesta/nuevo/<?=$id_propuesta_evaluacion?>">
                    <button type="submit" class="btn btn-primary btn-sm">Calificar</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>
