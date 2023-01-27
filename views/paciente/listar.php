<?php

$this->title = 'Paciente';
$this->breadcrumb = '/ Listado de Pacientes';

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
        <div class="col-md-4 mx-auto mb-2">
            <label>Estado</label>
            <select id="selectEstado" class="form-control" onchange=Load.Ready()>
                <option value="T">Todos</option>
                <option value="A" selected>Activo</option>
                <option value="I">Inactivo</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div id="divDataPrincipal"></div>
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
                        <div class="col-md-4 mb-3">
                            <label>Estado</label>
                            <select id="selectEstadoMMA" class="form-control">
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
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
                                <select id="selectSexoMMA" class="form-control">
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                                <label for="selectSexoMMA">Sexo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtTelefonoMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtTelefonoMMA">Telefono</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input id="txtDireccionMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtDireccionMMA">Dirección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating mb-3">
                                <input id="txtCorreoElectronicoMMA" type="email" class="form-control" placeholder="_">
                                <label for="txtCorreoElectronicoMMA">Email</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtFechaNacimientoMMA" type="email" class="form-control" placeholder="_">
                                <label for="txtFechaNacimientoMMA">F.Nacimiento</label>
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
    var AData = [];

    window.onload = async function() {
        Load.Ready();
    }

    var Load = {
        Ready: async function() {
            UILoadingOverlay('hide');
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();

            await UILoadingOverlay('show');
            await UIAjax.Get(hdURL.value + 'paciente/GetAllPaciente?estado=' + selectEstado.value).then(r => {
                AData = r;
                var tableFiltro = new UITable.Create({
                    iddiv: 'DataPrincipal',
                    key: "id_paciente",
                    source: AData,
                    rowspan: true,
                    columnas: [{
                            data: 'id_paciente',
                            title: '#',
                            classb: 'text-center',
                            size: '100px'
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
                jsonRow.id_paciente = -1;
            }
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            txtNombreMMA.value = jsonRow.nombre || '';
            txtApellidoMMA.value = jsonRow.apellido || '';
            selectSexoMMA.value = jsonRow.sexo || '1';
            txtTelefonoMMA.value = jsonRow.telefono || '';
            txtDireccionMMA.value = jsonRow.direccion || '';
            txtCorreoElectronicoMMA.value = jsonRow.correo_electronico || '';
            txtFechaNacimientoMMA.value = jsonRow.fecha_nacimiento || '';
            selectEstadoMMA.value = jsonRow.estado || '';
            UIEvent.clearEvents(btnGuardarMMA);
            UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                let jsonParam = {
                    id_paciente: jsonRow.id_paciente,
                    nombre: txtNombreMMA.value,
                    apellido: txtApellidoMMA.value,
                    sexo: selectSexoMMA.value,
                    telefono: txtTelefonoMMA.value,
                    direccion: txtDireccionMMA.value,
                    correo_electronico: txtCorreoElectronicoMMA.value,
                    fecha_nacimiento: txtFechaNacimientoMMA.value,
                    estado: selectEstadoMMA.value,
                };
                await UIAjax.runPostLoading(hdURL.value + 'paciente/PostPaciente', jsonParam, Load.Ready);
            });

            modal.show();

        }
    }
</script>