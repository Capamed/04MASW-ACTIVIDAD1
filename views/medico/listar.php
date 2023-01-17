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
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtNumeroIdentificacionMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtNumeroIdentificacionMMA"># Identificacion</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select id="selectEspecialidadMMA" class="form-control">
                                </select>
                                <label for="selectEspecialidadMMA">Especialidad</label>
                            </div>
                        </div>
                    </div>
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
                                <input id="txtTelefonoMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtTelefonoMMA">Telefono</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input id="txtCorreoElectronicoMMA" type="email" class="form-control" placeholder="_">
                                <label for="txtCorreoElectronicoMMA">Email</label>
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
    var AEspecialidad = [];
    var AData = [];
    window.onload = async function() {
        await Load.Especialidad(true);
        Load.Ready();
    }

    var Load = {
        Ready: async function() {
            UILoadingOverlay('hide');
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            await UILoadingOverlay('show');
            await UIAjax.Get(hdURL.value + 'medico/GetAllMedico').then(r => {
                AData = r;
                var tableFiltro = new UITable.Create({
                    iddiv: 'Medico',
                    key: "id_medico",
                    source: AData,
                    rowspan: true,
                    columnas: [{
                            data: 'id_medico',
                            title: '#',
                            class: 'text-center',
                            classb: 'text-center',
                            size: '100px'
                        }, {
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
                            title: '<button class="btnAgregar btn btn-sm btn-success m-auto" onclick="Load.Modal();"><i class="fa-solid fa-plus"></i></button>',
                            search: false,
                            size: '80px;text-align:center;vertical-align:middle;',
                            render: function(jsonRow) {
                                let html = '';
                                html += `<td style="display: flex;justify-content: space-between;">`;
                                html += `<button class="btnEditar btn btn-sm btn-warning m-auto"><i class="fa-solid fa-pen"></i></button>`;
                                html += `</td>`;
                                return html;
                            }
                        }
                    ],
                    eventos: [{
                        query: 'button.btnEditar',
                        tipo: 'click',
                        fn: function(e, jsonRow) {
                            Load.Modal(jsonRow);
                        }
                    }]
                });
                UILoadingOverlay('hide');
            });
        },
        Modal: async function(jsonRow) {
            if (jsonRow == null) {
                jsonRow = {};
                jsonRow.id_medico = -1;
            }
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            txtNumeroIdentificacionMMA.value = jsonRow.numero_identificacion || '';
            txtNombreMMA.value = jsonRow.nombre || '';
            txtApellidoMMA.value = jsonRow.apellido || '';
            txtTelefonoMMA.value = jsonRow.telefono || '';
            txtCorreoElectronicoMMA.value = jsonRow.correo_electronico || '';
            selectEspecialidadMMA.value = jsonRow.id_especialidad || '1';
            UIEvent.clearEvents(btnGuardarMMA);
            UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                let jsonParam = {
                    id_medico: jsonRow.id_medico,
                    numero_identificacion: txtNumeroIdentificacionMMA.value,
                    nombre: txtNombreMMA.value,
                    apellido: txtApellidoMMA.value,
                    telefono: txtTelefonoMMA.value,
                    correo_electronico: txtCorreoElectronicoMMA.value,
                    id_especialidad: selectEspecialidadMMA.value,
                };
                await UIAjax.runPostLoading(hdURL.value + 'medico/PostMedico', jsonParam, Load.Ready);
            });

            modal.show();
        },
        Especialidad: async function(showLoading) {
            showLoading = showLoading || false;
            if (showLoading) {
                await UILoadingOverlay('show');
            }
            await UIAjax.Get(hdURL.value + 'especialidad/GetAllEspecialidad').then(r => {
                AEspecialidad = r;
                UIHTML.Combobox('#selectEspecialidadMMA', AEspecialidad, 'id_especialidad', 'nombre');
            });
            if (showLoading) {
                UILoadingOverlay('hide');
            }
        }
    }
</script>