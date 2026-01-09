const fileInput = document.getElementById("fancy-file-upload");
const previewContainer = document.getElementById("previewContainer");
const previewImage = document.getElementById("previewImage");
const btnGuardar = document.getElementById("btnGuardar");

const formSelloFirma = document.getElementById("formSelloFirma");

// Cuando seleccionas una imagen
fileInput.addEventListener("change", function () {
  const file = this.files[0];

  if (!file) return;

  // Validar solo PNG
  if (file.type !== "image/png") {
    alert("Solo se permiten imágenes en formato PNG");
    this.value = "";
    previewContainer.classList.add("d-none");
    btnGuardar.disabled = true;
    return;
  }

  const reader = new FileReader();

  reader.onload = function (e) {
    previewImage.src = e.target.result;
    previewContainer.classList.remove("d-none");
    btnGuardar.disabled = false;
  };

  reader.readAsDataURL(file);
});

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

loadImagenSelloFirma();

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
