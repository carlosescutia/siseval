<div class="col-sm-8 offset-sm-2">
    <div class="card mt-3 mb-3">
        <div class="card-header text-bg-primary">
            Valoración de la evaluación
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>valoracion/valoracion_evaluacion_guardar" id="valoracion">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label>Evaluación</label>
                        <textarea rows="4" class="form-control" name="nom_proyecto" id="nom_proyecto" readonly><?=$valoracion_evaluacion['cve_proyecto']?> - <?=$valoracion_evaluacion['nom_proyecto']?></textarea>
                    </div>
                </div>

                <div class="row mb-5 d-print-none">
                    <div class="col-sm-12">
                        <label for="puntajes">
                            Puntajes para calificar
                            <a data-bs-toggle="collapse" href="#ayuda_puntajes" role="button" aria-expanded="true" aria-controls="ayuda_puntajes">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse show" id="ayuda_puntajes">
                            <div class="texto-ayuda">
                                <ul>
                                <li>1 punto: <strong>Insuficiente</strong>, Cuando los aspectos y/o antecedentes presentados no cumplen con el estándar evaluado.</li>
                                <li>2 puntos: <strong>Aceptable</strong>, Cuando los aspectos y/o antecedentes presentados cumplen mínimamente con el estándar evaluado.</li>
                                <li>3 puntos: <strong>Bueno</strong>, Cuando los aspectos y/o antecedentes presentados cumplen satisfactoriamente el estándar evaluado.</li>
                                <li>4 puntos: <strong>Sobresaliente</strong>, Cuando los aspectos y/o antecedentes presentados cumplen cabalmente con el estándar evaluado, generando un logro excepcional, superando lo esperado.</li>
                            </div>
                        </div>                
                    </div>                
                </div>

                <div class="row mb-5">
                    <div class="col-sm-3">
                        <label for="informe">
                            Informe técnico
                            <a data-bs-toggle="collapse" href="#ayuda_informe" role="button" aria-expanded="false" aria-controls="ayuda_informe">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_informe">
                            <div class="texto-ayuda">
                                <p>El informe de evaluación producido está sustentado en información documentada (entrevistas, informes, otras fuentes).</p>
                            </div>
                        </div>                
                        <select class="form-select" name="informe" id="informe" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['informe'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="antecedentes">
                            Antecedentes del Informe
                            <a data-bs-toggle="collapse" href="#ayuda_antecedentes" role="button" aria-expanded="false" aria-controls="ayuda_antecedentes">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_antecedentes">
                            <div class="texto-ayuda">
                                <p>El informe recoge la información previa que existe (documentos, informes, etc.), analizando el problema, sus características, partes interesadas, principales desafíos y riesgos de la intervención pública evaluada.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="antecedentes" id="antecedentes" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['antecedentes'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="metodologia">
                            Metodología confiable
                            <a data-bs-toggle="collapse" href="#ayuda_metodologia" role="button" aria-expanded="false" aria-controls="ayuda_metodologia">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_metodologia">
                            <div class="texto-ayuda">
                                <p>Los métodos de recolección de datos y las técnicas de análisis son rigurosas y consistentes con el objeto de evaluación (los instrumentos son apropiados y relevantes para medir).</p>
                            </div>
                        </div>                
                        <select class="form-select" name="metodologia" id="metodologia" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['metodologia'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="informacion">
                            Información confiable
                            <a data-bs-toggle="collapse" href="#ayuda_informacion" role="button" aria-expanded="false" aria-controls="ayuda_informacion">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_informacion">
                            <div class="texto-ayuda">
                                <p>Los datos recopilados se han verificado sistemáticamente, y están disponibles en elementos gráficos.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="informacion" id="informacion" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['informacion'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-3">
                        <label for="analisis">
                            Análisis de resultados y de datos
                            <a data-bs-toggle="collapse" href="#ayuda_analisis" role="button" aria-expanded="false" aria-controls="ayuda_analisis">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_analisis">
                            <div class="texto-ayuda">
                                <p>El informe expone los hallazgos y los relaciona con los objetivos de la intervención pública y con datos cuantitativos y cualitativos sólidos que corroboran las explicaciones desarrolladas.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="analisis" id="analisis" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['analisis'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="conclusiones">
                            Conclusiones y recomendaciones justificadas y vinculantes
                            <a data-bs-toggle="collapse" href="#ayuda_conclusiones" role="button" aria-expanded="false" aria-controls="ayuda_conclusiones">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_conclusiones">
                            <div class="texto-ayuda">
                                <p>Las conclusiones y recomendaciones de la evaluación, están completamente respaldadas y bien argumentadas, además están sustentadas en una sólida relación con las conclusiones y los hallazgos descritos.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="conclusiones" id="conclusiones" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['conclusiones'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="acuerdos_institucionales">
                            Acuerdos institucionales
                            <a data-bs-toggle="collapse" href="#ayuda_acuerdos_institucionales" role="button" aria-expanded="false" aria-controls="ayuda_acuerdos_institucionales">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_acuerdos_institucionales">
                            <div class="texto-ayuda">
                                <p>La evaluación realizada cumple a cabalidad con los términos de referencia.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="acuerdos_institucionales" id="acuerdos_institucionales" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['acuerdos_institucionales'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="acuerdos_confidencialidad">
                            Acuerdos de <br />confidencialidad
                            <a data-bs-toggle="collapse" href="#ayuda_acuerdos_confidencialidad" role="button" aria-expanded="false" aria-controls="ayuda_acuerdos_confidencialidad">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_acuerdos_confidencialidad">
                            <div class="texto-ayuda">
                                <p>La evaluación realizada incluye los protocolos de confidencialidad de las personas que proporcionaron información.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="acuerdos_confidencialidad" id="acuerdos_confidencialidad" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['acuerdos_confidencialidad'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-3">
                        <label for="derechos">
                            Derechos y respeto
                            <a data-bs-toggle="collapse" href="#ayuda_derechos" role="button" aria-expanded="false" aria-controls="ayuda_derechos">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_derechos">
                            <div class="texto-ayuda">
                                <p>La evaluación fue conducida de acuerdo con principios éticos y jurídicos definidos: independencia, imparcialidad, objetividad y profesionalismo.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="derechos" id="derechos" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['derechos'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="orientacion">
                            Orientación receptiva e inclusiva
                            <a data-bs-toggle="collapse" href="#ayuda_orientacion" role="button" aria-expanded="false" aria-controls="ayuda_orientacion">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_orientacion">
                            <div class="texto-ayuda">
                                <p>Los análisis realizados por la evaluación son sensibles a las creencias y costumbres, cuidando la dignidad de quienes participan en la evaluación, sean ejecutores o beneficiarios.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="orientacion" id="orientacion" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['orientacion'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="autonomia">
                            Autonomía
                            <a data-bs-toggle="collapse" href="#ayuda_autonomia" role="button" aria-expanded="false" aria-controls="ayuda_autonomia">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_autonomia">
                            <div class="texto-ayuda">
                                <p>Los/as evaluadores trabajan en forma autónoma de cualquier instancia política y pública.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="autonomia" id="autonomia" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['autonomia'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="genero">
                            Género
                            <a data-bs-toggle="collapse" href="#ayuda_genero" role="button" aria-expanded="false" aria-controls="ayuda_genero">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_genero">
                            <div class="texto-ayuda">
                                <p>La evaluación incluye un análisis de las brechas de género y/o desigualdades en el acceso a los bienes y servicios entre hombres y mujeres.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="genero" id="genero" required>
                            <?php for ($valor = 0; $valor <= 4; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluacion['genero'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="observaciones">
                            Observaciones
                        </label>
                        <textarea rows="4" class="form-control" name="observaciones" id="observaciones"><?=$valoracion_evaluacion['observaciones']?></textarea>
                    </div>
                    <div class="col-sm-6 text-center">
                        <label> </label>
                        <div class="card">
                            <div class="card-header">
                                Puntaje total: <?= $valoracion_evaluacion['puntaje_valoracion_evaluacion'] ?>
                            </div>
                            <?php
                                $puntaje_valoracion_evaluacion = $valoracion_evaluacion['puntaje_valoracion_evaluacion'];
                                switch(true) {
                                    case $puntaje_valoracion_evaluacion <= 24:
                                        $fondo_valoracion = 'text-bg-danger';
                                        $valoracion = 'Calidad insuficiente';
                                        $interpretacion = 'El proceso de evaluación no se ha implementado en forma adecuada, presentando problemas de precisión, problemas éticos y/o jurídicos. La evaluación incluye prácticas que revelan deficiencias o faltas graves.';
                                        break;
                                    case $puntaje_valoracion_evaluacion >= 25 and $puntaje_valoracion_evaluacion <= 34:
                                        $fondo_valoracion = 'text-bg-warning';
                                        $valoracion = 'Desempeño bajo';
                                        $interpretacion = 'El proceso de evaluación se ha implementado en forma asistemática o incompleta, por lo que su calidad es solo parcial. Se identifica algún grado de desarrollo, pero este resulta insuficiente pues presenta deficiencias en los ámbitos de precisión, éticos y/o jurídicos.';
                                        break;
                                    case $puntaje_valoracion_evaluacion >= 35 and $puntaje_valoracion_evaluacion <= 44:
                                        $fondo_valoracion = 'text-bg-success';
                                        $valoracion = 'Desempeño medio';
                                        $interpretacion = 'El proceso de evaluación es efectivo, ya que cumple con los criterios, procedimientos, prácticas, cualidades o logros necesarios para que sea funcional a los objetivos esperados. Sin embargo, aún presenta ciertas debilidades en alguno de los ámbitos de precisión, éticos y/o jurídicos.';
                                        break;
                                    case $puntaje_valoracion_evaluacion >= 45:
                                        $fondo_valoracion = 'text-bg-primary';
                                        $valoracion = 'Buen desempeño';
                                        $interpretacion = 'El proceso de evaluación es efectivo, e incluye prácticas reconocidas, destacadas o innovadoras que impactan positivamente los resultados de la evaluación, excede los parámetros esperados.';
                                        break;
                                    default:
                                        $fondo_valoracion = 'text-bg-light';
                                        $valoracion = '';
                                        $interpretacion = '';
                                        break;
                                }
                            ?>
                            <div class="card-body <?=$fondo_valoracion?>">
                                <h5 class="m-1"><?= $valoracion ?></h5>
                            </div>
                            <div class="card-footer text-start">
                                <?= $interpretacion ?>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id_valoracion_evaluacion" id="id_valoracion_evaluacion" value="<?=$valoracion_evaluacion['id_valoracion_evaluacion']?>">
                <input type="hidden" name="id_propuesta_evaluacion" id="id_propuesta_evaluacion" value="<?=$valoracion_evaluacion['id_propuesta_evaluacion']?>">
            </form>
            <div class="row">
                <div class="col-sm-8 offset-sm-2">
                    <?php include 'pdf_valoracion_evaluacion.php' ?>
                </div>
            </div>
        </div>
        <?php
            $permisos_requeridos = array(
            'valoracion_evaluacion.can_edit',
            'valoracion.etapa_actual',
            );
        ?>
        <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary btn-sm" form="valoracion">Guardar</button>
            </div>
        <?php } ?>
    </div>
</div>

<hr />
<div class="form-group row">
    <div class="col-sm-10 d-print-none">
        <a href="<?=base_url()?>valoracion" class="btn btn-secondary boton">Volver</a>
    </div>
</div>
