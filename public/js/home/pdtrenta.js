const formConsulta = document.getElementById("formConsulta");
const tableConsulta = document.getElementById("tableConsulta");

formConsulta.addEventListener("submit", (e) => {
  e.preventDefault();

  tableConsulta.innerHTML = "";

  const formData = new FormData(formConsulta);

  fetch(`${base_url}consulta-pdt-renta`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        viewPdtRenta(data.data);
      } else {
        alert(data.message);
      }
    });
});

function viewPdtRenta(data) {
  let html = "";

  data.forEach((pdt, index) => {
    html += `
    <tr>
        <td>${index + 1}</td>
        <td>${pdt.anio_descripcion}</td>
        <td>${pdt.mes_descripcion}</td>
        <td> <a href="${url_servidor}archivos/pdt/${
      pdt.nombre_pdt
    }" target="_blank" class="text-white"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>PDT</a> </td>
        <td> <a href="${url_servidor}archivos/pdt/${
      pdt.nombre_constancia
    }" target="_blank" class="text-white"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>CONSTANCIA </a> </td>
    </tr>
    `;
  });

  let table = `
    <table class="table align-middle mb-0 table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>AÑO</th>
                <th>MES</th>
                <th>PDT</th>
                <th>CONSTANCIA</th>
            </tr>
        </thead>
        <tbody>
        ${html}
        </tbody>
    </table>
    `;

  tableConsulta.innerHTML = table;
}

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
