const titulo = document.getElementById("pelicula");
const poster = document.getElementById("poster");
const skeleton = document.getElementById("skeleton");
const boton = document.getElementById("nueva");

function cargarPelicula() {
    // 1. Estado visual de carga
    titulo.classList.add("cargando");
    poster.classList.add("saliente"); // Inicia la animación de salida (blur + fade out)

    fetch("../backend/api.php")
        .then(respuesta => respuesta.json())
        .then(datos => {
            if (datos.error) {
                titulo.textContent = datos.error;
                titulo.classList.remove("cargando");
                poster.classList.remove("saliente");
                return;
            }

            // 2. Precargar la imagen en segundo plano (evita parpadeos o espacios en blanco)
            const imagenTemporal = new Image();
            imagenTemporal.src = datos.imagen;

            imagenTemporal.onload = () => {
                // 3. Solo cuando la imagen está lista, actualizamos el DOM
                titulo.textContent = datos.nombre;
                titulo.classList.remove("cargando");
                
                poster.src = datos.imagen;
                poster.classList.remove("saliente");
                poster.classList.add("entrante"); // Inicia animación de entrada
                
                // Ocultar skeleton después de la primera carga exitosa
                skeleton.style.display = "none";

                // Limpiar la clase de entrada cuando termine la animación para poder reutilizarla
                setTimeout(() => {
                    poster.classList.remove("entrante");
                }, 600); // Coincide con la duración en CSS (0.6s)
            };

            imagenTemporal.onerror = () => {
                titulo.textContent = "Error al cargar la imagen";
                titulo.classList.remove("cargando");
                poster.classList.remove("saliente");
            };
        })
        .catch(error => {
            console.error(error);
            titulo.textContent = "Error de conexión";
            titulo.classList.remove("cargando");
            poster.classList.remove("saliente");
        });
}

boton.addEventListener("click", cargarPelicula);

// Cargar la primera película al iniciar
cargarPelicula();