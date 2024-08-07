<main role="main" class="ml-sm-auto px-4">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12">
            <form method="post" action="<?= base_url() ?>valoracion">
                <div class="row">
                    <div class="col-sm-3">
                        <h2>Valoración</h2>
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
                            <div class="col-sm-1 fw-bold">
                                <p>Año</p>
                            </div>
                            <div class="col-sm-1 fw-bold">
                                <p>Tipo</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Propuesta por</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Documento de opinión</p>
                            </div>
                            <div class="col-sm-1">
                                <p>Plan de acción</p>
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
                                        <?php if ($err_proyectos) { ?>
                                            <?php if ($err_proyectos['cve_proyecto'] == $proyectos_item['cve_proyecto']) { ?>
                                                <div class="alert alert-warning alert-dismissible fade show texto-menor" role="alert">
                                                    <?= $err_proyectos['error'] ?>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
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
                                    <div class="col-sm-1">
                                        <?php if ($proyectos_item['status']) { ?>
                                            <p><a href="<?=base_url()?>valoracion/documento_opinion_detalle/<?=$proyectos_item['cve_documento_opinion']?>"><?= $proyectos_item['desc_status_documento_opinion'] ?></a></p>
                                        <?php } else { ?>
                                            <p><a href="<?=base_url()?>valoracion/documento_opinion_nuevo/<?=$proyectos_item['id_propuesta_evaluacion']?>">Generar</a></p>
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
