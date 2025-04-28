<main role="main" class="ml-sm-auto px-4">
    <table id="tbl_publico" class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Clave P/Q</th>
                <th scope="col" width="30%">Evaluación</th>
                <th scope="col">Año</th>
                <th scope="col">Tipo</th>
                <th scope="col">Responsable</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-center" width="5%" data-orderable="false">TdR</th>
                <th scope="col" class="text-center" width="5%" data-orderable="false">Informe</th>
                <th scope="col" class="text-center" width="5%" data-orderable="false">Ficha Conac</th>
                <th scope="col" class="text-center" width="5%" data-orderable="false">Doc. Op.</th>
                <th scope="col" class="text-center" width="5%" data-orderable="false">Plan acc.</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $tipo_archivo = 'pdf';
                $dir_docs = './doc/';
                $icono = "bi-filetype-pdf";
            ?>
            <?php foreach ($proyectos as $proyectos_item) { ?>
            <tr>
                <td><?= $proyectos_item['cve_proyecto'] ?></td>
                <td><?= $proyectos_item['nom_proyecto'] ?></td>
                <td class="text-center"><?= $proyectos_item['periodo'] ?></td>
                <td><?= $proyectos_item['nom_tipo_evaluacion'] ?></td>
                <td><?= $proyectos_item['nom_dependencia'] ?></td>
                <td><?= $proyectos_item['status'] ?></td>
                <?php if ( $proyectos_item['status'] !== 'cancelado' ) { ?>
                    <?php
                        // Términos de referencia
                        $prefijo = 'tr' ;
                        $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                        $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                        $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                    ?>
                    <td class="text-center">
                    <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                        <a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a>
                    <?php } ?>
                    </td>

                    <?php
                        // Informe final
                        $prefijo = 'if' ;
                        $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                        $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                        $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                    ?>
                    <td class="text-center">
                    <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                        <a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a>
                    <?php } ?>
                    </td>

                    <?php
                        // Ficha Conac
                        $prefijo = 'fc' ;
                        $nombre_archivo = $prefijo . '_' . $proyectos_item['id_propuesta_evaluacion'] . '.' . $tipo_archivo;
                        $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                        $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                    ?>
                    <td class="text-center">
                    <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                        <a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a>
                    <?php } ?>
                    </td>

                    <?php
                        // Documento de opinión
                        $prefijo = 'doc_op' ;
                        $nombre_archivo = $prefijo . '_' . $proyectos_item['cve_documento_opinion'] . '.' . $tipo_archivo;
                        $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                        $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                    ?>
                    <td class="text-center">
                    <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                        <a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a>
                    <?php } ?>
                    </td>

                    <?php
                        // Plan de acción
                        $prefijo = 'plan_ac' ;
                        $nombre_archivo = $prefijo . '_' . $proyectos_item['id_plan_accion'] . '.' . $tipo_archivo;
                        $nombre_archivo_fs = $dir_docs . $nombre_archivo;
                        $nombre_archivo_url = base_url() . $dir_docs . $nombre_archivo;
                    ?>
                    <td class="text-center">
                    <?php if ( file_exists($nombre_archivo_fs) )  { ?>
                        <a href="<?= $nombre_archivo_url ?>" target="_blank"><i class="bi <?= $icono ?> documento-g"></i></a>
                    <?php } ?>
                    </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</main>

<script type="text/javascript">
    $(document).ready( function () {
        $('#tbl_publico').DataTable( {
            language: {
                url: '//cdn.datatables.net/plug-ins/2.2.2/i18n/es-MX.json',
            },
        });
    });
</script>

