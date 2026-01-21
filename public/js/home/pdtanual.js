const tipoPdt = document.getElementById("tipoPdt");
const anio = document.getElementById("anio");

const formConsulta = document.getElementById("formConsulta");
const tableConsulta = document.getElementById("tableConsulta");

obtenerPdtAnual();
obtenerAnios();

function obtenerPdtAnual() {
  fetch(`${base_url}verificar-pdt-anual`)
    .then((res) => res.json())
    .then((data) => {
      if (data.data.length != 0) {
        let html = `<option value="0">TODOS</option>`;

        const datos = data.data;

        datos.forEach((pdt) => {
          html += `<option value="${pdt.id_pdt}">${pdt.pdt_descripcion}</option>`;
        });

        tipoPdt.innerHTML = html;
      }
    });
}

function obtenerAnios() {
  fetch(`${base_url}getAniosAll`)
    .then((res) => res.json())
    .then((data) => {
      const datos = data.data;

      if (datos.length != 0) {
        let html = `<option value="">Seleccione...</option>`;

        datos.forEach((year) => {
          html += `<option value="${year.id_anio}">${year.anio_descripcion}</option>`;
        });

        anio.innerHTML = html;
      }
    });
}

formConsulta.addEventListener("submit", (e) => {
  e.preventDefault();

  const formData = new FormData(formConsulta);

  fetch(`${base_url}query-pdt-anual`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      const datos = data.data;

      if (datos.length == 0) {
        tableConsulta.innerHTML = "No hay datos para mostrar";
        return false;
      }

      viewPdtAnual(datos);
    });
});

function viewPdtAnual(datos) {
  let html = "";

  datos.forEach((pdt) => {
    html += `
    <tr>
        <td>${pdt.anio_descripcion}</td>
        <td>${pdt.pdt_descripcion}</td>
        <td>
            <a href="${url_servidor}archivos/pdt/${pdt.pdt}" target="_blank" class="btn btn-success">PDT</a>

            <a href="${url_servidor}archivos/pdt/${pdt.constancia}" target="_blank" class="btn btn-primary">CONSTANCIA</a>
        </td>
    </tr>
    `;
  });

  let table = `
    <table class="table align-middle mb-0 table-striped">
        <thead>
            <tr>
                <th>AÑO</th>
                <th>TIPO PDT</th>
                <th>ARCHIVOS</th>
            </tr>
        </thead>
        <tbody>
        ${html}
        </tbody>
    </table>
    `;

  tableConsulta.innerHTML = table;
}
