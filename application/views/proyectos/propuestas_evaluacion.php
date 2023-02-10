<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-header text-white bg-primary">Propuestas de evaluación 2023</div>
    <div class="card-body">
        <?php foreach ($propuestas_evaluacion as $propuestas_evaluacion_item) { ?>
            <div class="col-sm-12 ps-3 alternate-color">
                <div class="row">
                    <p>
                        <a href="<?=base_url()?>propuestas_evaluacion/detalle/<?= $propuestas_evaluacion_item['id_propuesta_evaluacion'] ?>"><?= $propuestas_evaluacion_item['nom_dependencia'] ?> - <?= $propuestas_evaluacion_item['nom_tipo_evaluacion'] ?></a>
                        <?php if (in_array('99', $accesos_sistema_rol)) {
                            if ($cve_dependencia == $propuestas_evaluacion_item['cve_dependencia']) { 
                                $item_eliminar = 'Propuesta de evaluación '.$propuestas_evaluacion_item['nom_dependencia']. ' ' . $propuestas_evaluacion_item['nom_tipo_evaluacion']; 
                                $url = base_url() . "propuestas_evaluacion/eliminar/". $propuestas_evaluacion_item['id_propuesta_evaluacion']; ?>
                                <a class="ps-3" href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                            <?php } 
                        } ?>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php if (in_array('99', $accesos_sistema_rol)) { ?>
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
