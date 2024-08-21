<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Propuestas de evaluación <?= $anio_propuestas ?></div>
    <div class="card-body">
        <?php foreach ($propuestas_evaluacion as $propuestas_evaluacion_item) { ?>
            <div class="col-sm-12 ps-3 alternate-color">
                <?php if ($err_propuestas_evaluacion) { ?>
				<div class="alert alert-warning alert-dismissible fade show texto-menor" role="alert">
					<?php echo $err_propuestas_evaluacion ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
                <?php } ?>
                <div class="row">
                    <div class="col-sm-8">
                        <p>
                            <a href="<?=base_url()?>propuestas_evaluacion/detalle/<?= $propuestas_evaluacion_item['id_propuesta_evaluacion'] ?>"><?= $propuestas_evaluacion_item['nom_dependencia'] ?> - <?= $propuestas_evaluacion_item['nom_tipo_evaluacion'] ?></a>

                            <?php
                                $permisos_requeridos = array(
                                'propuesta_evaluacion.can_edit',
                                'planificacion.etapa_actual',
                                );
                            ?>
                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                <?php if ($cve_dependencia == $propuestas_evaluacion_item['cve_dependencia']) { 
                                    $item_eliminar = 'Propuesta de evaluación '.$propuestas_evaluacion_item['nom_dependencia']. ' ' . $propuestas_evaluacion_item['nom_tipo_evaluacion']; 
                                    $url = base_url() . "propuestas_evaluacion/eliminar/". $propuestas_evaluacion_item['id_propuesta_evaluacion']; ?>
                                    <a class="ps-3" href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                <?php } ?>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <?php 
                            $num_calificaciones = $propuestas_evaluacion_item['num_calificaciones'];
                            switch (true) {
                            case $num_calificaciones == 0:
                                $fondo_actual = 'bg-danger'; 
                                break;
                            case $num_calificaciones > 0 and $num_calificaciones < $num_supervisores:
                                $fondo_actual = 'bg-warning'; 
                                break;
                            case $num_calificaciones == $num_supervisores:
                                $fondo_actual = 'bg-success'; 
                                break;
                            default:
                                $fondo_actual = 'bg-dark'; 
                        } ?>
                        <p><span class="badge rounded-pill <?=$fondo_actual?>"><?= $propuestas_evaluacion_item['num_calificaciones'] ?></span> calificaciones</p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
        $permisos_requeridos = array(
        'propuesta_evaluacion.can_edit',
        'planificacion.etapa_actual',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <?php if ( $cve_rol == 'usr' ) { ?>
            <?php if ( $num_propuestas_evaluacion_proyecto_dependencia['num'] == 0 ) { ?>
                <div class="card-footer text-end">
                    <form method="post" action="<?= base_url() ?>propuestas_evaluacion/nuevo/<?=$proyecto['cve_proyecto']?>">
                        <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                    </form>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="card-footer text-end">
                <form method="post" action="<?= base_url() ?>propuestas_evaluacion/nuevo/<?=$proyecto['cve_proyecto']?>">
                    <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>
