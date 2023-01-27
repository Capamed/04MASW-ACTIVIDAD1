<?php

$this->title = 'Cita';
$this->breadcrumb = '/ Historial Cita Pacientes';

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
        <div class="col-12">
            <div id="divDataPrincipal"></div>
        </div>
    </div>
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
                        <div class="col-3" style="text-align: center">
                            <img src="./../assets/img/doctor.png" alt="doctor" style="height:65px;">
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                             
                                <input id="txtNombreMedico" type="text" class="form-control" placeholder="_">
                                <label for="txtNombreMedico">Nombre Médico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-3" style="text-align: center">
                            <img src="./../assets/img/victima.png" alt="paciente" style="height:65px;">
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="txtNombrePaciente" type="text" class="form-control" placeholder="_">
                                <label for="txtNombrePaciente">Nombre Paciente</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select id="selectEstadoCita" class="form-control">
                                    <option value="1">CON</option>
                                    <option value="2">ATE</option>
                                </select>
                                <label for="selectEstadoCita">Estado Cita</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtFechaIngreso" type="email" class="form-control" placeholder="_">
                                <label for="txtFechaIngreso">Fecha Ingreso</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtFechaModificacion" type="email" class="form-control" placeholder="_">
                                <label for="txtFechaModificacion">Fecha Modificación</label>
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
            await UIAjax.Get(hdURL.value + 'cita/GetAllCita').then(r => {
                AData = r;
                var tableFiltro = new UITable.Create({
                    iddiv: 'DataPrincipal',
                    key: "id_cita",
                    source: AData,
                    rowspan: true,
                    columnas: [{
                            data: 'id_cita',
                            title: '#',
                            classb: 'text-center',
                            size: '50px'
                        },
                        {
                            data: 'nombre_medico',
                            title: 'Nombre Médico'
                        },
                        {
                            data: 'nombre_paciente',
                            title: 'Nombre Paciente',
                        },
                        {
                            data: 'estado',
                            title: 'Estado'
                        },
                        {
                            data: 'fecha_ingreso',
                            title: 'Fecha Ingreso'
                        },
                        {
                            data: 'fecha_modificacion',
                            title: 'Fecha Modificación'
                        },
                        {
                            data: null,
                            title: '<button class="btnAgregar btn btn-sm btn-success m-auto" onclick="Load.Modal(\'c\',\'\');"><i class="fa-solid fa-plus"></i></button>',
                            search: false,
                            size: '80px;text-align:center;vertical-align:middle;',
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
                                Load.Modal('m',jsonRow);
                            }
                        },
                        {
                        query: 'button.btnEliminar',
                        tipo: 'click',
                        fn: function(e, jsonRow) {
                                Load.Modal('e',jsonRow);
                        }
                    }
                    ]
                });
                UILoadingOverlay('hide');
            });
        },
        Modal: async function(tipo,jsonRow) {
            const inputNombreMedico = document.getElementById("txtNombreMedico");
            const inputNombrePaciente = document.getElementById("txtNombrePaciente");
            const inputEstado = document.getElementById("selectEstadoCita");
            const inputFechaIngreso = document.getElementById("txtFechaIngreso");
            const inputFechaModificacion = document.getElementById("txtFechaModificacion");
            const tituloAction = document.getElementById("h5MMA");
           if(tipo === 'm'){
                tituloAction.innerHTML = 'MODIFICAR CITA';
                inputNombreMedico.disabled = true;
                inputNombrePaciente.disabled = true;
           }else if(tipo === 'c'){
                tituloAction.innerHTML = 'CREAR';
                inputNombreMedico.disabled = false;
                inputNombrePaciente.disabled = false;
                tituloAction.innerHTML = 'CREAR CITA';
                inputFechaIngreso.disabled = false;
                inputFechaModificacion.disabled = true;
            }else if(tipo === 'e'){
                inputNombreMedico.disabled = true;
                inputNombrePaciente.disabled = true;
                tituloAction.innerHTML = 'CANCELAR CITA';
                inputFechaIngreso.disabled = true;
                inputFechaModificacion.disabled = true;
           }

            if (jsonRow == null) {
                jsonRow = {};
                jsonRow.id_paciente = -1;
            }
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            txtNombreMedico.value = jsonRow.nombre_medico || '';
            txtNombrePaciente.value = jsonRow.nombre_paciente || '';
            selectEstadoCita.value = jsonRow.estado || '1';
            txtFechaIngreso.value = jsonRow.fecha_ingreso || '';
            txtFechaModificacion.value = jsonRow.fecha_modificacion || '';
            UIEvent.clearEvents(btnGuardarMMA);
            UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                let jsonParam = {
                    id_cita: jsonRow.id_cita,
                    nombre_medico: txtNombreMedico.value,
                    id_medico: jsonRow.id_medico,
                    nombre_paciente: txtNombrePaciente.value,
                    id_paciente: jsonRow.id_paciente,
                    estado: selectEstadoCita.value,
                    fecha_ingreso: txtFechaIngreso.value,
                    fecha_modificacion: txtFechaIngrestxtFechaModificaciono.value
                };
                console.log(jsonParam);
                await UIAjax.runPostLoading(hdURL.value + 'paciente/PostPaciente', jsonParam, Load.Ready);
            });

            modal.show();

        }
    }
</script>