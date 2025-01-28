<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<div class="col-sm-8 offset-sm-2">
    <div class="card mt-3 mb-3">
        <div class="card-header text-bg-primary">
            Valoración del evaluador
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url() ?>valoracion/valoracion_evaluador_guardar" id="valoracion">
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label>Evaluación</label>
                        <textarea rows="4" class="form-control" name="nom_proyecto" id="nom_proyecto" readonly><?=$valoracion_evaluador['cve_proyecto']?> - <?=$valoracion_evaluador['nom_proyecto']?></textarea>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-4">
                        <label for="evaluador">
                            Evaluador
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_evaluador" id="id_evaluador" value="<?= $valoracion_evaluador['id_evaluador'] ?> - <?= $valoracion_evaluador['nom_evaluador'] ?>" readonly>

                            <?php
                                $permisos_requeridos = array(
                                'valoracion_evaluador.can_edit',
                                'valoracion.etapa_activa',
                                'anio_activo',
                                );
                            ?>
                            <?php if (has_permission_and($permisos_requeridos, $permisos_usuario)) { ?>
                                <a href="<?=base_url()?>valoracion/valoracion_evaluador_seleccionar_evaluador/<?=$valoracion_evaluador['id_valoracion_evaluador']?>" class="btn btn-outline-secondary"><i class="bi bi-search"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="elaborado">
                            Elaborado por
                        </label>
                        <input type="text" class="form-control" name="elaborado" id="elaborado" value="<?=$valoracion_evaluador['elaborado']?>" required>
                    </div>
                    <div class="col-sm-4">
                        <label for="cargo">
                            Cargo
                        </label>
                        <input type="text" class="form-control" name="cargo" id="cargo" value="<?=$valoracion_evaluador['cargo']?>" required>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-4">
                        <label for="puntualidad">
                            Puntualidad en la entrega de los productos señalados en los Términos de Referencia
                            <a data-bs-toggle="collapse" href="#ayuda_puntualidad" role="button" aria-expanded="false" aria-controls="ayuda_puntualidad">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_puntualidad">
                            <div class="texto-ayuda">
                                <p>Califique en una escala de 1 a 10, donde 1 es un desempeño muy bajo del evaluador y 10 es un desempeño destacado en función de la entrega de los productos señalados en los Términos de Referencia en las fechas establecidas en los mismos.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="puntualidad" id="puntualidad" required>
                            <?php for ($valor = 0; $valor <= 10; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluador['puntualidad'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="solidez">
                            Solidez técnica y coherencia metodológica
                            <a data-bs-toggle="collapse" href="#ayuda_solidez" role="button" aria-expanded="false" aria-controls="ayuda_solidez">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_solidez">
                            <div class="texto-ayuda">
                                <p>Califique en una escala de 1 a 10, donde 1 es un desempeño muy bajo del evaluador y 10 es un desempeño destacado, en función de la coherencia entre la metodología utilizada por el evaluador y el logro de los productos solicitados en los términos de referencia.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="solidez" id="solidez" required>
                            <?php for ($valor = 0; $valor <= 10; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluador['solidez'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="objetividad">
                            Objetividad en las recomendaciones emitidas
                            <a data-bs-toggle="collapse" href="#ayuda_objetividad" role="button" aria-expanded="false" aria-controls="ayuda_objetividad">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_objetividad">
                            <div class="texto-ayuda">
                                <p>Califique en una escala de 1 a 10, donde 1 es un desempeño muy bajo del evaluador y 10 es un desempeño destacado, en función de la objetividad con la que el evaluador emitió las recomendaciones.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="objetividad" id="objetividad" required>
                            <?php for ($valor = 0; $valor <= 10; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluador['objetividad'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-sm-4">
                        <label for="claridad">
                            Claridad y coherencia en la narrativa
                            <a data-bs-toggle="collapse" href="#ayuda_claridad" role="button" aria-expanded="false" aria-controls="ayuda_claridad">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_claridad">
                            <div class="texto-ayuda">
                                <p>Califique en una escala de 1 a 10, donde 1 es un desempeño muy bajo del evaluador y 10 es un desempeño destacado, en función de la claridad y la coherencia narrativa con la que elaboró el Informe final y las recomendaciones contenidas en el mismo.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="claridad" id="claridad" required>
                            <?php for ($valor = 0; $valor <= 10; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluador['claridad'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="disponibilidad">
                            Disponibilidad para atención de requerimientos
                            <a data-bs-toggle="collapse" href="#ayuda_disponibilidad" role="button" aria-expanded="false" aria-controls="ayuda_disponibilidad">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                            <br />
                            <br />
                        </label>
                        <div class="collapse" id="ayuda_disponibilidad">
                            <div class="texto-ayuda">
                                <p>Califique en una escala de 1 a 10, donde 1 es un desempeño muy bajo del evaluador y 10 es un desempeño destacado, en función de la disponibilidad que mostró el evaluador para atender las observaciones generadas durante le desarrollo de la evaluación.</p>
                            </div>
                        </div>                
                        <select class="form-select" name="disponibilidad" id="disponibilidad" required>
                            <?php for ($valor = 0; $valor <= 10; $valor++) { ?>
                                <option value="<?=$valor?>" <?= $valoracion_evaluador['disponibilidad'] == $valor ? 'selected' : '' ?> ><?=$valor?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 text-center">
                        <div class="card">
                            <div class="card-header">
                                Puntaje total: <?= $valoracion_evaluador['puntaje_valoracion_evaluador'] ?>
                            </div>
                            <?php
                                $puntaje_valoracion_evaluador = $valoracion_evaluador['puntaje_valoracion_evaluador'];
                                switch(true) {
                                    case $puntaje_valoracion_evaluador == '':
                                        $fondo_valoracion = 'text-bg-light';
                                        $valoracion = '';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 0 and $puntaje_valoracion_evaluador <= 19:
                                        $fondo_valoracion = 'text-bg-danger';
                                        $valoracion = 'Mal desempeño';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 20 and $puntaje_valoracion_evaluador <= 29:
                                        $fondo_valoracion = 'text-bg-secondary';
                                        $valoracion = 'Desempeño bajo';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 30 and $puntaje_valoracion_evaluador <= 39:
                                        $fondo_valoracion = 'text-bg-warning';
                                        $valoracion = 'Desempeño medio';
                                        break;
                                    case $puntaje_valoracion_evaluador >= 40 and $puntaje_valoracion_evaluador <= 49:
                                        $fondo_valoracion = 'text-bg-success';
                                        $valoracion = 'Buen desempeño';
                                        break;
                                    case $puntaje_valoracion_evaluador == 50:
                                        $fondo_valoracion = 'text-bg-primary';
                                        $valoracion = 'Desempeño destacado';
                                        break;
                                    default:
                                        $fondo_valoracion = 'text-bg-light';
                                        $valoracion = '';
                                        break;
                                }
                            ?>
                            <div class="card-body <?=$fondo_valoracion?>">
                                <h5 class="m-1"><?= $valoracion ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <label for="observaciones">
                            Observaciones
                            <a data-bs-toggle="collapse" href="#ayuda_observaciones" role="button" aria-expanded="false" aria-controls="ayuda_observaciones">
                                <i class="bi bi-info-circle texto-menor"></i>
                            </a>
                        </label>
                        <div class="collapse" id="ayuda_observaciones">
                            <div class="texto-ayuda">
                                Especifique sus observaciones en caso de haberlas.
                            </div>
                        </div>                
                        <textarea rows="4" class="form-control" name="observaciones" id="observaciones"><?=$valoracion_evaluador['observaciones']?></textarea>
                    </div>
                </div>
                <input type="hidden" name="id_valoracion_evaluador" id="id_valoracion_evaluador" value="<?=$valoracion_evaluador['id_valoracion_evaluador']?>">
                <input type="hidden" name="id_propuesta_evaluacion" id="id_propuesta_evaluacion" value="<?=$valoracion_evaluador['id_propuesta_evaluacion']?>">
            </form>
            <div class="row">
                <div class="col-sm-8 offset-sm-2">
                    <?php include 'pdf_valoracion_evaluador.php' ?>
                </div>
            </div>
        </div>
        <?php
            $permisos_requeridos = array(
            'valoracion_evaluador.can_edit',
            'valoracion.etapa_activa',
            'anio_activo',
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

