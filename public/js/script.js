$(document).ready(function() {
    let asientosSeleccionados = [];
    const $btnComprar = $("#btn-comprar");

    function revisarCambios() {
        $.ajax({
            url: "seats.php",
            type: "GET",
            dataType: "json",
            success: function(listaAsientos) {
                listaAsientos.forEach(function(asiento) {
                    
                    const $boton = $(".btn-asiento[data-id='" + asiento.id + "']");
                    const estadoEnPantalla = $boton.data("status");
                    
                    if (asiento.estado === "ocupado" && estadoEnPantalla !== "ocupado") {
                        if (asientosSeleccionados.includes(asiento.id)) {
                            asientosSeleccionados = asientosSeleccionados.filter(id => id !== asiento.id);
                            actualizarBotonCompra();
                        }

                        $boton.removeClass("btn-success btn-primary btn-outline-success")
                              .addClass("btn-danger disabled")
                              .data("status", "ocupado")
                              .prop("disabled", true);
                    }
                });
            },
            error: function(err) {
                console.log("No se pudo conectar para actualizar mapa");
            }
        });
    }
    setInterval(revisarCambios, 2000);

    $("#mapa-asientos").on("click", ".btn-asiento", function() {
        const $btn = $(this);
        const idAsiento = $btn.data("id");
        const estado = $btn.data("status"); 

        if (estado === "ocupado") return;

        if (asientosSeleccionados.includes(idAsiento)) {
            asientosSeleccionados = asientosSeleccionados.filter(id => id !== idAsiento);
            $btn.removeClass("btn-primary").addClass("btn-outline-success");
        } else {
            asientosSeleccionados.push(idAsiento);
            $btn.removeClass("btn-success btn-outline-success").addClass("btn-primary");
        }
        actualizarBotonCompra();
    });

    function actualizarBotonCompra() {
        if (asientosSeleccionados.length > 0) {
            $btnComprar.prop("disabled", false).text("Comprar (" + asientosSeleccionados.length + ")");
        } else {
            $btnComprar.prop("disabled", true).text("Selecciona asientos");
        }
    }

    $btnComprar.click(function() {
        if (asientosSeleccionados.length === 0) return;

        $btnComprar.prop("disabled", true).text("Procesando...");

        $.ajax({
            url: "process.php", 
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ "idsAsientos": asientosSeleccionados }),
            success: function(respuesta) {
                if (respuesta.exito) {
                    alert("¡Compra realizada con éxito!");
                    location.reload(); 
                } else {
                    alert("Error: " + respuesta.mensaje);
                    revisarCambios();
                    asientosSeleccionados = [];
                    actualizarBotonCompra();
                }
            },
            error: function() {
                alert("Error de conexión");
                $btnComprar.prop("disabled", false).text("Reintentar");
            }
        });
    });
});