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
                        <div id="selectModCanMedico" class="col-md-6">
                            <div class="form-floating mb-3">
                             
                                <input id="txtNombreMedico" type="text" class="form-control" placeholder="_">
                                <label for="txtNombreMedico">Nombre Médico</label>
                            </div>
                        </div>
                        <div id="selectCrearMedico" class="col-md-6">
                            <div class="form-floating mb-3">
                                <select id="selectNombreMedico" class="form-control">
                                </select>
                                <label for="selectNombreMedico">Nombre Médico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-3" style="text-align: center">
                            <img src="./../assets/img/victima.png" alt="paciente" style="height:65px;">
                        </div>
                        <div id="selectModCanPaciente" class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="txtNombrePaciente" type="text" class="form-control" placeholder="_">
                                <label for="txtNombrePaciente">Nombre Paciente</label>
                            </div>
                        </div>
                        <div id="selectCrearPaciente" class="col-md-6">
                            <div class="form-floating mb-3">
                                <select id="selectNombrePaciente" class="form-control">
                                </select>
                                <label for="selectNombrePaciente">Nombre Paciente</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div id="selecModificar" class="form-floating mb-3">
                                <select id="selectEstadoCitaModificar" class="form-control">
                                    <option value="CON">CONFIRMADO</option>
                                    <option value="ATE">ATENDIDO</option>
                                </select>
                                <label for="selectEstadoCitaModificar">Estado Cita</label>
                            </div>
                            <div id="selecCrear" class="form-floating mb-3">
                                <select id="selectEstadoCitaCrear" class="form-control">
                                    <option value="AGE">AGENDADO</option>
                                </select>
                                <label for="selectEstadoCitaCrear">Estado Cita</label>
                            </div>
                            <div id="selecCancelar" class="form-floating mb-3">
                                <select id="selectEstadoCitaCancelar" class="form-control">
                                    <option value="CAN">CANCELADO</option>
                                </select>
                                <label for="selectEstadoCitaCancelar">Estado Cita</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtFechaIngreso" type="text" class="form-control" placeholder="_">
                                <label for="txtFechaIngreso">Fecha Ingreso</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtFechaModificacion" type="text" class="form-control" placeholder="_">
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
    var APacientes = [];
    var AMedicos = [];

    window.onload = async function() {
        await Load.Medicos(true);
        await Load.Pacientes(true);
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
            const inputSelectCancelar = document.getElementById("selecCancelar");
            const inputSelectModificar = document.getElementById("selecModificar");
            const inputSelectCrear = document.getElementById("selecCrear");
            const inputFechaIngreso = document.getElementById("txtFechaIngreso");
            const inputFechaModificacion = document.getElementById("txtFechaModificacion");
            const tituloAction = document.getElementById("h5MMA");
            //Combobox
            const comoboSelectModCanMedico = document.getElementById("selectModCanMedico");
            const comoboSelectCrearMedico = document.getElementById("selectCrearMedico");
            const comoboSelectModCanPaciente = document.getElementById("selectModCanPaciente");
            const comoboSelectCrearPaciente = document.getElementById("selectCrearPaciente");

           if(tipo === 'm'){
                tituloAction.innerHTML = 'MODIFICAR CITA';
                inputNombreMedico.disabled = true;
                inputNombrePaciente.disabled = true;
                inputSelectCrear.hidden = true;
                inputSelectModificar.hidden = false;
                inputSelectCancelar.hidden = true;
                selectEstadoCitaModificar.value = jsonRow.estado || 'AGE';
                comoboSelectCrearMedico.hidden = true;
                comoboSelectCrearPaciente.hidden = true;
                comoboSelectModCanMedico.hidden = false;
                comoboSelectModCanPaciente.hidden = false;
                inputFechaIngreso.disabled = false;
                inputFechaModificacion.disabled = false;
           }else if(tipo === 'c'){
                tituloAction.innerHTML = 'CREAR';
                inputNombreMedico.disabled = false;
                inputNombrePaciente.disabled = false;
                tituloAction.innerHTML = 'CREAR CITA';
                inputFechaIngreso.disabled = false;
                inputFechaModificacion.disabled = true;
                inputSelectModificar.hidden = true;
                inputSelectCancelar.hidden = true;
                inputSelectCrear.hidden = false;
                selectEstadoCitaCrear.value = jsonRow.estado || 'AGE';
                comoboSelectCrearMedico.hidden = false;
                comoboSelectCrearPaciente.hidden = false;
                comoboSelectModCanMedico.hidden = true;
                comoboSelectModCanPaciente.hidden = true;
            }else if(tipo === 'e'){
                inputNombreMedico.disabled = true;
                inputNombrePaciente.disabled = true;
                tituloAction.innerHTML = 'CANCELAR CITA';
                inputFechaIngreso.disabled = true;
                inputFechaModificacion.disabled = true;
                inputSelectModificar.hidden = true;
                inputSelectCrear.hidden = true;
                inputSelectCancelar.hidden = false;
                selectEstadoCitaCancelar.value = jsonRow.estado || 'CAN';
                comoboSelectCrearMedico.hidden = true;
                comoboSelectCrearPaciente.hidden = true;
                comoboSelectModCanMedico.hidden = false;
                comoboSelectModCanPaciente.hidden = false;
           }

            if (jsonRow == null) {
                jsonRow = {};
                jsonRow.id_cita = -1;
            }
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            txtNombreMedico.value = jsonRow.nombre_medico || '';
            txtNombrePaciente.value = jsonRow.nombre_paciente || '';
            txtFechaIngreso.value = jsonRow.fecha_ingreso || '';
            txtFechaModificacion.value = jsonRow.fecha_modificacion || '';
            selectNombreMedico.value = jsonRow.id_medico || '1';
            selectNombrePaciente.value = jsonRow.id_paciente || '1';
            UIEvent.clearEvents(btnGuardarMMA);
            UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                let jsonParam = {
                    id_cita: (tipo === 'c')?-1:jsonRow.id_cita,
                    nombre_medico: jsonRow.nombre_medico,
                    id_medico: jsonRow.id_medico,
                    nombre_paciente: jsonRow.nombre_paciente,
                    id_paciente: jsonRow.id_paciente,
                    estado: (tipo === 'm')? selectEstadoCitaModificar.value : (tipo === 'c')?selectEstadoCitaCrear.value:selectEstadoCitaCancelar.value,
                    fecha_ingreso: jsonRow.fecha_ingreso,
                    fecha_modificacion: jsonRow.fecha_modificacion
                };
                await UIAjax.runPostLoading(hdURL.value + 'cita/PostCita', jsonParam, Load.Ready);
            });

            modal.show();

        },
        Medicos: async function(showLoading){
            showLoading = showLoading || false;
            if (showLoading) {
                await UILoadingOverlay('show');
            }
            await UIAjax.Get(hdURL.value + 'medico/GetAllMedico').then(r => {
                AMedicos = r;
                ATmpMedicos = [];
                AMedicos.forEach(element => {
                    ATmpMedicos.push({apellido:element.apellido,correo_electronico: element.correo_electronico,id_especialidad:element.id_especialidad, id_medico:element.id_medico, nombre: element.nombre, numero_identificacion: element.numero_identificacion, telefono: element.telefono, nombre_completo: `Doc. ${element.nombre} ${element.apellido}`
                    });
                });
  
                UIHTML.Combobox('#selectNombreMedico', ATmpMedicos, 'id_medico', 'nombre_completo');
            });
            if (showLoading) {
                UILoadingOverlay('hide');
            }
        },
        Pacientes: async function(showLoading){
            showLoading = showLoading || false;
            if (showLoading) {
                await UILoadingOverlay('show');
            }
            await UIAjax.Get(hdURL.value + 'paciente/GetAllPaciente').then(r => {
                APacientes = r;
                ATmpPacientes = [];
                AMedicos.forEach(element => {
                    ATmpPacientes.push({apellido:element.apellido,correo_electronico: element.correo_electronico,direccion:element.direccion, estado:element.estado, fecha_nacimiento: element.fecha_nacimiento,nombre: element.nombre, id_paciente: element.id_paciente, telefono: element.telefono, sexo: element.sexo, nombre_completo_paciente: `${element.nombre} ${element.apellido}`
                    });
                });
                UIHTML.Combobox('#selectNombrePaciente', ATmpPacientes, 'id_paciente', 'nombre_completo_paciente');
            });
            if (showLoading) {
                UILoadingOverlay('hide');
            }
        }
    }
</script>