<?php
    $permisos_usuario = $userdata['permisos_usuario'];
    $cve_dependencia = $userdata['cve_dependencia'];
    $nom_dependencia = $userdata['nom_dependencia'];
    $anio_sesion = $userdata['anio_sesion'];
    $cve_rol = $userdata['cve_rol'];
?>
<div class="card mt-0 mb-3 text-center border-0">
    <div class="card-body">
        <div class="col-sm-6 offset-sm-3 bg-primary-subtle border border-primary-subtle rounded mb-5 pt-4 pb-2 px-3">
            <form method="post" action="<?= base_url() ?>inicio">
                <div class="row">
                    <div class="col-sm-4 mb-3">
                        <select class="form-select form-select-sm bg-primary-subtle border border-primary-subtle" name="periodo_filtro" onchange="this.form.submit()">
                            <option value="0" <?= ($periodo_filtro == '') ? 'selected' : '' ?> >Todos los ejercicios</option>
                            <?php foreach ($periodos_filtro as $periodos_filtro_item) { ?>
                            <option value="<?= $periodos_filtro_item['periodo']?>" <?= $periodo_filtro == $periodos_filtro_item['periodo'] ? 'selected' : '' ?> ><?=$periodos_filtro_item['periodo']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <select class="form-select form-select-sm bg-primary-subtle border border-primary-subtle" name="cve_dependencia_filtro" onchange="this.form.submit()">
                            <?php if ($cve_rol !== 'usr') { ?>
                                <option value="%" <?= ($cve_dependencia_filtro == '') ? 'selected' : '' ?> >Todas las dependencias</option>
                            <?php } ?>
                            <?php foreach ($dependencias_filtro as $dependencias_filtro_item) { ?>
                                <option value="<?= $dependencias_filtro_item['cve_dependencia']?>" <?= ($cve_dependencia_filtro == $dependencias_filtro_item['cve_dependencia']) ? 'selected' : '' ?> ><?=$dependencias_filtro_item['nom_dependencia']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <select class="form-select form-select-sm bg-primary-subtle border border-primary-subtle" name="tipo_evaluacion_filtro" onchange="this.form.submit()">
                            <option value="0" <?= ($tipo_evaluacion_filtro == '') ? 'selected' : '' ?> >Todas las evaluaciones</option>
                            <?php foreach ($tipos_evaluacion_filtro as $tipos_evaluacion_filtro_item) { ?>
                                <option value="<?= $tipos_evaluacion_filtro_item['id_tipo_evaluacion']?>" <?= ($tipo_evaluacion_filtro == $tipos_evaluacion_filtro_item['id_tipo_evaluacion']) ? 'selected' : '' ?> ><?=$tipos_evaluacion_filtro_item['nom_tipo_evaluacion']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="container text-center">
            <div class="row">
                <div class="col border border-dark-subtle border-2 rounded pt-4 mb-3 m-0 m-sm-3">
                    <h1>Evaluaciones</h1>
                    <div class="row mb-3">
                        <div class="col-sm-6 pt-4 pb-2 mb-3">
                            <h4>Programas evaluados</h4>
                            <h1 class="display-3"><?= $num_programas_evaluados ?></h1>
                        </div>
                        <div class="col-sm-6 pt-4 pb-2 mb-3">
                            <h4>Evaluaciones</h4>
                            <h1 class="display-3"><?= $num_propuestas_evaluacion ?></h1>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 pt-4 pb-2 mb-3">
                            <h3>Evaluaciones por ejercicio</h3>
                            <canvas id="evaluaciones_periodo" height="300"></canvas>
                        </div>
                        <div class="col-sm-6 pt-4 pb-2 mb-3">
                            <h3>Evaluaciones por tipo</h3>
                            <canvas id="evaluaciones_tipo"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col border border-dark-subtle border-2 rounded pt-4 mb-3 m-0 m-sm-3">
                    <h1>Recomendaciones</h1>
                    <div class="row mb-3">
                        <div class="col-sm-4 pt-4 pb-2 mb-3">
                            <h4>Generadas</h4>
                            <h1 class="display-3"><?= $num_recomendaciones ?></h1>
                        </div>
                        <div class="col-sm-4 pt-4 pb-2 mb-3">
                            <h4>Aceptadas</h4>
                            <h1 class="display-3"><?= $num_recomendaciones_aceptadas ?></h1>
                        </div>
                        <div class="col-sm-4 pt-4 pb-2 mb-3">
                            <h4>Atendidas</h4>
                            <h1 class="display-3"><?= $num_recomendaciones_atendidas ?></h1>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 pt-4 pb-2 mb-3">
                            <h3>Generadas vs Aceptadas</h3>
                            <canvas id="recomendaciones_generadas_aceptadas" height="300"></canvas>
                        </div>
                        <div class="col-sm-6 pt-4 pb-2 mb-3">
                            <h3>Aceptadas vs Atendidas</h3>
                            <canvas id="recomendaciones_aceptadas_atendidas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $periodos = array_column($evaluaciones_ejercicio, 'periodo');
    $periodos_txt = implode("','", $periodos);
    $num_evaluaciones_periodo = array_column($evaluaciones_ejercicio, 'num_evaluaciones');
    $num_evaluaciones_periodo_txt = implode("','", $num_evaluaciones_periodo);

    $tipos = array_column($evaluaciones_tipo, 'nom_tipo_evaluacion');
    $num_evaluaciones_tipo = array_column($evaluaciones_tipo, 'num_evaluaciones');
    $tipos_txt = implode("','", $tipos);
    $num_evaluaciones_tipo_txt = implode("','", $num_evaluaciones_tipo);
?>

<script>
Chart.register(ChartDataLabels);

const evaluaciones_periodo = document.getElementById('evaluaciones_periodo');
new Chart(evaluaciones_periodo, {
    type: 'bar',
    data: {
        labels: ['<?= $periodos_txt ?>'],
        datasets: [{
            data: ['<?= $num_evaluaciones_periodo_txt ?>'],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: false
            },
            datalabels: {
                anchor: 'end',
                align: 'start',
                color: 'blue',
                font: {
                    weight: 'bold',
                },
                formatter: function (value, context) {
                    return value;
                }
            }
        }
    }
});

const evaluaciones_tipo = document.getElementById('evaluaciones_tipo');
new Chart(evaluaciones_tipo, {
    type: 'doughnut',
    data: {
        labels: ['<?= $tipos_txt ?>'],
        datasets: [{
            data: ['<?= $num_evaluaciones_tipo_txt ?>'],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    font: {
                        size: 10
                    }
                }
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                color: 'blue',
                font: {
                    weight: 'bold',
                },
                formatter: function (value, context) {
                    return value;
                }
            }
        }
    }
});

const recomendaciones_generadas_aceptadas = document.getElementById('recomendaciones_generadas_aceptadas');
generadas = <?= $num_recomendaciones ?>;
aceptadas = <?= $num_recomendaciones_aceptadas ?>;
no_aceptadas = generadas - aceptadas;
new Chart(recomendaciones_generadas_aceptadas, {
    type: 'doughnut',
    data: {
        labels: ['Aceptadas','No aceptadas'],
        datasets: [{
            data: [aceptadas, no_aceptadas],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    font: {
                        size: 10
                    }
                }
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                color: 'blue',
                font: {
                    weight: 'bold',
                },
                formatter: function (value, ctx) {
                    let sum = 0;
                    let dataArr = ctx.chart.data.datasets[0].data;
                    dataArr.map(data => {
                        sum += data;
                    });
                    let percentage = (value*100 / sum).toFixed(0) + " %";
                    return percentage;
                }
            }
        }
    }
});

const recomendaciones_aceptadas_atendidas = document.getElementById('recomendaciones_aceptadas_atendidas');
aceptadas = <?= $num_recomendaciones_aceptadas ?>;
atendidas = <?= $num_recomendaciones_atendidas ?>;
no_atendidas = aceptadas - atendidas;
new Chart(recomendaciones_aceptadas_atendidas, {
    type: 'doughnut',
    data: {
        labels: ['Atendidas','No atendidas'],
        datasets: [{
            data: [atendidas, no_atendidas],
            borderWidth: 1
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    font: {
                        size: 10
                    }
                }
            },
            datalabels: {
                anchor: 'center',
                align: 'center',
                color: 'blue',
                font: {
                    weight: 'bold',
                },
                formatter: function (value, ctx) {
                    let sum = 0;
                    let dataArr = ctx.chart.data.datasets[0].data;
                    dataArr.map(data => {
                        sum += data;
                    });
                    let percentage = (value*100 / sum).toFixed(0) + " %";
                    return percentage;
                }
            }
        }
    }
});


</script>
