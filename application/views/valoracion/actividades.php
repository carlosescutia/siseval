<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Actividad</th>
            <th scope="col">Inicio</th>
            <th scope="col">Fin</th>
            <th scope="col">Responsable</th>
            <th scope="col">Unidad de medida</th>
            <th scope="col">Resultados esperados</th>
            <th scope="col">Ponderación</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($actividades as $actividades_item) { ?>
        <?php if ($actividades_item['cve_recomendacion'] == $recomendaciones_item['cve_recomendacion']) { ?>
            <tr>
                <td><a href="<?=base_url()?>valoracion/actividades_detalle/<?=$actividades_item['id_actividad']?>"><?= $actividades_item['desc_actividad'] ?></a></td>
                <td><?= date('d-m-Y', strtotime($actividades_item['fech_ini'])) ?></td>
                <td><?= date('d-m-Y', strtotime($actividades_item['fech_fin'])) ?></td>
                <td><?= $actividades_item['area_responsable'] ?></td>
                <td><?= $actividades_item['unidad_medida'] ?></td>
                <td><?= $actividades_item['resultados_esperados'] ?></td>
                <td><?= $actividades_item['ponderacion'] ?></td>
                <td>
                    <?php
                        $permisos_requeridos = array(
                        'plan_accion.can_edit',
                        'valoracion.etapa_actual',
                        );
                    ?>
                    <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                        <?php if ($plan_accion['status'] == 'en_proceso') {
                            $item_eliminar = 'Actividad '.$actividades_item['desc_actividad']; 
                            $url = base_url() . "valoracion/actividades_eliminar/". $actividades_item['id_actividad']; ?>
                            <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                        <?php } ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
