<?php

$this->title = 'Médico';
$this->breadcrumb = '/ Listado de Médicos';

UIHTML::HEADER($this);

$HTML_RENDER = "";

?>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-auto m-auto">
            <?php echo $HTML_RENDER ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div id="divMedico"></div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-8 mx-auto">
            <table class="table table-primary table-bordered table-hover table-erp">
                <thead>
                    <tr>
                        <th style="width: 65px;" class="text-center">Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th style="width: 65px;">Edad</th>
                        <th style="width: 90px;"></th>
                    </tr>
                </thead>
                <tbody id="tbodyData"></tbody>
            </table>
        </div>
    </div> -->
</div>

<div id="modalMantenimiento" class="modal fade" tabindex="-1" aria-labelledby="modalMantenimiento" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="h5MMA" class="modal-title">Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="txtNombreMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtNombreMMA">Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="txtApellidoMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtApellidoMMA">Apellido</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtEdadMMA" type="number" class="form-control" placeholder="_">
                                <label for="txtEdadMMA">Edad</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnGuardarMMA" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php UIHTML::FOOTER($this); ?>

<script>
    window.onload = async function() {

        var AData = [];
        await UILoadingOverlay('show');
        // UIAjax.Get(hdURL.value + 'medico/GetAllMedico')
        // fetch(hdURL.value + 'medico/GetAllMedico').then(r => r.json()).then(r => {
        await UIAjax.Get(hdURL.value + 'medico/GetAllMedico').then(r => {
            AData = r;
            var tableFiltro = new UITable.Create({
                iddiv: 'Medico',
                key: "id_medico",
                source: AData,
                columnas: [{
                        data: 'numero_identificacion',
                        title: '# Identificación',
                        classb: 'text-center',
                        size: '150px'
                    },
                    {
                        data: 'nombre',
                        title: 'Nombre'
                    },
                    {
                        data: 'apellido',
                        title: 'Apellido',
                    },
                    {
                        data: 'telefono',
                        title: 'Teléfono',
                        size: '120px'
                    },
                    {
                        data: null,
                        title: '',
                        search: false,
                        size: '80px',
                        render: function(jsonRow) {
                            let html = '';
                            html += `<td style="display: flex;justify-content: space-between;">`;
                            html += `<button class="btnEditar btn btn-sm btn-warning m-auto"><i class="fa-solid fa-pen"></i></button>`;
                            html += `<button class="btnEliminar btn btn-sm btn-danger m-auto"><i class="fa-solid fa-trash"></i></button>`;
                            html += `</td>`;
                            return html;
                        }
                    }
                ],
                eventos: [{
                    query: 'button.btnEditar',
                    tipo: 'click',
                    fn: function(e, jsonRow) {
                        var myModalEl = document.querySelector('#modalMantenimiento');
                        var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

                        txtNombreMMA.value = jsonRow.nombre;
                        txtApellidoMMA.value = jsonRow.apellido;
                        // txtEdadMMA.value = jsonRow.edad;
                        // var btnGuardarMMA = document.getElementById('btnGuardarMMA');
                        UIEvent.clearEvents(btnGuardarMMA);
                        UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                            let jsonParam = {
                                id_medico: jsonRow.id_medico,
                                nombre: txtNombreMMA.value,
                                apellido: txtApellidoMMA.value,
                            };
                            await UIAjax.runPostLoading(hdURL.value + 'medico/PostMedico', jsonParam);
                            // jsonParam.edad = txtEdadMMA.value;
                            // console.log('123', jsonParam);
                        });

                        modal.show();
                    }
                }, {
                    query: 'button.btnEliminar',
                    tipo: 'click',
                    fn: function(e, jsonRow) {
                        let tr = e.target.closest('tr');
                        tr.classList.add('blocked');
                        MsgBox('question', function() {

                        }, function() {
                            tr.classList.remove('blocked');
                        });
                    }
                }]
            });
            UILoadingOverlay('hide');
        });
    }
</script>