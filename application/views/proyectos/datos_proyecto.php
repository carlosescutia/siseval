<div class="card mt-0 mb-3 tabla-datos">
    <div class="card-body">
        <table class="table table-striped tabla-datos">
            <tbody>
                <tr>
                    <td>Clave programa presupuestario</td>
                    <td><?= $programa['cve_programa'] ?></td>
                </tr>
                <tr>
                    <td>Nombre programa presupuestario</td>
                    <td><?= $programa['nom_programa'] ?></td>
                </tr>
                <tr>
                    <td>Dependencia responsable</td>
                    <td><?= $proyecto['nom_dependencia'] ?></td>
                </tr>
                <tr>
                    <td>Presupuesto aprobado</td>
                    <td>$ <?= number_format($proyecto['presupuesto_aprobado'], 0) ?></td>
                </tr>
                <tr>
                    <td>Tipo de gasto</td>
                    <td><?= $proyecto['cve_tipo_gasto'] ?></td>
                </tr>
                <tr>
                    <td>Alineación a los ODS</td>
                    <td>
                        <div>
                            <?php 
                            $curr_objetivo = 0;
                            foreach ($metas as $metas_item) {
                                if ($metas_item['cve_objetivo_desarrollo'] !== $curr_objetivo) { ?>
                                    <h6><strong><?= $metas_item['cve_objetivo_desarrollo'] ?> <?= $metas_item['nom_objetivo_desarrollo'] ?></strong></h6>
                                    <?php $curr_objetivo = $metas_item['cve_objetivo_desarrollo'] ;
                                } ?>
                                <div class="ms-3 texto-menor">
                                    <?= $metas_item['cve_meta_ods'] ?> <?= $metas_item['nom_meta_ods'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                    <!--<td> <?= print_r($metas) ?> </td> -->
                </tr>
            </tbody>
        </table>
    </div>
</div>
