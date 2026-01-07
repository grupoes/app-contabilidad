const ruc = document.getElementById("rucEmpresa");
const selectAnio = document.getElementById("selectAnio");
const selectMes = document.getElementById("selectMes");

listarBoletas();

function listarBoletas() {
  const anio = selectAnio.value;
  const mes = selectMes.value;
  const rucEmpresa = ruc.value;

  const formData = new FormData();
  formData.append("anio", anio);
  formData.append("mes", mes);
  formData.append("ruc", rucEmpresa);

  fetch(`${base_url}home/listarBoletas`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      viewBoletas(data.data);
    });
}

function viewBoletas(data) {
  let html = "";

  const lista = document.getElementById("lista");

  data.forEach((boleta) => {
    let htmlBoletas = "";

    let bol = boleta.boletas;

    bol.forEach((bole) => {
      htmlBoletas += `
            <div class="col-md-3 mb-3">
                <div class="card boleta-card shadow-none border mb-0">
                    <div class="card-body text-center">
                        <h6>Boleta de Pago - ${bole.mes_descripcion}</h6>
                        <a href="https://esconsultoresyasesores.com:9300/archivos/pdt/${bole.nameFile}" target="_blank" class="btn btn-sm btn-primary">Descargar PDF</a>
                    </div>
                </div>
            </div>
        `;
    });

    html += `
        <div class="col-md-12">
            <h5>${boleta.anio_descripcion}</h5>
            <hr>
            <div class="row">
                ${htmlBoletas}
            </div>

        </div>
        `;
  });

  lista.innerHTML = html;
}
