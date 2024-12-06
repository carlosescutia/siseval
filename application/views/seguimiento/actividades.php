<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Actividad</th>
            <th scope="col" class="text-center">Unidad de medida</th>
            <th scope="col" class="text-center">Avance</th>
            <th scope="col" class="text-center">Resultados esperados</th>
            <th scope="col" class="text-center">Cumplimiento</th>
            <th scope="col">Comentarios</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($actividades as $actividades_item) { ?>
        <?php if ($actividades_item['cve_recomendacion'] == $recomendaciones_item['cve_recomendacion']) { ?>
            <?php
                $cumplimiento = round($actividades_item['registro_avance'] / $actividades_item['resultados_esperados'] * 100);
                switch(true) {
                    case $cumplimiento >= 0 and $cumplimiento <= 69:
                        $fondo_cumplimiento = 'text-bg-danger';
                        break;
                    case $cumplimiento >= 70 and $cumplimiento <= 99:
                        $fondo_cumplimiento = 'text-bg-warning';
                        break;
                    case $cumplimiento = 100:
                        $fondo_cumplimiento = 'text-bg-success';
                        break;
                    default:
                        $fondo_cumplimiento = 'text-bg-light';
                        break;
                }
            ?>
            <tr>
                <td><a href="<?=base_url()?>seguimiento/actividades_detalle/<?=$actividades_item['id_actividad']?>"><?= $actividades_item['desc_actividad'] ?></a></td>
                <td class="text-center"><?= $actividades_item['unidad_medida'] ?></td>
                <td class="text-center"><?= $actividades_item['registro_avance'] ?></td>
                <td class="text-center"><?= $actividades_item['resultados_esperados'] ?></td>
                <td class="text-center"><span class="badge rounded-pill <?=$fondo_cumplimiento?>"><?= $cumplimiento ?> %</span></td>
                <td><?= $actividades_item['comentarios_avance'] ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
