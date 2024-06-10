<div class="card border-0 border-start mt-0 mb-3 text-center">
    <div class="card-body">
        <h3 class="mb-3">Próximos eventos</h3>
        <table class="table table-striped text-start">
            <thead>
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Evento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($eventos as $eventos_item) {
                        $dia = date("d", strtotime($eventos_item['fecha_evento']));
                        $mes = date("m", strtotime($eventos_item['fecha_evento']));
                        $anio = date("Y", strtotime($eventos_item['fecha_evento'])); ?>
                        <tr>
                            <td><?=$dia?> <?=get_nom_mes($mes)?> <?=$anio?></td>
                            <td><?= $eventos_item['desc_evento'] ?></td>
                        </tr>
                <?php } ?>
        </table>
    </div>
</div>
