<?php $num_rec = 0; ?>

<?php foreach ($recomendaciones as $recomendaciones_item) { ?>
    <?php $num_rec += 1; ?>
    <div class="card mt-3 mb-5">
        <div class="card-header text-bg-primary">
            Recomendación <?=$num_rec?>
        </div>
        <div class="card-body">
            <div class="row">
                <form method="post" action="<?= base_url() ?>valoracion/recomendaciones_guardar" id="recomendacion<?=$num_rec?>">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label for="desc_recomendacion">
                                Recomendación
                            </label>
                            <textarea rows="4" class="form-control" name="desc_recomendacion" id="desc_recomendacion" required><?=$recomendaciones_item['desc_recomendacion']?></textarea>
                        </div>
                        <div class="col-sm-6 text-center">
                            <label>¿La recomendación cumple con los siguientes criterios?</label>
                            <div class="row mt-2">
                                <div class="col-sm-3 text-center">
                                    <label for="clara">
                                        Clara
                                        <a data-bs-toggle="collapse" href="#ayuda_clara" role="button" aria-expanded="false" aria-controls="ayuda_clara">
                                            <i class="bi bi-info-circle texto-menor"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label for="relevante">
                                        Relevante
                                        <a data-bs-toggle="collapse" href="#ayuda_relevante" role="button" aria-expanded="false" aria-controls="ayuda_relevante">
                                            <i class="bi bi-info-circle texto-menor"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label for="justificable">
                                        Justificable
                                        <a data-bs-toggle="collapse" href="#ayuda_justificable" role="button" aria-expanded="false" aria-controls="ayuda_justificable">
                                            <i class="bi bi-info-circle texto-menor"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label for="factible">
                                        Factible
                                        <a data-bs-toggle="collapse" href="#ayuda_factible" role="button" aria-expanded="false" aria-controls="ayuda_factible">
                                            <i class="bi bi-info-circle texto-menor"></i>
                                        </a>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="collapse" id="ayuda_clara">
                                    <div class="texto-ayuda">
                                        La recomendación está expresada de forma precisa.
                                    </div>
                                </div>                
                                <div class="collapse" id="ayuda_relevante">
                                    <div class="texto-ayuda">
                                        La recomendación constituye una aportación significativa para el logro del propósito y de los componentes del programa.
                                    </div>
                                </div>                
                                <div class="collapse" id="ayuda_justificable">
                                    <div class="texto-ayuda">
                                        La recomendación está sustentada en la identificación de un problema, debilidad, oportunidad o amenaza.
                                    </div>
                                </div>                
                                <div class="collapse" id="ayuda_factible">
                                    <div class="texto-ayuda">
                                        La recomendación es viable de atender.
                                    </div>
                                </div>                
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-3 text-center">
                                    <select class="form-select" name="clara" id="clara" required>
                                        <option value=""></option>
                                        <option value="s" <?= $recomendaciones_item['clara'] == 's' ? 'selected' : '' ?> >Si</option>
                                        <option value="n" <?= $recomendaciones_item['clara'] == 'n' ? 'selected' : '' ?> >No</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <select class="form-select" name="relevante" id="relevante" required>
                                        <option value=""></option>
                                        <option value="s" <?= $recomendaciones_item['relevante'] == 's' ? 'selected' : '' ?> >Si</option>
                                        <option value="n" <?= $recomendaciones_item['relevante'] == 'n' ? 'selected' : '' ?> >No</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <select class="form-select" name="justificable" id="justificable" required>
                                        <option value=""></option>
                                        <option value="s" <?= $recomendaciones_item['justificable'] == 's' ? 'selected' : '' ?> >Si</option>
                                        <option value="n" <?= $recomendaciones_item['justificable'] == 'n' ? 'selected' : '' ?> >No</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <select class="form-select" name="factible" id="factible" required>
                                        <option value=""></option>
                                        <option value="s" <?= $recomendaciones_item['factible'] == 's' ? 'selected' : '' ?> >Si</option>
                                        <option value="n" <?= $recomendaciones_item['factible'] == 'n' ? 'selected' : '' ?> >No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label for="id_tipo_actor">
                                Clasificación por tipo de actor involucrado
                                <a data-bs-toggle="collapse" href="#ayuda_id_tipo_actor" role="button" aria-expanded="false" aria-controls="ayuda_id_tipo_actor">
                                    <i class="bi bi-info-circle texto-menor"></i>
                                </a>
                            </label>
                            <div class="collapse" id="ayuda_id_tipo_actor">
                                <div class="texto-ayuda">
                                    <ul>
                                        <li>Específico: La atención de la recomendación corresponde a un área de la dependencia responsable de la intervención pública.</li>
                                        <li>Institucional: La atención de la recomendación requiere la intervención de una o varias áreas de la dependencia responsable de la intervención pública.</li>
                                        <li>Interinstitucional: La atención de la recomendación requiere la participación de más de una dependencia.</li>
                                        <li>Intergubernamental: La atención de la recomendación requiere la intervención de distintos órdenes de gobierno.</li>
                                    </ul>
                                </div>
                            </div>                
                            <select class="form-select" name="id_tipo_actor" id="id_tipo_actor" required>
                                <option value=""></option>
                                <?php foreach ($tipos_actor as $tipos_actor_item) { ?>
                                    <option 
                                        value="<?= $tipos_actor_item['id'] ?>" 
                                        <?= $recomendaciones_item['id_tipo_actor'] == $tipos_actor_item['id'] ? 'selected' : '' ?> 
                                    >
                                        <?= $tipos_actor_item['descripcion'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="prioridad">
                                Nivel de prioridad de la recomendación
                                <a data-bs-toggle="collapse" href="#ayuda_prioridad" role="button" aria-expanded="false" aria-controls="ayuda_prioridad">
                                    <i class="bi bi-info-circle texto-menor"></i>
                                </a>
                            </label>
                            <div class="collapse" id="ayuda_prioridad">
                                <div class="texto-ayuda">
                                    <ul>
                                        <li>Alto: La atención de la recomendación es indispensable para el logro del objetivo del programa.</li>
                                        <li>Medio: La atención de la recomendación contribuye parcialmente al logro del objetivo del programa.</li>
                                        <li>Bajo: La atención de la recomendación no es indispensable ni necesaria para el logro del objetivo del programa.</li>
                                    </ul>
                                </div>
                            </div>                
                            <select class="form-select" name="prioridad" id="prioridad" required>
                                <option value=""></option>
                                <option value="a" <?= $recomendaciones_item['prioridad'] == 'a' ? 'selected' : '' ?> >Alto</option>
                                <option value="m" <?= $recomendaciones_item['prioridad'] == 'm' ? 'selected' : '' ?> >Medio</option>
                                <option value="b" <?= $recomendaciones_item['prioridad'] == 'b' ? 'selected' : '' ?> >Bajo</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="responsable">Dependencia responsable de atención</label>
                            <input type="text" class="form-control" name="responsable" id="responsable" value="<?=$recomendaciones_item['responsable']?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <label for="postura">
                                Postura sobre la recomendación
                                <a data-bs-toggle="collapse" href="#ayuda_postura" role="button" aria-expanded="false" aria-controls="ayuda_postura">
                                    <i class="bi bi-info-circle texto-menor"></i>
                                </a>
                            </label>
                            <div class="collapse" id="ayuda_postura">
                                <div class="texto-ayuda">
                                    Emita su postura en la cual acepta o rechaza la recomendación.
                                </div>
                            </div>                
                            <select class="form-select" name="postura" id="postura" required>
                                <option value=""></option>
                                <option value="a" <?= $recomendaciones_item['postura'] == 'a' ? 'selected' : '' ?> >Aceptada</option>
                                <option value="r" <?= $recomendaciones_item['postura'] == 'r' ? 'selected' : '' ?> >Rechazada</option>
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <label for="justificacion">
                                Justificación de la postura
                                <a data-bs-toggle="collapse" href="#ayuda_justificacion" role="button" aria-expanded="false" aria-controls="ayuda_justificacion">
                                    <i class="bi bi-info-circle texto-menor"></i>
                                </a>
                            </label>
                            <div class="collapse" id="ayuda_justificacion">
                                <div class="texto-ayuda">
                                    Señale las razones de su postura. En caso de contar con fuentes de información que sustenten la justificación, favor de señalarlas.
                                </div>
                            </div>                
                            <textarea rows="4" class="form-control" name="justificacion" id="justificacion" required><?=$recomendaciones_item['justificacion']?></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="cve_recomendacion" id="cve_recomendacion" value="<?=$recomendaciones_item['cve_recomendacion']?>">
                    <input type="hidden" name="cve_documento_opinion" id="cve_documento_opinion" value="<?=$recomendaciones_item['cve_documento_opinion']?>">
                </form>
            </div>

                <h5 class="mt-3 mb-2 border-bottom border-success">Valoraciones</h5>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <?php include 'valoracion_recomendacion.php' ?>
                    </div>
                </div>
        </div>
        <?php
            $permisos_requeridos = array(
            'documento_opinion.can_edit',
            'valoracion.etapa_actual',
            );
        ?>
        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
            <?php if ($documento_opinion['status'] == 'en_proceso') {
                $item_eliminar = $recomendaciones_item['desc_recomendacion'] ; 
                $url = base_url() . "valoracion/recomendaciones_eliminar/". $recomendaciones_item['cve_recomendacion']; ?>
                <div class="card-footer text-end d-print-none">
                    <a class="btn btn-danger btn-sm" href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" >Eliminar</a>
                    <button type="submit" class="btn btn-primary btn-sm" form="recomendacion<?=$num_rec?>">Guardar</button>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>
