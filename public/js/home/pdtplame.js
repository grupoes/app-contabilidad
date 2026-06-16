const formConsulta = document.getElementById("formConsulta");
const tableConsulta = document.getElementById("tableConsulta");
const numero_doc = document.getElementById("numero_doc");

loadAnios();

const anio = document.getElementById("anio");

function loadAnios() {
  fetch(`${base_url}getAniosAll`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "ok") {
        const datos = data.data;

        let html = `<option value="">Seleccione...</option>`;

        datos.forEach((year) => {
          html += `<option value="${year.id_anio}">${year.anio_descripcion}</option>`;
        });

        anio.innerHTML = html;
      } else {
        alert(data.message);
      }
    });
}

formConsulta.addEventListener("submit", (e) => {
  e.preventDefault();

  tableConsulta.innerHTML = "";

  const formData = new FormData(formConsulta);

  fetch(`${base_url}consulta-pdt-plame`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        viewPdtPlame(data.data);
      } else {
        alert(data.message);
      }
    });
});

function viewPdtPlame(data) {
  if (data == null) {
    tableConsulta.innerHTML = `<h4 class="text-center">No se encontraron resultados</h4>`;
    return false;
  }

  let planilla = "";
  let r12 = "";
  let constancia = "";

  if (data.archivo_planilla != "") {
    planilla = `
    <div class="col mb-3">
        <div class="d-flex align-items-start gap-3 border p-3 rounded">
            <div class="detail-icon fs-5">
                <i class="bi bi-file-earmark-binary-fill"></i>
            </div>
            <div class="detail-info">
                <h6 class="fw-bold mb-1">R01</h6>
                <a href="${url_servidor}archivos/pdt/${data.archivo_planilla}" target="_blank" class="mb-0">Ver Archivo</a>
            </div>
        </div>
    </div>
    `;
  }

  if (data.archivo_honorarios != "") {
    r12 = `
    <div class="col mb-3">
        <div class="d-flex align-items-start gap-3 border p-3 rounded">
            <div class="detail-icon fs-5">
                <i class="bi bi-file-earmark-code"></i>
            </div>
            <div class="detail-info">
                <h6 class="fw-bold mb-1">R12</h6>
                <a href="${url_servidor}archivos/pdt/${data.archivo_honorarios}" target="_blank" class="mb-0">Ver Archivo</a>
            </div>
        </div>
    </div>
    `;
  }

  if (data.archivo_constancia != "") {
    constancia = `
    <div class="col mb-3">
        <div class="d-flex align-items-start gap-3 border p-3 rounded">
            <div class="detail-icon fs-5">
                <i class="bi bi-card-text"></i>
            </div>
            <div class="detail-info">
                <h6 class="fw-bold mb-1">Constancia</h6>
                <a href="${url_servidor}archivos/pdt/${data.archivo_constancia}" target="_blank" class="mb-0">Ver Archivo</a>
            </div>
        </div>
    </div>
    `;
  }

  let boletas = data.r08_data;

  let boletas_pago = "";

  if (boletas.length != 0) {
    let htmlBoletas = "";

    let descargar_boleta = data.file_sello_firma;
    let hidden_descargar_boleta = "";

    if (descargar_boleta == "") {
      hidden_descargar_boleta = `hidden`;
    }

    boletas.forEach((bol) => {
      htmlBoletas += `
        <div class="col-md-4 mb-3 container-job">
            <div class="d-flex align-items-start gap-3 border p-3 rounded">
                <div class="detail-icon fs-2">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                </div>
                <div class="detail-info detail-job">
                    <h6 class="fw-bold mb-1 nombre_trabajador">${bol.nombres}</h6>
                    <h6 class="numero_documento">${bol.numero_documento}</h6>
                    <div class="d-flex gap-3">
                        <a href="${url_servidor}api/descargar-boleta/${bol.id}/${numero_doc.value}" class="mb-0" ${hidden_descargar_boleta} target="_blank">Descargar</a>
                        <a href="${url_servidor}archivos/pdt/${bol.nameFile}" class="mb-0" target="_blank">Previsualizar</a>
                    </div>
                </div>
            </div>
        </div>
        `;
    });

    boletas_pago = `
    <div class="col-md-12">
        <h5 class="mt-4">Boletas de Pagos</h5>
        <hr>
    </div>

    <div class="col-md-12 mb-3">
        <div class="position-relative">
            <input class="form-control px-5" type="search" placeholder="Buscar por nombre o numero de documento" onkeyup="searchJob(event)">
            <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
        </div>
    </div>

    ${htmlBoletas}
    `;
  }

  let plame = `
    <h4 class="text-center mt-2 mb-3">Resultados</h4>
    ${planilla}

    ${r12}

    ${constancia}

    ${boletas_pago}
    `;

  tableConsulta.innerHTML = plame;
}

function searchJob(e) {
  const filtro = e.target.value.toLowerCase();
  const items = document.querySelectorAll("#tableConsulta .detail-job");

  if (filtro.length < 3) {
    items.forEach((item) => {
      const container = item.closest(".container-job");
      container.style.display = "";
    });
    return;
  }

  items.forEach((item) => {
    const nombre = item
      .querySelector(".nombre_trabajador")
      .textContent.toLowerCase();
    const documento = item
      .querySelector(".numero_documento")
      .textContent.toLowerCase();

    const container = item.closest(".container-job");

    if (nombre.includes(filtro) || documento.includes(filtro)) {
      container.style.display = "";
      console.log(nombre, "si");
    } else {
      container.style.display = "none";
      console.log(nombre, "no");
    }
  });
}
