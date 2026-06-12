function pdtRenta() {
  window.location.href = base_url + "pdt-renta";
}

function pdtPlame() {
  window.location.href = base_url + "pdt-plame";
}

function pdtAnual() {
  window.location.href = base_url + "pdt-anual";
}

// ========================
// Elementos del DOM
// ========================
const pdtanual = document.getElementById("pdtanual");
const year = document.getElementById("year");
const tableMovimientos = document.getElementById("tableMovimientos");

// ========================
// Verificar PDT anual
// ========================
verificarPdtAnual();

async function verificarPdtAnual() {
  try {
    const res = await fetch(`${base_url}verificar-pdt-anual`);
    const data = await res.json();

    if (data.data && data.data.length !== 0) {
      pdtanual.removeAttribute("hidden");
    }
  } catch (error) {
    console.error("Error al verificar PDT anual:", error);
  }
}

// ========================
// Obtener años
// ========================
obtenerAnios();

async function obtenerAnios() {
  try {
    const res = await fetch(`${base_url}getAniosAll`);

    if (!res.ok) {
      throw new Error(`HTTP error: ${res.status}`);
    }

    const data = await res.json();
    const datos = data.data;

    if (datos && datos.length !== 0) {
      let html = `<option value="">Seleccione año</option>`;

      datos.forEach((item) => {
        html += `<option value="${item.id_anio}">${item.anio_descripcion}</option>`;
      });

      year.innerHTML = html;

      // Cargar movimientos del primer año
      year.value = datos[0].id_anio;
      obtenerMovimientos();
    }
  } catch (error) {
    console.error("Error al obtener años:", error);
  }
}

// ========================
// Obtener movimientos
// ========================
async function obtenerMovimientos() {
  if (!year.value) return;

  try {
    const res = await fetch(
      `${base_url}obtener-analisis-movimientos/${year.value}`,
    );

    if (!res.ok) {
      throw new Error(`HTTP error: ${res.status}`);
    }

    const data = await res.json();

    if (data.data.length != 0) {
      if (Number(year.value) >= 2026) {
        console.log("Año 2026 o superior, verificar AFP:", data.afp);
        if (data.afp === "si") {
          document.getElementById("planilla").removeAttribute("hidden");
        } else {
          document.getElementById("planilla").setAttribute("hidden", "hidden");
        }
      } else {
        console.log("Año menor a 2026, ocultar columna Planilla");
        // Si el año es menor a 2026, aseguramos ocultar la columna
        document.getElementById("planilla").setAttribute("hidden", "hidden");
      }

      viewMovimientos(data.data, data.afp);
    } else {
      const cols = Number(year.value) >= 2026 && data.afp === "si" ? 6 : 5;
      tableMovimientos.innerHTML = `
      <tr>
        <td colspan="${cols}" class="text-center">No hay Resultados</td>
      </tr>
      `;
    }
  } catch (error) {
    console.error("Error al obtener movimientos:", error);
  }
}

function viewMovimientos(datos, afp) {
  let html = "";

  let ventas_gravadas = 0;
  let ventas_no_gravadas = 0;
  let compras_gravadas = 0;
  let compras_no_gravadas = 0;
  let total_r1 = 0;

  datos.forEach((mov) => {
    ventas_gravadas += parseFloat(
      mov.ventas_gravadas_decimal.replace(/,/g, ""),
    );
    ventas_no_gravadas += parseFloat(
      mov.ventas_no_gravadas_decimal.replace(/,/g, ""),
    );
    compras_gravadas += parseFloat(
      mov.compras_gravadas_decimal.replace(/,/g, ""),
    );
    compras_no_gravadas += parseFloat(
      mov.compras_no_gravadas_decimal.replace(/,/g, ""),
    );
    if (afp === "si" && mov.total_r1) {
      total_r1 += parseFloat(String(mov.total_r1).replace(/,/g, "")) || 0;
    }

    html += `
    <tr>
      <td>${mov.mes_descripcion}</td>
      <td>${mov.ventas_gravadas_decimal}</td>
      <td>${mov.ventas_no_gravadas_decimal}</td>
      <td>${mov.compras_gravadas_decimal}</td>
      <td>${mov.compras_no_gravadas_decimal}</td>
      ${afp === "si" ? `<td>${mov.total_r1}</td>` : ""}
    </tr>
    `;
  });

  html += `
    <tr>
      <td><strong>Total</strong></td>
      <td><strong>${ventas_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      <td><strong>${ventas_no_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      <td><strong>${compras_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      <td><strong>${compras_no_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      ${afp === "si" ? `<td><strong>${total_r1.toLocaleString("es-PE", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong></td>` : ""}
    </tr>
  `;

  tableMovimientos.innerHTML = html;
}

// ========================
// Evento cambio de año
// ========================
year.addEventListener("change", () => {
  obtenerMovimientos();
});

function descargarExcel() {
  const anio = year.options[year.selectedIndex].text;
  const tabla = document.getElementById("tableAnalisisMovimientos");

  function loadExcelJSScript() {
    return new Promise((resolve, reject) => {
      if (window.ExcelJS && typeof window.ExcelJS.Workbook !== "undefined") {
        return resolve();
      }

      const urls = [
        "https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js",
      ];
      let idx = 0;

      function tryLoad() {
        if (window.ExcelJS && typeof window.ExcelJS.Workbook !== "undefined") {
          return resolve();
        }
        if (idx >= urls.length) {
          return reject(new Error("Failed to load ExcelJS from CDNs"));
        }

        const s = document.createElement("script");
        s.src = urls[idx++];
        s.onload = () => {
          setTimeout(() => {
            if (
              window.ExcelJS &&
              typeof window.ExcelJS.Workbook !== "undefined"
            ) {
              return resolve();
            }
            tryLoad();
          }, 100);
        };
        s.onerror = tryLoad;
        document.head.appendChild(s);
      }

      tryLoad();
    });
  }

  function fallbackHtmlXls() {
    const style = `
      <style>
        table { border-collapse: collapse; }
        table, th, td { border: 1px solid #000; }
        th { font-weight: bold; background-color: #f2f2f2; text-align: center; }
        td { padding: 4px; }
        tr:last-child td { font-weight: bold; background-color: #f9f9f9; }
      </style>
    `;
    const html = `<!DOCTYPE html><html><head><meta charset="utf-8"/>${style}</head><body><table>${tabla.innerHTML}</table></body></html>`;
    const blob = new Blob([html], { type: "application/vnd.ms-excel" });
    const filename = "analisis_movimiento_" + anio + ".xls";
    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }

  function exportWithExcelJS() {
    try {
      const workbook = new ExcelJS.Workbook();
      const ws = workbook.addWorksheet("Analisis Movimiento " + anio);

      const trs = Array.from(tabla.querySelectorAll("tr"));
      const lastRowIndex = trs.length - 1;

      function parseExcelNumber(text) {
        const value = text.trim();
        if (value === "") return NaN;
        const hasDot = value.indexOf(".") !== -1;
        const hasComma = value.indexOf(",") !== -1;

        let normalized = value;
        if (hasDot && hasComma) {
          const lastDot = value.lastIndexOf(".");
          const lastComma = value.lastIndexOf(",");
          if (lastComma > lastDot) {
            normalized = value.replace(/\./g, "").replace(",", ".");
          } else {
            normalized = value.replace(/,/g, "");
          }
        } else if (hasComma) {
          normalized = value.replace(/,/g, ".");
        }

        normalized = normalized.replace(/[^0-9.-]/g, "");
        return normalized === "" ? NaN : Number(normalized);
      }

      trs.forEach((tr, rowIndex) => {
        const cells = Array.from(tr.children);
        const rowValues = cells.map((td) => td.textContent.trim());
        const row = ws.addRow(rowValues);

        row.eachCell({ includeEmpty: true }, (cell) => {
          cell.border = {
            top: { style: "thin" },
            left: { style: "thin" },
            bottom: { style: "thin" },
            right: { style: "thin" },
          };

          if (rowIndex === 0 || rowIndex === lastRowIndex) {
            cell.font = Object.assign({}, cell.font, { bold: true });
          }
          if (rowIndex === 0) {
            cell.alignment = { vertical: "middle", horizontal: "center" };
          }
          if (rowIndex === lastRowIndex) {
            cell.fill = {
              type: "pattern",
              pattern: "solid",
              fgColor: { argb: "FFF9F9F9" },
            };
          }

          if (typeof cell.value === "string") {
            const numericValue = parseExcelNumber(cell.value);
            if (!isNaN(numericValue)) {
              cell.value = numericValue;
              cell.numFmt = "#,##0.00";
              cell.alignment = { horizontal: "right" };
            }
          }
        });
      });

      ws.columns.forEach((col) => {
        let maxLength = 10;
        col.eachCell({ includeEmpty: true }, (cell) => {
          const text = cell.value ? String(cell.value) : "";
          if (text.length > maxLength) maxLength = text.length;
        });
        col.width = Math.min(Math.max(maxLength + 2, 10), 40);
      });

      workbook.xlsx
        .writeBuffer()
        .then((buffer) => {
          const blob = new Blob([buffer], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
          });
          const filename = "analisis_movimiento_" + anio + ".xlsx";
          const link = document.createElement("a");
          link.href = URL.createObjectURL(blob);
          link.download = filename;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        })
        .catch((err) => {
          console.error("writeBuffer failed:", err);
          fallbackHtmlXls();
        });
    } catch (err) {
      console.error("ExcelJS export failed:", err);
      fallbackHtmlXls();
    }
  }

  loadExcelJSScript()
    .then(exportWithExcelJS)
    .catch((err) => {
      console.warn("Could not load ExcelJS, using HTML .xls fallback:", err);
      fallbackHtmlXls();
    });
}

// ========================
// Lanzar modal al cargar
// ========================
document.addEventListener("DOMContentLoaded", () => {
  verifyCorreo();
});

function verifyCorreo() {
  fetch(`${base_url}verify-correo`)
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "warning") {
        const modalCorreo = new bootstrap.Modal(
          document.getElementById("modalCorreo"),
        );
        modalCorreo.show();
      }
    });
}

const formCorreo = document.getElementById("formCorreo");
formCorreo.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData(formCorreo);
  fetch(`${base_url}save-correo`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const modalCorreo = bootstrap.Modal.getInstance(
          document.getElementById("modalCorreo"),
        );
        modalCorreo.hide();

        alert(data.message);
      } else {
        alert(data.message);
      }
    });
});
