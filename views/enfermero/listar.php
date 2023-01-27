<?php

$this->title = 'Enfermero';
$this->breadcrumb = '/ Listado de Enfermeros';

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
            <div id="divEnfermero" style="font-size: 15px;"></div>
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
                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <input id="txtNumeroIdMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtNumeroIdMMA"># Id</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating mb-3">
                                <input id="txtNumeroIdentificacionMMA" type="text" class="form-control" placeholder="_" >
                                <label for="txtNumeroIdentificacionMMA">Identificación</label>
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
                                <label for="txtTelefonoMMA">Teléfono</label>
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
            await UIAjax.Get(hdURL.value + 'enfermero/GetAllEnfermero').then(r => {
                AData = r;
                var tableFiltro = new UITable.Create({
                    iddiv: 'Enfermero',
                    key: "id_enfermero",
                    source: AData,
                    rowspan: true,
                    columnas: [{
                            data: 'id_enfermero',
                            title: '#Id',
                            class: 'text-center',
                            size: '100px'
                        }, {
                            data: 'numero_identificacion',
                            title: 'Identificación',
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
                            size: '250px'
                        },
                        {
                            data: 'correo_electronico',
                            title: 'Correo',
                            size: '120px'
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
                            Load.Modal('e',jsonRow);
                        }
                    },
                    {
                        query: 'button.btnEliminar',
                        tipo: 'click',
                        fn: function(e, jsonRow) {
                            let tr = e.target.closest('tr');
                            tr.classList.add('blocked');
                            MsgBox('question', async function() {
                                    let jsonParam = {
                                        id_enfermero: jsonRow.id_enfermero
                                    };
                                    await UIAjax.runPostLoading(hdURL.value + 'enfermero/DeleteEnfermero', jsonParam, Load.Ready);
                                },
                                function() {
                                    tr.classList.remove('blocked');
                                });
                        }
                    }]
                });
                UILoadingOverlay('hide');
            });
        },
        Modal: async function(tipo, jsonRow) {
            const inputNumeroId = document.getElementById("txtNumeroIdMMA");
            const inputNumIdent = document.getElementById("txtNumeroIdentificacionMMA");
            const inputNombre = document.getElementById("txtNombreMMA");
            const inputApellido = document.getElementById("txtApellidoMMA");
            const tituloAction = document.getElementById("h5MMA");
            
           if(tipo === 'e'){
                tituloAction.innerHTML = 'EDITAR';
                inputNumeroId.disabled = true;
                inputNumIdent.disabled = true;
                inputNombre.disabled = true;
                inputApellido.disabled = true;
           }else{
                tituloAction.innerHTML = 'CREAR';
                inputNumeroId.disabled = true;
                inputNumIdent.disabled = false;
                inputNombre.disabled = false;
                inputApellido.disabled = false;
           }
           
            if (jsonRow == null) {
                jsonRow = {};
                jsonRow.id_enfermero = -1;
            }
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            txtNumeroIdMMA.value = jsonRow.id_enfermero || '';
            txtNumeroIdentificacionMMA.value = jsonRow.numero_identificacion || '';
            txtNombreMMA.value = jsonRow.nombre || '';
            txtApellidoMMA.value = jsonRow.apellido || '';
            txtTelefonoMMA.value = jsonRow.telefono || '';
            txtCorreoElectronicoMMA.value = jsonRow.correo_electronico || '';
            UIEvent.clearEvents(btnGuardarMMA);
            UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                let jsonParam = {
                    id_enfermero: (tipo === 'e')?jsonRow.id_enfermero:-1,
                    numero_identificacion: txtNumeroIdentificacionMMA.value,
                    nombre: txtNombreMMA.value,
                    apellido: txtApellidoMMA.value,
                    telefono: txtTelefonoMMA.value,
                    correo_electronico: txtCorreoElectronicoMMA.value
                };
                await UIAjax.runPostLoading(hdURL.value + `enfermero/PostEnfermero`, jsonParam, Load.Ready);
            });

            modal.show();
        }
    }
</script>