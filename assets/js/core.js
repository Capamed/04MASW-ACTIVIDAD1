const UISleep = m => new Promise(r => setTimeout(r, m));

const UIMath = {
    Random: function () {
        return new Date().getTime() + Math.floor(Math.random() * (15000 - 1)) + 1;
    },
};

let style_loading = document.createElement("style");
style_loading.append(`@keyframes loadingoverlay_animation__rotate_right{to{transform: rotate(360deg);}}`);
style_loading.append(`.UIloadingoverlay{box-sizing:border-box;position:fixed;display:flex;flex-flow:column nowrap;align-items:center;justify-content:space-around;background:rgba(0,0,0,0.5);top:0px;left:0px;width:100%;height:100%;z-index:2147483647;opacity:1;}`);
style_loading.append(`.UIloadingoverlay_element{order:1;box-sizing:border-box;overflow:visible;flex:00auto;display:flex;justify-content:center;align-items:center;animation-name:loadingoverlay_animation__rotate_right;animation-duration:2000ms;animation-timing-function:linear;animation-iteration-count:infinite;width:120px;height:120px;}`);
style_loading.append(`.UIloadingoverlay_text{color:white;user-select:none;order:4;box-sizing:border-box;overflow:visible;flex:0 0 auto;display:flex;justify-content:center;align-items:center;animation-timing-function:linear;animation-iteration-count:infinite;font-size:60px;}`);
document.head.appendChild(style_loading);

const UILoadingOverlay = async function (action) {
    switch (action) {
        case 'show':
            let AHtml = [];
            AHtml.push('<div id="UILoadingOverlay" class="UIloadingoverlay">');
            AHtml.push('<div class="UIloadingoverlay_element">');
            AHtml.push('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" style="width: 100%; height: 100%; fill: black;">');
            AHtml.push('<circle r="80" cx="500" cy="90" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="500" cy="910" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="90" cy="500" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="910" cy="500" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="212" cy="212" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="788" cy="212" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="212" cy="788" style="fill: black;"></circle>');
            AHtml.push('<circle r="80" cx="788" cy="788" style="fill: black;"></circle>');
            AHtml.push('</svg>');
            AHtml.push('</div>');
            AHtml.push('<div class="UIloadingoverlay_text">Por favor espere...</div>');
            AHtml.push('</div>');
            document.body.insertAdjacentHTML("afterend", AHtml.join(''));
            break;
        case 'hide':
            //console.log(document.getElementsByClassName('UIloadingoverlay'));
            //document.querySelectorAll('.UIloadingoverlay').forEach(function (a) {
            //	a.remove()
            //});
            var ele = document.getElementById('UILoadingOverlay');
            if (ele) ele.remove();
            //var fadeTarget = document.getElementsByClassName('UIloadingoverlay')[0];
            //var fadeEffect = setInterval(function () {
            //	if (!fadeTarget.style.opacity) {
            //		fadeTarget.style.opacity = 1;
            //	}
            //	if (fadeTarget.style.opacity > 0) {
            //		fadeTarget.style.opacity -= 0.33;
            //	} else {
            //		fadeTarget.remove();
            //		clearInterval(fadeEffect);
            //	}
            //}, 200);
            break;
    }
    await UISleep(200);
}

const isPlainObject = function (p) { return Object.prototype.toString.call(p) === '[object Object]' }
const isEmptyObject = function (p) { return JSON.stringify(p) === '{}' }

const UIEmpty = function (p) {
    var result = false;
    if (p === "" || p === null || p === undefined) {
        result = true;
    }
    if (isPlainObject(p)) {
        if (isEmptyObject(p)) {
            result = true;
        }
    }
    return result;
}

const URLParameters = {
    fromJson: function (jsonParam) {
        var url = Object.keys(jsonParam).map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(jsonParam[k])
        }).join('&');
        return url;
    }
}

const UIAjax = {
    Core: async function (metodo, url, params, respuesta) {
        return new Promise(async function (resolve, reject) {
            try {
                function SerializeToUrl(jsonParam) {
                    var url = Object.keys(jsonParam).map(function (k) {
                        return encodeURIComponent(k) + '=' + encodeURIComponent(jsonParam[k])
                    }).join('&');
                    return url;
                }

                params = params || {};

                let body = null;
                if (metodo == 'get') {
                    url = `${url}?${SerializeToUrl(params)}`;
                }
                else {
                    body = JSON.stringify(params);
                }

                var headers = new Headers();
                headers.append('Content-Type', 'application/json');

                fetch(url, {
                    method: metodo,
                    headers: headers,
                    body: body,
                }).then(async (r) => {
                    // console.log(r);
                    if (r.ok && r.status == 200) {
                        let json = await r.json();
                        resolve(json);
                    }
                });
            } catch (ex) {
                console.log(ex.message);
                reject(ex);
            }
        });
    },
    Get: async function (url, params) {
        return UIAjax.Core('get', url, params);
    },
    Post: async function (url, params) {
        return UIAjax.Core('post', url, params);
    },
    runPost: async function (url, params, fTrue, fFalse, fAlways) {
        await UIAjax.Post(url, params).then(async function (r) {
            if (r.success) {
                if (fTrue != null) {
                    await fTrue(r);
                }
                if (!params.HideSuccess) {
                    MsgBox('success');
                }
            }
            else {
                if (fFalse != null) {
                    await fFalse(r);
                }
                if (!params.HideWarning) {
                    var sbMensaje = r.mensaje.join('');
                    MsgBox(sbMensaje, "warning", false);
                }
            }
        }).catch(async function (ex) {
            if (fFalse != null) {
                await fFalse();
            }
            MsgBox(ex.Message);
        }).finally(async function () {
            if (fAlways != null) {
                await fAlways();
            }
        });
    },
    runPostLoading: async function (url, params, fTrue, fFalse) {
        await UILoadingOverlay('show');
        await UIAjax.runPost(url, params, fTrue, fFalse);
        UILoadingOverlay('hide');
    }
}

const UIEvent = {
    addListener: function (element, name, handler) {
        var events = element.$EVENTS;

        if (events == null)
            events = element.$EVENTS = {};

        var handlers = events[name];

        if (handlers == null)
            handlers = events[name] = [];

        var index = handlers.indexOf(handler);

        if (index == -1) {
            handlers.push(handler);
            element.addEventListener(name, handler);
        }
    },

    removeListener: function (element, name, handler) {
        var events = element.$EVENTS;

        if (events == null)
            return;

        var handlers = events[name];

        if (handlers == null)
            return;

        var index = handlers.indexOf(handler);

        if (index > -1) {
            handlers.splice(index, 1);
            element.removeEventListener(name, handler);
        }
    },

    clearEvents: function (element, name) {
        var events = element.$EVENTS;

        if (events) {
            function removeHandlers(handlers, name) {
                for (var i = 0; i < handlers.length; ++i) {
                    element.removeEventListener(name, handlers[i]);
                }
            }

            if (name) {
                var handlers = events[name];

                if (handlers) {
                    removeHandlers(handlers, name);
                }
            } else {
                for (var key in events) {
                    removeHandlers(events[key], key);
                }

                delete element.$EVENTS;
            }
        }
    }

}

const UITable = {
    Create: function (Options) {
        var OptionsDefault = {
            iddiv: UIMath.Random(),
            //idtable: UIMath.Random(),
            key: 0,
            source: [],
            search: true,
            rowspan: false,
            check: false,
            //metadata: [],
            //headers: [],
            //displays: [],
            //sizes: [],
            columnas: [],
            eventos: [],
            rpagina: 10,
            pbloque: 3,
            multiple: false,
        };

        OptionsDefault = { ...OptionsDefault, ...Options };

        var ID_DIV = `div${OptionsDefault.iddiv}`;
        var ID_TABLE = `table${OptionsDefault.iddiv}`;
        var ID_TBODY = `tbody${OptionsDefault.iddiv}`;
        var ID_THEAD = `thead${OptionsDefault.iddiv}`;
        var ID_FOOT = `tfoot${OptionsDefault.iddiv}`;
        var ID_TD_PAGINACION = `tdPag${OptionsDefault.iddiv}`;
        var ID_DIV_PAGINACION = `divPag${OptionsDefault.iddiv}`;

        //var ths = this;
        var ths = {};

        var AData = [];
        var ASource = [];
        var AMetaData = [];
        var AHeaders = [];
        var ADisplays = [];
        var ASizes = [];
        var AValues = [];
        var AValuesTemp = [];

        var AColumnas = [];
        var AEventos = [];
        var AInputs = [];
        var ARender = [];

        var AFilter = [];

        AEventos = OptionsDefault.eventos;


        ASource = OptionsDefault.source;
        AColumnas = OptionsDefault.columnas;

        for (var j = 0; j < AColumnas.length; j++) {
            AColumnas[j].id = UIMath.Random();
            if (AColumnas[j].render != undefined) {
                ARender.push(AColumnas[j]);
            }
        }
        if (ARender.length > 0) {
            for (var i = 0; i < ASource.length; i++) {
                for (var j = 0; j < ARender.length; j++) {
                    ASource[i][`render__${ARender[j].id}`] = ARender[j].render(ASource[i]) ?? '';
                }
            }
        }

        var IPagina = 0;
        var IBloque = 0;
        var RPagina = OptionsDefault.rpagina;
        var PBloque = OptionsDefault.pbloque;

        var Multiple = OptionsDefault.multiple;

        var Interno = {
            DRAW: function () {
                var tableString = '';
                var Valores = [];

                AFilter = [];

                if (AInputs.length > 0) {
                    var cInputs = AInputs.length;
                    for (var i = 0; i < ASource.length; i++) {
                        Valores = ASource[i];
                        let allow = true;//Insertará si cuenta con todos los filtros
                        for (var k = 0; k < cInputs; k++) {
                            var inputTemp = AInputs[k];
                            var valor = '';
                            let jsonColumna = AColumnas.find((x) => x.id == inputTemp.getAttribute('i'));
                            if (jsonColumna != undefined) {
                                if (jsonColumna.render != undefined) {
                                    valor = Valores[`render__${jsonColumna.id}`];
                                }
                                else {
                                    valor = Valores[jsonColumna.data] ?? '';
                                }
                            }

                            valor = String(valor).toLowerCase();
                            var filter = String(inputTemp.value).toLowerCase();
                            var re = new RegExp("(?<!<\/?[^>]*|&[^;]*)(" + filter + ")", "gi");
                            if (!re.test(valor)) {
                                allow = false;
                                break;
                            }
                        }
                        if (allow) {
                            AFilter.push(Valores);
                        }
                    }
                }
                else {
                    AFilter = ASource;
                }

                var inicio = IPagina * RPagina;
                var fin = inicio + RPagina;

                for (var i = inicio; i < fin && i < AFilter.length; i++) {
                    Valores = AFilter[i];
                    let key = String(Valores[OptionsDefault.key] ?? '');
                    let isSelected = AValuesTemp.includes(key);
                    tableString += `<tr z='${key}' class='${isSelected ? "selected" : ""}'>`;
                    if (OptionsDefault.check) {
                        tableString += `<td class="text-center align-middle" nc>`;
                        tableString += `<div class="checkbox erp-chk-1 d-inline m-0 cursor-pointer" without-label>`;
                        tableString += `<input id="chk${OptionsDefault.iddiv}${key}" type="checkbox" class="custom-control-input checks${OptionsDefault.iddiv}" ${isSelected ? "checked" : ""} value="${key}">`;
                        tableString += `<label for="chk${OptionsDefault.iddiv}${key}" class="cr m-0" nc></label>`
                        tableString += `</div>`;
                        tableString += `</td>`;
                    }

                    for (var j = 0; j < AColumnas.length; j++) {
                        let jsonColumna = AColumnas[j];
                        let rendered = '';
                        //console.log(jsonColumna);
                        let input = AInputs.find((x) => x.getAttribute('i') == jsonColumna.id);
                        let textSearch = input == null ? '' : input.value;
                        if (textSearch != '') {
                            if (jsonColumna.render != undefined) {
                                rendered = `${Interno.HighlightText(Valores[`render__${jsonColumna.id}`], textSearch, true)}`;
                            }
                            else {
                                rendered = `${Interno.HighlightText(Valores[jsonColumna.data], textSearch)}`
                            }
                        }
                        else {
                            if (jsonColumna.render != undefined) {
                                rendered = Valores[`render__${jsonColumna.id}`];
                            }
                            else rendered = `${Valores[jsonColumna.data]}`;
                        }
                        if (!rendered.startsWith('<td')) {
                            rendered = `<td class="${jsonColumna.classb}">${rendered}</td>`;
                        }
                        tableString += rendered;
                    }

                    tableString += `</tr>`;
                }

                document.getElementById(ID_TBODY).innerHTML = tableString;

                var nRegistros = AFilter.length;
                var nPaginas = Math.ceil(nRegistros / RPagina);
                var nBloques = Math.ceil(nPaginas / PBloque);

                var inicio = IBloque * PBloque;
                var fin = inicio + PBloque;

                var tdPag = '';
                //tdPag += `<div class="mx-auto">`;
                tdPag += `<div class="btn-toolbar" role="toolbar">`;
                tdPag += `<div class="btn-group mx-auto" role="group">`;
                if (nPaginas > 1 /*&& IBloque > 0*/) {
                    if (IBloque > 0) {
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-primary" z="-1"><<</button>`;
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-primary" z="-2"><</button>`;
                    }
                    else {
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-secondary" z="-1" disabled><<</button>`;
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-secondary" z="-2" disabled><</button>`;
                    }
                }
                for (var i = inicio; i < fin && i < nPaginas; i++) {
                    tdPag += `<button class="btn-pag btn btn-sm ${i == IPagina ? 'btn-primary' : 'btn-outline-primary'}" z="${i}">${i + 1}</button>`;
                    //tdPag += `<button class="btn-pag btn btn-sm ${i == IPagina ? 'btn-primary' : 'btn-outline-primary'}" z="${i}">${(i < 9 ? '0' : '') + (i + 1)}</button>`;
                }
                if (nPaginas > 1 /*&& IBloque < (nBloques - 1)*/) {
                    if (IBloque < (nBloques - 1)) {
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-primary" z="-3">></button>`;
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-primary" z="-4">>></button>`;
                    }
                    else {
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-secondary" z="-3" disabled>></button>`;
                        tdPag += `<button class="btn-pag btn btn-sm btn-outline-secondary" z="-4" disabled>>></button>`;
                    }
                }
                tdPag += `</div>`;
                tdPag += `</div>`;
                //tdPag += `</div>`;
                //var elePaginacion = document.getElementById(ID_TD_PAGINACION);
                var elePaginacion = document.getElementById(ID_DIV_PAGINACION);
                elePaginacion.innerHTML = tdPag;
                elePaginacion.style.display = nPaginas > 1 ? '' : 'none';

                var trs = document.getElementById(ID_TBODY).querySelectorAll('tr');
                var chks = document.getElementById(ID_TBODY).querySelectorAll(`input.checks${OptionsDefault.iddiv}`);
                if (trs.length > 0) {
                    for (var i = 0; i < trs.length; i++) {
                        trs[i].addEventListener('click', function (e) {
                            let td = e.target;
                            if (td.getAttribute('nc') == '') return;//nc (no click) evitar click al row
                            if (!Multiple) {
                                trs.forEach((x) => {
                                    x.classList.remove('selected');
                                });
                                chks.forEach((x) => {
                                    x.checked = false;
                                });
                            }
                            this.classList.toggle('selected');
                            let chk = this.querySelector(`input#chk${OptionsDefault.iddiv}${this.getAttribute('z')}`);
                            if (chk != null) {
                                chk.checked = this.classList.contains('selected');
                            }
                            Interno.AddTemp(this.getAttribute('z'));
                            let chkALL = document.getElementById(`chk${OptionsDefault.iddiv}ALL`);
                            if (chkALL != null) {
                                chkALL.checked = (ASource.length > 0 && AValuesTemp.length == ASource.length);
                            }
                            //}
                        });
                        for (let o = 0; o < AEventos.length; o++) {
                            let jsonEvento = AEventos[o];
                            let ele = trs[i].querySelector(jsonEvento.query);
                            if (ele) {
                                let jsonRow = AFilter.find((x) => x[OptionsDefault.key] == trs[i].getAttribute('z'));
                                ele.addEventListener(jsonEvento.tipo, async function (e) {
                                    await jsonEvento.fn.call(ele, e, jsonRow);
                                });
                            }
                        }
                    }
                }
                if (chks.length > 0) {
                    for (var i = 0; i < chks.length; i++) {
                        chks[i].addEventListener('click', function (e) {
                            e.stopPropagation();
                            let chk = this;
                            let tr = chk.closest('tr');
                            if (!Multiple) {
                                for (var k = 0; k < trs.length; k++) {
                                    trs[k].classList.remove('selected');
                                }
                                for (var k = 0; k < chks.length; k++) {
                                    if (chks[k].id != chk.id) {
                                        chks[k].checked = false;
                                    }
                                }
                            }
                            if (chk.checked) {
                                tr.classList.add('selected');
                            }
                            else {
                                tr.classList.remove('selected');
                            }
                            Interno.AddTemp(tr.getAttribute('z'));
                            document.getElementById(`chk${OptionsDefault.iddiv}ALL`).checked = (ASource.length > 0 && AValuesTemp.length == ASource.length);
                        });
                    }
                }

                //var btns = document.getElementById(ID_TD_PAGINACION).querySelectorAll('button.btn-pag');
                var btns = document.getElementById(ID_DIV_PAGINACION).querySelectorAll('button.btn-pag');
                if (btns.length > 0) {
                    for (var i = 0; i < btns.length; i++) {
                        btns[i].addEventListener('click', function (e) {
                            btns.forEach((x) => {
                                x.classList.add('btn-outline-primary');
                                x.classList.remove('btn-primary');
                            });
                            this.classList.remove('btn-outline-primary');
                            this.classList.add('btn-primary');

                            IPagina = Number(this.getAttribute('z'));
                            if (IPagina > -1) {
                                IBloque = Math.floor(IPagina / PBloque);
                            }
                            else {
                                switch (IPagina) {
                                    case -1:
                                        //Primer Bloque
                                        IBloque = 0;
                                        IPagina = 0;
                                        break;
                                    case -2:
                                        //Bloque Anterior
                                        IBloque--;
                                        IPagina = IBloque * PBloque;
                                        break;
                                    case -3:
                                        //Siguiente Bloque
                                        IBloque++;
                                        IPagina = IBloque * PBloque;
                                        break;
                                    case -4:
                                        //Último Bloque
                                        var nRegistros = AFilter.length;
                                        var nPaginas = Math.ceil(nRegistros / RPagina);
                                        var nBloques = Math.ceil(nPaginas / PBloque);
                                        IBloque = nBloques - 1;
                                        IPagina = IBloque * PBloque;
                                        break;
                                }
                            }
                            //console.log(IPagina);
                            Interno.DRAW();
                        });
                    }
                }

                //var divEle = document.getElementById(ID_DIV);

                //var tableEle = document.getElementById(ID_TABLE);

                //if (window.getComputedStyle(tableEle).width > window.getComputedStyle(divEle).width) {
                //	tableEle.classList.add('table-responsive');
                //}


            },
            HighlightText: function (value, search, isrender) {
                value = value ?? '';
                value = String(value);

                var tdString = "";

                if (isrender) {
                    var re = new RegExp("(?<!<\/?[^>]*|&[^;]*)(" + search + ")", "gi");
                    tdString += value.replace(re, "<span class='highlight'>$1</span>");
                }
                else {
                    var valueLower = String(value).toLowerCase();
                    var valueCount = valueLower.length;
                    var searchLower = String(search).toLowerCase();
                    var searchCount = searchLower.length;
                    var iAnterior = 0;
                    var iActual = 0;

                    while (iActual > -1) {
                        iActual = valueLower.indexOf(searchLower, iActual);
                        if (iActual > -1) {
                            tdString += value.substring(iAnterior, iActual);
                            tdString += `<font class='highlight'>${value.substr(iActual, searchCount)}</font>`;
                            iAnterior = iActual + searchCount;
                            iActual = iActual + searchCount;
                        }
                    }
                    tdString += value.substring(iAnterior, valueCount);
                }
                return tdString;
            },
            AddTemp: function (value) {
                if (value != null && value != undefined) {
                    value = String(value);
                }
                if (!Multiple) {
                    AValuesTemp = [];
                }
                if (!AValuesTemp.includes(value)) {
                    AValuesTemp.push(value);
                }
                else {
                    var index = AValuesTemp.indexOf(value);
                    if (index > -1) {
                        AValuesTemp.splice(index, 1);
                    }
                }
            }
        };

        var tableString = '';

        tableString += `<div class="table-responsive-sm">`;
        tableString += `<table id="${ID_TABLE}" class="w-100 m-0 table table-sm table-erp table-bordered">`;
        tableString += `<thead id="${ID_THEAD}" class="thead-sky">`;
        tableString += `<tr>`;

        if (OptionsDefault.check) {
            tableString += `<th class="text-center align-middle" rowspan="2" style="width:60px;">`;
            if (Multiple) {
                tableString += `<div class="checkbox checkbox-primary d-inline m-0 cursor-pointer" without-label>`;
                tableString += `<input id="chk${OptionsDefault.iddiv}ALL" type="checkbox" class="custom-control-input" value="ALL">`;
                tableString += `<label for="chk${OptionsDefault.iddiv}ALL" class="cr m-0"></label>`
                tableString += `</div>`;
            }
            tableString += `</th>`;
        }

        var style = '';
        var inputString = '';
        var styleDiv = 'style="background-color:white;color:black;white-space: nowrap;overflow: hidden;"';
        styleDiv = 'style="height: 21px;width: 100%;border: none;padding: 0;padding-left:24px;"';

        for (var i = 0; i < AColumnas.length; i++) {
            let jsonColumna = AColumnas[i];
            jsonColumna.search = jsonColumna.search ?? true;
            style = jsonColumna.size != undefined ? `style="border: 1px solid;width:${jsonColumna.size}"` : ''
            tableString += `<th rowspan="${jsonColumna.search ? 1 : (OptionsDefault.rowspan ? 2 : 1)}" ${style} class="${jsonColumna.class ?? ''}">${jsonColumna.title}</th>`;
            if (OptionsDefault.search) {
                if (jsonColumna.search || !OptionsDefault.rowspan) {
                    //inputString += searchString;
                    inputString += `<th ${style}>`;
                    if (jsonColumna.search) {
                        inputString += `<div style="position:relative;">`;
                        inputString += `<input i="${jsonColumna.id}" spellcheck="false" class="txt-filtrar" ${styleDiv} placeholder="..." />`;
                        inputString += `<label class="fa-solid fa-magnifying-glass text-dark" style="position: absolute;left: 3px;top: calc(50% - 0.5em);"></label>`;
                        // <i class="fa-solid fa-magnifying-glass"></i>
                        inputString += `</div>`;
                    }
                    inputString += `</th>`;
                }
            }
            //console.log(jsonColumna);
        }

        tableString += `</tr>`;

        if (!UIEmpty(inputString)) {
            tableString += `<tr>`;
            tableString += inputString;
            tableString += `</tr>`;
        }

        tableString += `</thead>`;
        tableString += `<tbody id="${ID_TBODY}">`;
        tableString += `</tbody>`;

        tableString += `<tfoot id="${ID_FOOT}">`;

        //tableString += `<tr>`;
        //switch (OptionsDefault.from) {
        //	case "csv":
        //		tableString += `<td id="${ID_TD_PAGINACION}" colspan=${AHeaders.length} class="text-center">`;
        //		break;
        //	case "json":
        //		tableString += `<td id="${ID_TD_PAGINACION}" colspan=${AColumnas.length} class="text-center">`;
        //		break;
        //}
        //tableString += `</td>`;
        //tableString += `</tr>`;

        tableString += `</tfoot>`;

        tableString += `</table>`;
        tableString += `</div>`;
        var divPagString = '';
        divPagString += `<div id="${ID_DIV_PAGINACION}" class="mx-auto mt-2">`;
        divPagString += `</div>`;

        //document.getElementById(ID_TABLE).innerHTML = tableString;
        var divEle = document.getElementById(ID_DIV);

        divEle.innerHTML = '';
        divEle.insertAdjacentHTML('afterbegin', tableString);
        divEle.insertAdjacentHTML('beforeend', divPagString);

        //var AThs1 = document.getElementById(ID_TABLE).querySelectorAll('thead tr:first-child th');
        //if (AThs1 != null && AThs1.length > 0) {
        //	for (var i = 0; i < AThs1.length; i++) {
        //		console.log(AThs1[i]);
        //		console.log(AThs1[i].style);
        //	}
        //}

        var chkAll = document.getElementById(`chk${OptionsDefault.iddiv}ALL`);
        if (chkAll != null) {
            chkAll.addEventListener('change', function (e) {
                ths.SmartSelect(true);
            });
        }

        var AInputs = Array.from(document.getElementById(ID_THEAD).querySelectorAll('input.txt-filtrar'));
        //AInputs = Array.from(document.getElementById(ID_THEAD).querySelectorAll('div.txt-filtrar'));
        if (AInputs.length > 0) {
            for (var i = 0; i < AInputs.length; i++) {
                AInputs[i].addEventListener('keyup', function (e) {
                    //AInputs[i].addEventListener('input', function (e) {
                    //console.log(this.value);
                    //console.log(this.value.length);
                    IBloque = 0;
                    IPagina = 0;
                    Interno.DRAW();
                });
            }
        }

        ths.Imprimir = function () {
            console.log(UIMath.Random());
        }
        ths.SmartSelect = function (Draw) {
            Draw = Draw || true;
            if (ASource.length > 0) {
                if (AValuesTemp.length >= ASource.length) {
                    AValuesTemp = [];
                }
                else {
                    for (var i = 0; i < ASource.length; i++) {
                        if (AValuesTemp.indexOf(ASource[i][OptionsDefault.key]) == -1) {
                            AValuesTemp.push(ASource[i][OptionsDefault.key]);
                        }
                    }
                }
                if (Draw) {
                    Interno.DRAW();
                }
            }
        }

        ths.ByKey = function (key) {
            return ASource.find((x) => x[OptionsDefault.key] == key);
        }
        ths.AddUpdate = function (jsonRow) {
            if (OptionsDefault.key != undefined) {
                let index = ASource.findIndex((x) => x[OptionsDefault.key] == jsonRow[OptionsDefault.key]);
                if (index > -1) {
                    if (ARender.length > 0) {
                        for (var j = 0; j < ARender.length; j++) {
                            jsonRow[`render__${ARender[j].id}`] = ARender[j].render(jsonRow) ?? '';
                        }
                    }
                    ASource[index] = jsonRow;
                }
            }
        }
        //ths.ByEle = function (ele) {
        //	//return ASource.find((x) => x[OptionsDefault.key] == key);
        //}
        ths.AJson = function () {
            var resultado = [];
            if (AValuesTemp.length > 0) {
                for (var i = 0; i < AValuesTemp.length; i++) {
                    //AValuesTemp[i][OptionsDefault.key]
                    let jsonSingle = ASource.find((x) => x[OptionsDefault.key] == AValuesTemp[i]);
                    resultado.push(jsonSingle);
                }
            }
            return resultado;
            //return ASource.find((x) => x[OptionsDefault.key] == key);
        }
        ths.Json = function () {
            var resultado = null;
            if (AValuesTemp.length > 0) {
                resultado = ASource.find((x) => x[OptionsDefault.key] == AValuesTemp[0]);
            }
            return resultado;
            //return ASource.find((x) => x[OptionsDefault.key] == key);
        }
        //tablaColaborador.AElement();
        //tablaColaborador.AJson();
        //tablaColaborador.Element();
        //tablaColaborador.Json();

        IPagina = 0;
        IBloque = 0;

        Interno.DRAW();

        return ths;
    },
};

const MsgBox = function (mensaje, tipo, autoclose, dangerMode, funcTrue, funcFalse) {
    switch (mensaje) {
        case "success":
            exit = true;
            MsgBox("Cambios guardados con éxito.", "success", tipo ?? true);
            break;
        case "warning": case "error":
            exit = true;
            MsgBox("No se pudo completar el envio.", mensaje, tipo ?? true);
            break;
        case "question":
            exit = true;
            MsgBox("Se eliminará el registro seleccionado.", mensaje, false, true, tipo, autoclose);
            break;
    }
    var title = "";
    switch (tipo) {
        case "success":
            title = "Buen Trabajo!";
            break;
        case "warning":
            title = "Ups!";
            break;
        case "info":
            title = "Información";
            break;
        case "error":
            title = "Sucedio un error!";
            break;
        case "question":
            title = "¿Está seguro?";
            break;
    }
    if (title != "") {
        if (tipo == 'question') {
            var btnColor = "#04A9F5";
            if (dangerMode) {
                btnColor = "#E44343";
            }
            Swal.fire({
                title: title,
                //text: mensaje,
                html: mensaje,
                icon: tipo,
                //buttons: { confirm: true, cancel: true },
                showCancelButton: true,
                confirmButtonColor: btnColor,
                //cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    if (!UIEmpty(funcTrue)) {
                        funcTrue();
                    }
                }
                else {
                    if (!UIEmpty(funcFalse)) {
                        funcFalse();
                    }
                }
            });
        }
        else {
            if (autoclose) {
                if (tipo == "success") {
                    Swal.fire({ icon: tipo, title: title, html: mensaje, showConfirmButton: false, timer: 1000 });
                }
                else {
                    Swal.fire({ icon: tipo, title: title, html: mensaje, showConfirmButton: false, timer: 1350 });
                }
            }
            else {
                Swal.fire({ icon: tipo, title: title, html: mensaje });
            }
        }
    }
};
