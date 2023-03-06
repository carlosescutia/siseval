<main role="main" class="ml-sm-auto px-4 mb-3 col-print-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="col-sm-12 alternate-color">
            <div class="row">
                <div class="col-sm-8 text-start">
					<h1 class="h2">Dependencias que no solicitan evaluaciones</h1>
                </div>
                <div class="col-sm-4 text-end">
                    <form>
                        <button formaction="<?= base_url() ?>reportes/listado_dependencias_sin_propuestas_01_csv" class="btn btn-primary">Exportar a excel</button>
                        <a href="javascript:window.print()" class="btn btn-primary">Generar pdf</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div style="min-height: 46vh">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Siglas</th>
                            <th scope="col">Nombre Dependencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dependencias_sin_propuestas as $dependencias_sin_propuestas_item) { ?>
                        <tr>
                            <td><?= $dependencias_sin_propuestas_item['nom_dependencia'] ?></td>
                            <td><?= $dependencias_sin_propuestas_item['nom_completo_dependencia'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>
