<div class="card mt-0 mb-3 text-center">
    <div class="card-body">
        <div>
            <?php foreach ($parametros_sistema as $parametros_sistema_item) {
                switch($parametros_sistema_item['nom_parametro_sistema']) {
                    case 'anio_propuestas':
                        $anio_propuestas = $parametros_sistema_item['valor_parametro_sistema'];
                        break;
                    case 'fecha_ini_evaluaciones':
                        $fecha_ini_evaluaciones = $parametros_sistema_item['valor_parametro_sistema'];
                        break;
                    case 'fecha_fin_evaluaciones':
                        $fecha_fin_evaluaciones = $parametros_sistema_item['valor_parametro_sistema'];
                        break;
                    case 'fecha_ini_observaciones':
                        $fecha_ini_observaciones = $parametros_sistema_item['valor_parametro_sistema'];
                        break;
                    case 'fecha_fin_observaciones':
                        $fecha_fin_observaciones = $parametros_sistema_item['valor_parametro_sistema'];
                        break;
                }
            } ?>
        </div>
        <div class="col-sm-12">
            <div class="row mb-3">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                    <img src="<?=base_url();?>img/idea.png" class="img-fluid">
                </div>
                <div class="col-sm-4">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="fw-bold small">Fecha de inicio para captura de evaluaciones</p>
                        <p><?= $fecha_ini_evaluaciones ?></p>
                    </div>
                    <div class="col-sm-4">
                        <p class="fw-bold small">Fecha limite para captura de evaluaciones</p>
                        <p><?= $fecha_fin_evaluaciones ?></p>
                    </div>
                    <div class="col-sm-4">
                        <p class="fw-bold small">Falta</p>
                        <br/>
                        <?php
                            $fech1 = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
                            $fech2 = DateTime::createFromFormat('d/m/Y', $fecha_fin_evaluaciones);
                            $dif_fechas = $fech2->diff($fech1);
                        ?>
                        <p><?= ($dif_fechas->y > 0) ? $dif_fechas->y . ' años' : '' ?>
                        <?= ($dif_fechas->m > 0) ? $dif_fechas->m . ' meses': '' ?>
                        <?= ($dif_fechas->d > 0) ? $dif_fechas->d . ' días' : '' ?></p>
                    </div>
                </div>
            </div>

            <hr />

            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <p class="fw-bold small">Fecha de inicio para captura de observaciones</p>
                        <p><?= $fecha_ini_observaciones ?></p>
                    </div>
                    <div class="col-sm-4">
                        <p class="fw-bold small">Fecha limite para captura de observaciones</p>
                        <p><?= $fecha_fin_observaciones ?></p>
                    </div>
                    <div class="col-sm-4">
                        <p class="fw-bold small">Falta</p>
                        <br/>
                        <br/>
                        <?php
                            $fech1 = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
                            $fech2 = DateTime::createFromFormat('d/m/Y', $fecha_fin_observaciones);
                            $dif_fechas = $fech2->diff($fech1);
                        ?>
                        <p><?= ($dif_fechas->y > 0) ? $dif_fechas->y . ' años' : '' ?>
                        <?= ($dif_fechas->m > 0) ? $dif_fechas->m . ' meses': '' ?>
                        <?= ($dif_fechas->d > 0) ? $dif_fechas->d . ' días' : '' ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
