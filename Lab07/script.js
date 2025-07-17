// Validación de formulario
document.getElementById("validarBtn").addEventListener("click", function () {
  const nombre = document.getElementById("nombre").value.trim();
  const apellido = document.getElementById("apellido").value.trim();
  const mensaje = document.getElementById("mensaje");

  if (nombre === "" || apellido === "") {
    mensaje.textContent = "Debe completar todos los campos.";
    mensaje.className = "alert alert-danger";
  } else {
    mensaje.textContent = `Bienvenido, ${nombre} ${apellido}`;
    mensaje.className = "alert alert-success";
  }

  Swal.fire(mensaje.textContent);
});

// jQuery: Agregar y quitar clase
$("#agregarClase").click(function () {
  $("#bloqueTexto").addClass("color");
});

$("#quitarClase").click(function () {
  $("#bloqueTexto").removeClass("color");
});

// jQuery: Mostrar y ocultar elemento
$("#mostrarOcultar").click(function () {
  $("#elementoOculto").toggle();
});

let temaOscuro = false;

function alternarTema() {
  temaOscuro = temaOscuro ? false : true;
  if (!temaOscuro) {
    document.getElementById("tema").className = "fa-solid fa-moon";
  }
  else {
    document.getElementById("tema").className = "fa-solid fa-sun";
  }
  document.getElementById("main").classList.toggle("oscuro");
}

// Contador dinámico
let contador = 0;
const contadorElemento = document.getElementById("contador");

const modificarContador = (cambio) => {
  contador += cambio;
  contadorElemento.textContent = contador;
};