const input = document.getElementById("fancy-file-upload");
const canvas = document.getElementById("canvasPreview");
const ctx = canvas.getContext("2d");
const previewContainer = document.getElementById("previewContainer");
const controlsContainer = document.getElementById("controlsContainer");
const range = document.getElementById("rangeUmbral");
const valor = document.getElementById("valorUmbral");
//const previewImage = document.getElementById("previewImage");
const btnGuardar = document.getElementById("btnGuardar");

const formSelloFirma = document.getElementById("formSelloFirma");

let imagenOriginal = null;

// Mostrar valor
range.addEventListener("input", () => {
  valor.innerText = range.value;
  if (imagenOriginal) procesarImagen();
});

// Cargar imagen
input.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const img = new Image();
  img.onload = function () {
    canvas.width = img.width;
    canvas.height = img.height;
    ctx.drawImage(img, 0, 0);
    imagenOriginal = img;

    // Mostrar UI
    previewContainer.classList.remove("d-none");
    controlsContainer.classList.remove("d-none");
    btnGuardar.disabled = false;

    // Detectar umbral automáticamente
    const umbralDetectado = detectarUmbral();
    range.value = umbralDetectado;
    valor.innerText = umbralDetectado;

    procesarImagen();
  };
  img.src = URL.createObjectURL(file);
});

// 🧠 Detecta un umbral inicial analizando el fondo
function detectarUmbral() {
  let imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  let data = imgData.data;

  let blancos = [];

  for (let i = 0; i < data.length; i += 4) {
    let r = data[i];
    let g = data[i + 1];
    let b = data[i + 2];
    let lum = (r + g + b) / 3;

    // Tomar solo píxeles muy claros (posible fondo)
    if (lum > 200) {
      blancos.push(lum);
    }
  }

  if (blancos.length === 0) return 140;

  // Promedio de blancos
  let promedio = blancos.reduce((a, b) => a + b, 0) / blancos.length;

  // Ajuste automático
  let umbral = Math.floor(promedio - 10);
  return Math.min(220, Math.max(100, umbral));
}

// 🎨 Procesamiento en tiempo real
function procesarImagen() {
  ctx.drawImage(imagenOriginal, 0, 0);

  let imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  let data = imgData.data;
  let umbral = parseInt(range.value);

  for (let i = 0; i < data.length; i += 4) {
    let r = data[i];
    let g = data[i + 1];
    let b = data[i + 2];

    let lum = (r + g + b) / 3;

    // Fondo → transparente
    if (lum > umbral) {
      data[i + 3] = 0;
      continue;
    }

    // Detectar firma azul
    if (b > r + 15 && b > g + 15) {
      data[i + 3] = 255;
    } else {
      // Texto/sello → negro
      data[i] = 0;
      data[i + 1] = 0;
      data[i + 2] = 0;
      data[i + 3] = 255;
    }
  }

  ctx.putImageData(imgData, 0, 0);
}

formSelloFirma.addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(formSelloFirma);

  fetch("/configuracion/uploadSelloFirma", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        alert("Sello y firma subidos correctamente");
        // Opcional: limpiar el formulario
        formSelloFirma.reset();
        previewContainer.classList.add("d-none");
        btnGuardar.disabled = true;
      } else {
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Ocurrió un error al subir el sello y firma");
    });
});

//loadImagenSelloFirma();

function loadImagenSelloFirma() {
  fetch("/configuracion/getSelloFirma")
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        previewImage.src = data.link;
        previewContainer.classList.remove("d-none");
      } else {
        previewContainer.classList.add("d-none");
      }
    });
}
