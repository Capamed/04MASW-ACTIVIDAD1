<?php

$this->title = 'Reportes';
$this->breadcrumb = '/ Reportes';

UIHTML::HEADER($this);

?>

<style>
    .btn-reporte {
        height: 90px;
        font-weight: 800;
        font-size: 1.5rem;
        display: block;
        width: 100%;
    }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Listado de Reportes</h4>
                </div>
                <div class="card-body">
                    <div class="row" style="height: calc(100vh - 300px);">
                        <div class="col-md-4">
                            <button id="btnReporteCIAN" class="btn btn-outline-primary btn-reporte">REPORTE CITA ANUAL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalReporte" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="h5MRE" class="modal-title">Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating mb-3">
                                <select id="selectAnioMRE" class="form-control">
                                    <option value="-1">Desde el inicio de los tiempos</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                                <label for="selectAnioMRE">Anio</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnAceptarMRE" type="button" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalVisualizar" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visualización (DEBERÍA DESCARGAR PDF)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div id="divVisualizar"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php UIHTML::FOOTER($this); ?>

<script>
    var AData = [];

    window.onload = async function() {
        btnReporteCIAN.onclick = function() {
            Load.Modal().then(async function(jsonModal) {
                await UILoadingOverlay('show');
                await UIAjax.Get(hdURL.value + 'reporte/GetCitaAnual?anio=' + selectAnioMRE.value).then(r => {
                    var tableFiltro = new UITable.Create({
                        iddiv: 'Visualizar',
                        key: "anio",
                        source: r,
                        search: false,
                        columnas: [{
                                data: 'anio',
                                title: 'Año',
                                class: 'text-center',
                                classb: 'text-center',
                                size: '100px'
                            }, {
                                data: 'mes',
                                title: 'Mes',
                                class: 'text-center',
                                classb: 'text-center',
                                size: '150px',
                                render: function(jsonRow) {
                                    let html = '';
                                    switch (jsonRow.mes) {
                                        case 1:
                                            html = 'Enero';
                                            break;
                                        case 2:
                                            html = 'Febrero';
                                            break;
                                        case 3:
                                            html = 'Marzo';
                                            break;
                                        case 4:
                                            html = 'Abril';
                                            break;
                                        case 5:
                                            html = 'Mayo';
                                            break;
                                        case 6:
                                            html = 'Junio';
                                            break;
                                        case 7:
                                            html = 'Julio';
                                            break;
                                        case 8:
                                            html = 'Agosto';
                                            break;
                                        case 9:
                                            html = 'Septiembre';
                                            break;
                                        case 10:
                                            html = 'Octubre';
                                            break;
                                        case 11:
                                            html = 'Noviembre';
                                            break;
                                        case 12:
                                            html = 'Diciembre';
                                            break;
                                    }
                                    return html;
                                }
                            },
                            {
                                data: 'cantidad',
                                title: 'Cantidad de Citas Agendadas'
                            }
                        ],
                    });
                    var modalEl = document.querySelector('#modalVisualizar');
                    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                    UILoadingOverlay('hide');
                });
            });
        }
    }
    //FALTA HACERLO DINÁMICO, ME FALTÓ TIEMPO :|
    var Load = {
        Modal: async function(options) {
            UILoadingOverlay('hide');
            var modalEl = document.querySelector('#modalReporte');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            return new Promise(function(resolve, reject) {
                UIEvent.clearEvents(btnAceptarMRE, 'click');
                UIEvent.addListener(btnAceptarMRE, 'click', function() {
                    resolve('ok');
                    modal.hide();
                });
            });
        }
    }
</script>