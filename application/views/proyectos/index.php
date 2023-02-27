<main role="main" class="ml-sm-auto px-4">
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12">
            <form method="post" action="<?= base_url() ?>proyectos">
                <div class="row">
                    <div class="col-sm-3">
                        <h2>Procesos y proyectos</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 align-self-center">
                        <div class="row">
                            <div class="col-2">
                                <select class="form-select form-select-sm" name="cve_dependencia_filtro">
                                    <?php if ($cve_rol == 'sup' or $cve_rol == 'adm') { ?>
                                        <option value="%" <?= ($cve_dependencia_filtro == '') ? 'selected' : '' ?> >Todas las dependencias</option>
                                    <?php } ?>
                                    <?php foreach ($dependencias_filtro as $dependencias_filtro_item) { ?>
                                    <option value="<?= $dependencias_filtro_item['cve_dependencia']?>" <?= ($cve_dependencia_filtro == $dependencias_filtro_item['cve_dependencia']) ? 'selected' : '' ?> ><?=$dependencias_filtro_item['nom_dependencia']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-select form-select-sm" name="anexo_social">
                                    <option value="0" <?= ($anexo_social == '0') ? 'selected' : '' ?> >Todos los proyectos</option>
                                    <option value="1" <?= ($anexo_social == '1') ? 'selected' : '' ?>>Solamente proyectos del anexo social</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-select form-select-sm" name="evaluaciones_propuestas">
                                    <option value="0" <?= ($evaluaciones_propuestas == '0') ? 'selected' : '' ?> >Con y sin evaluaciones propuestas</option>
                                    <option value="1" <?= ($evaluaciones_propuestas == '1') ? 'selected' : '' ?> >Solamente proyectos con evaluaciones propuestas</option>
                                    <option value="2" <?= ($evaluaciones_propuestas == '2') ? 'selected' : '' ?> >Solamente proyectos sin evaluaciones propuestas</option>
                                </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-success btn-sm">Filtrar</button>
                            </div>
            </form>
                            <?php if (in_array('99', $accesos_sistema_rol)) { ?>
                                <?php if ( $cve_rol == 'usr' ) { ?>
                                    <div class="col-sm-3 text-end">
                                        <form method="post" action="<?= base_url() ?>proyectos/nuevo">
                                            <button type="submit" class="btn btn-primary">Nuevo</button>
                                        </form>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>


    <div class="row">
        <?php foreach ($dependencias as $dependencias_item) { ?>
        <h3 class="header-dependencia"><?= $dependencias_item['nom_dependencia'] ?><span class="h6"><?= ($dependencias_item['carga_evaluaciones']) ? '' : ' - No solicita evaluaciones para el ejercicio fiscal' ?></span></h3>
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
                            <div class="col-sm-2 text-center">
                                <p>Status</p>
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
                                        <p>
                                        <a href="<?=base_url()?>proyectos/detalle/<?=$proyectos_item['cve_proyecto']?>"><?= $proyectos_item['nom_proyecto'] ?></a>
                                        <?php if (in_array('99', $accesos_sistema_rol)) {
                                            if ($cve_dependencia == $proyectos_item['cve_dependencia'] and ($proyectos_item['cve_programa'] == 'PRO'.$cve_dependencia)) { 
                                                $item_eliminar = 'Proyecto: '.$proyectos_item['cve_proyecto']. ' ' .$proyectos_item['nom_proyecto'];
                                                $url = base_url() . "proyectos/eliminar/". $proyectos_item['id_proyecto']; ?>
                                                <a class="ps-3" href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i></a>
                                            <?php } 
                                        } ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <p><?= $proyectos_item['periodo'] ?></p>
                                    </div>
                                    <div class="col-sm-1 text-end">
                                        <p><?= number_format($proyectos_item['presupuesto_aprobado'], 0) ?></p>
                                    </div>
                                    <div class="col-sm-2">
                                        <?php
                                        if ($proyectos_item['status_actual'] == '0') {
                                            $fondo_actual = 'bg-secondary';
                                        } else{
                                            $fondo_actual = 'bg-primary';
                                        }
                                        if ($proyectos_item['propuestas_calificadas'] == '0') {
                                            $fondo_calificadas = 'bg-secondary';
                                        } else{
                                            $fondo_calificadas = 'bg-success';
                                        }
                                        if ($proyectos_item['status_previo'] == '0') {
                                            $fondo_previo = 'bg-secondary';
                                        } else{
                                            $fondo_previo = 'bg-primary';
                                        } ?>
                                        <p><span class="badge rounded-pill <?=$fondo_actual?>"><?= $proyectos_item['status_actual'] ?></span> evaluaciones propuestas<br>
                                        <span class="badge rounded-pill <?=$fondo_calificadas?>"><?= $proyectos_item['propuestas_calificadas'] ?></span> propuestas calificadas<br>
                                        <span class="badge rounded-pill <?=$fondo_previo?>"><?= $proyectos_item['status_previo'] ?></span> evaluaciones previas</p>
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
