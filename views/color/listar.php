<?php

$this->title = 'Color';
$this->breadcrumb = '/ Listado de Colores';

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
            <div id="divDataPrincipal"></div>
        </div>
    </div>
</div>

<div id="modalMantenimiento" class="modal fade" tabindex="-1" aria-labelledby="modalMantenimiento" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="h5MMA" class="modal-title">Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input id="txtNombreMMA" type="text" class="form-control" placeholder="_">
                                <label for="txtNombreMMA">Nombre</label>
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
            await UIAjax.Get(hdURL.value + 'color/GetAllColor').then(r => {
                AData = r;
                var tableFiltro = new UITable.Create({
                    iddiv: 'DataPrincipal',
                    key: "id_color",
                    source: AData,
                    rowspan: true,
                    columnas: [{
                            data: 'id_color',
                            title: '#',
                            classb: 'text-center',
                            size: '100px'
                        },
                        {
                            data: 'nombre',
                            title: 'Nombre'
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
                            Load.Modal(jsonRow);
                        }
                    }, {
                        query: 'button.btnEliminar',
                        tipo: 'click',
                        fn: function(e, jsonRow) {
                            let tr = e.target.closest('tr');
                            tr.classList.add('blocked');
                            MsgBox('question', async function() {
                                    let jsonParam = {
                                        id_color: jsonRow.id_color
                                    };
                                    await UIAjax.runPostLoading(hdURL.value + 'color/DeleteColor', jsonParam, Load.Ready);
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
        Modal: async function(jsonRow) {
            if (jsonRow == null) {
                jsonRow = {};
                jsonRow.id_color = -1;
            }
            var modalEl = document.querySelector('#modalMantenimiento');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            txtNombreMMA.value = jsonRow.nombre || '';
            UIEvent.clearEvents(btnGuardarMMA);
            UIEvent.addListener(btnGuardarMMA, 'click', async function(e) {
                let jsonParam = {
                    id_color: jsonRow.id_color,
                    nombre: txtNombreMMA.value,
                };
                await UIAjax.runPostLoading(hdURL.value + 'color/PostColor', jsonParam, Load.Ready);
            });

            modal.show();

        }
    }
</script>