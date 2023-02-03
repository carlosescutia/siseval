<main role="main" class="ml-sm-auto px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>Procesos y proyectos</h2>
    </div>
    <div class="row">
        <?php foreach ($dependencias as $dependencias_item) { ?>
            <h3 class="header-dependencia"><?= $dependencias_item['nom_dependencia'] ?></h3>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row fw-bold">
                            <div class="col-sm-1">
                                <p>Clave PP</p>
                            </div>
                            <div class="col-sm-3">
                                <p>Nombre PP</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Clave P/Q</p>
                            </div>
                            <div class="col-sm-3">
                                <p>Nombre P/Q</p>
                            </div>
                            <div class="col-sm-1 text-center">
                                <p>Periodo</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Presupuesto</p>
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
                                        <p><?= $proyectos_item['cve_programa'] ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><?= $proyectos_item['nom_programa'] ?></p>
                                    </div>
                                    <div class="col-sm-1">
                                        <p><?= $proyectos_item['cve_proyecto'] ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><a href="<?=base_url()?>proyectos/detalle/<?=$proyectos_item['cve_proyecto']?>"><?= $proyectos_item['nom_proyecto'] ?></a></p>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <p><?= $proyectos_item['periodo'] ?></p>
                                    </div>
                                    <div class="col-sm-1 text-end">
                                        <p><?= number_format($proyectos_item['presupuesto_aprobado'], 2) ?></p>
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
