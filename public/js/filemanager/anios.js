window.addEventListener("load", function () {
  createVerifyYear();
});

const container = document.getElementById("foldersFirst");
const spinner = document.getElementById("spinner-folder");

function createVerifyYear() {
  spinner.textContent = `Cargando, espere por favor...`;
  fetch(`${base_url}/filemanager/verify-year`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "error") {
        alert(data.message);
        return false;
      }

      listFolders();
    });
}

function listFolders() {
  const formData = new FormData();
  formData.append("folderParentId", "0");

  fetch(`${base_url}/foldersAll`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "error") {
        alert(data.message);
        return false;
      }
      spinner.textContent = "";
      renderFolders(data.folders);
    });
}

function renderFolders(folders) {
  container.innerHTML = "";

  let html = "";

  folders.forEach((folder) => {
    html += `
    <div class="col folder cursor-pointer" data-id="${folder.id}">
        <div class=" d-flex align-items-start gap-3 border p-3 rounded file-item">
            <div class="detail-icon fs-3 text-warning">
                <i class="bi bi-folder-fill"></i>
            </div>
            <div class="detail-info">
                <p class="fw-bold mb-1">Carpeta</p>
                <p class="fw-bold mb-0">${folder.name}</p>
            </div>
        </div>
    </div>
    `;
  });

  container.innerHTML = html;
}

container.addEventListener("click", (e) => {
  if (e.target.closest(".folder")) {
    const folderId = e.target.closest(".folder").getAttribute("data-id");
    window.location.href = `${base_url}folders-months?folderId=${folderId}`;
  }
});
