const UISleep = m => new Promise(r => setTimeout(r, m));

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
            MsgBox("Se eliminará el registro seleccionado.", mensaje, false, true, tipo);
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
