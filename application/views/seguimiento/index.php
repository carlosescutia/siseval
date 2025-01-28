<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<main role="main" class="ml-sm-auto px-4">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12">
            <form method="post" action="<?= base_url() ?>seguimiento">
                <div class="row">
                    <div class="col-sm-3">
                        <h2>Seguimiento</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 align-self-center">
                        <div class="row">
                            <div class="col-2">
                                <select class="form-select form-select-sm" name="cve_dependencia_filtro">
                                    <?php if ($cve_rol != 'usr') { ?>
                                        <option value="%" <?= ($cve_dependencia_filtro == '') ? 'selected' : '' ?> >Todas las dependencias</option>
                                    <?php } ?>
                                    <?php foreach ($dependencias_filtro as $dependencias_filtro_item) { ?>
                                    <option value="<?= $dependencias_filtro_item['cve_dependencia']?>" <?= ($cve_dependencia_filtro == $dependencias_filtro_item['cve_dependencia']) ? 'selected' : '' ?> ><?=$dependencias_filtro_item['nom_dependencia']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-success btn-sm">Filtrar</button>
                            </div>
                            <div class="col-9 text-end">
                                <div class="row text-danger">
                                    <?php if ($error) { 
                                    echo $error;
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <?php foreach ($dependencias as $dependencias_item) { ?>
        <h3 class="header-dependencia"><?= $dependencias_item['nom_dependencia'] ?></h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row fw-bold">
                            <div class="col-sm-1">
                                <p>Clave P/Q</p>
                            </div>
                            <div class="col-sm-3">
                                <p>Nombre P/Q</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Año</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Tipo</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Propuesta por</p>
                            </div>
                            <div class="col-sm-1 text-center">
                                <p>Seguimiento</p>
                            </div>
                            <div class="col-sm-1 text-center">
                                <p>Cumplimiento</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <?php foreach ($proyectos as $proyectos_item) { 
                        if ($proyectos_item['cve_dependencia'] == $dependencias_item['cve_dependencia']) { ?>
                            <div class="col-sm-12 alternate-color">
                                <div class="row">
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['cve_proyecto'] ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p> <?= $proyectos_item['nom_proyecto'] ?> </p>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['periodo'] ?></p>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['nom_tipo_evaluacion'] ?></p>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['nom_dependencia_propuesta'] ?></p>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <p>
                                            <a href="<?=base_url()?>seguimiento/detalle/<?=$proyectos_item['id_plan_accion']?>">Detalle</a>
                                        </p>
                                    </div>
                                    <?php
                                        switch(true) {
                                            case $proyectos_item['cumplimiento'] >= 0 and $proyectos_item['cumplimiento'] <= 69:
                                                $fondo_cumplimiento = 'text-bg-danger';
                                                break;
                                            case $proyectos_item['cumplimiento'] >= 70 and $proyectos_item['cumplimiento'] <= 99:
                                                $fondo_cumplimiento = 'text-bg-warning';
                                                break;
                                            case $proyectos_item['cumplimiento'] = 100:
                                                $fondo_cumplimiento = 'text-bg-success';
                                                break;
                                            default:
                                                $fondo_cumplimiento = 'text-bg-light';
                                                break;
                                        }
                                    ?>
                                    <div class="col-sm-1 text-center">
                                        <?php if ($proyectos_item['cumplimiento']) { ?>
                                            <p><span class="badge rounded-pill <?=$fondo_cumplimiento?>"><?= $proyectos_item['cumplimiento'] ?> %</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                     } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr />

</main>

