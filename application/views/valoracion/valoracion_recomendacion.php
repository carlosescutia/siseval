<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Dependencia</th>
            <th scope="col">Pertinencia</th>
            <th scope="col">Prioridad</th>
            <th scope="col">Fundamentada</th>
            <th scope="col">Observaciones</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $num_valoraciones_recomendacion_dependencia = 0;
        ?>
        <?php foreach ($valoraciones_recomendacion as $valoraciones_recomendacion_item) { ?>
            <?php if ($valoraciones_recomendacion_item['cve_recomendacion'] == $recomendaciones_item['cve_recomendacion']) { ?>
                <tr>
                    <td><a href="<?=base_url()?>valoracion/valoracion_recomendacion_detalle/<?=$valoraciones_recomendacion_item['cve_valoracion_recomendacion']?>"><?= $valoraciones_recomendacion_item['nom_dependencia'] ?></a></td>
                    <td><?= $valoraciones_recomendacion_item['pertinencia'] ? 'Si' : 'No ' ?></td>
                    <td><?= $valoraciones_recomendacion_item['prioridad'] ? 'Si' : 'No ' ?></td>
                    <td><?= $valoraciones_recomendacion_item['fundamentada'] ? 'Si' : 'No ' ?></td>
                    <td><?= $valoraciones_recomendacion_item['observaciones'] ? substr($valoraciones_recomendacion_item['observaciones'], 0, 25) . '...' : '<i class="bi bi-check-circle boton-ok" >' ?></td>
                    <td><?= $valoraciones_recomendacion_item['status'] ?></td>
                    <td>
                        <?php
                            $permisos_requeridos = array(
                            'documento_opinion_valoracion.can_edit',
                            'valoracion.etapa_activa',
                            'anio_activo',
                            );
                        ?>
                        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                            <?php if ($documento_opinion['status'] == 'por_evaluar') { ?>
                                <?php if ($cve_dependencia == $valoraciones_recomendacion_item['cve_dependencia']) { 
                                    $num_valoraciones_recomendacion_dependencia += 1;
                                    $item_eliminar = 'Valoracion '.$valoraciones_recomendacion_item['nom_dependencia']; 
                                    $url = base_url() . "valoracion/valoracion_recomendacion_eliminar/". $valoraciones_recomendacion_item['cve_valoracion_recomendacion']; ?>
                                    <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </tbody>
</table>

<div class="col-sm-12">
    <?php
        $permisos_requeridos = array(
        'documento_opinion_valoracion.can_edit',
        'valoracion.etapa_activa',
        'anio_activo',
        );
    ?>
    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
        <?php if ( ($documento_opinion['status'] == 'por_evaluar') and ($num_valoraciones_recomendacion_dependencia == 0) ) { ?>
            <div class="text-end">
                <form method="post" action="<?= base_url() ?>valoracion/valoracion_recomendacion_nuevo">
                    <input type="hidden" name="cve_recomendacion" id="cve_recomendacion" value="<?=$recomendaciones_item['cve_recomendacion']?>">
                    <input type="hidden" name="cve_dependencia" id="cve_dependencia" value="<?=$cve_dependencia?>">
                    <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                </form>
            </div>
        <?php } ?>
    <?php } ?>
</div>
