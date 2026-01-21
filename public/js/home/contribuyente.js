function pdtRenta() {
  window.location.href = base_url + "pdt-renta";
}

function pdtPlame() {
  window.location.href = base_url + "pdt-plame";
}

function pdtAnual() {
  window.location.href = base_url + "pdt-anual";
}

const pdtanual = document.getElementById("pdtanual");

verificarPdtAnual();

function verificarPdtAnual() {
  fetch(`${base_url}verificar-pdt-anual`)
    .then((res) => res.json())
    .then((data) => {
      if (data.data.length != 0) {
        pdtanual.removeAttribute("hidden");
      }
    });
}
