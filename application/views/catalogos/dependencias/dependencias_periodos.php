<div class="card mt-0 mb-3">
    <div class="card-header text-white bg-primary">
        Valores por período
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Período</th>
                    <th scope="col" class="text-start">Nombre</th>
                    <th scope="col" class="text-start">Siglas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dependencia_periodo as $dependencia_periodo_item) { ?>
                    <tr>
                        <td class="text-start"><?= $dependencia_periodo_item['periodo'] ?></td>
                        <td class="text-start"><a href="<?=base_url()?>dependencias_periodos/detalle/<?=$dependencia_periodo_item['id_dependencia_periodo']?>"><?= $dependencia_periodo_item['nom_completo_dependencia'] ?></td>
                        <td class="text-start"><?= $dependencia_periodo_item['nom_dependencia'] ?></td>
                        <td>
                            <?php 
                                $item_eliminar = $dependencia_periodo_item['periodo'] . ' ' . $dependencia_periodo_item['nom_completo_dependencia'] ;
                                $url = base_url() . "dependencias_periodos/eliminar/". $dependencia_periodo_item['id_dependencia_periodo']; 
                            ?>
                            <a href="#dlg_borrar" data-bs-toggle="modal" onclick="pass_data('<?=$item_eliminar?>', '<?=$url?>')" ><i class="bi bi-x-circle boton-eliminar" ></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer text-end">
        <form method="post" action="<?= base_url() ?>dependencias_periodos/nuevo">
            <div class="row">
                <input type="hidden" id="cve_dependencia" name="cve_dependencia" value="<?= $dependencias['cve_dependencia'] ?>">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
