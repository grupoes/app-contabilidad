const folderNew = document.getElementById("folderNew");
const uploadFile = document.getElementById("uploadFile");
const formNewFolder = document.getElementById("formNewFolder");
const folderId = document.getElementById("folderId");

const listFoldersFiles = document.getElementById("listFoldersFiles");

loadFoldersFiles();

folderNew.addEventListener("click", () => {
  const modalFolder = new bootstrap.Modal(
    document.getElementById("modalFolder"),
    {
      keyboard: false,
    },
  );
  modalFolder.show();
});

uploadFile.addEventListener("click", () => {
  const modalUpload = new bootstrap.Modal(
    document.getElementById("modalUploadFile"),
    {
      keyboard: false,
    },
  );
  modalUpload.show();
});

formNewFolder.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData(formNewFolder);
  fetch(`${base_url}create-folder`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "error") {
        alert(data.message);
        return false;
      }

      loadFoldersFiles();
    });
});

function loadFoldersFiles() {
  fetch(`${base_url}foldersFiles/${folderId.value}`)
    .then((res) => res.json())
    .then((data) => {
      viewFoldersFiles(data.foldersFiles);
    });
}

function viewFoldersFiles(foldersFiles) {
  let html = "";
  foldersFiles.forEach((item) => {
    switch (item.mimeType) {
      case "application/vnd.google-apps.folder":
        html += `
            <div class="col">
                <div class="folder d-flex align-items-center gap-3 border p-3 rounded file-item cursor-pointer" data-id="${item.id}">
                    <div class="detail-icon fs-3 text-warning">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                    <div class="detail-info">
                        <p class="fw-bold mb-0">${item.name}</p>
                    </div>
                </div>
            </div>
        `;
        break;
      case "image/png":
      case "image/jpeg":
      case "image/jpg":
        html += viewFile(item.id, item.name, "bi bi-image-fill");
        break;
      case "application/pdf":
        html += viewFile(item.id, item.name, "bi bi-file-earmark-pdf-fill");
        break;
      case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        html += viewFile(item.id, item.name, "bi bi-file-earmark-word-fill");
        break;
      case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
        html += viewFile(item.id, item.name, "bi bi-file-earmark-excel-fill");
        break;
      case "application/x-zip-compressed":
        html += viewFile(item.id, item.name, "bi bi-file-zip-fill");
        break;
      case "application/x-rar":
        html += viewFile(item.id, item.name, "bi bi-file-zip-fill");
        break;
      case "text/xml":
        html += viewFile(item.id, item.name, "bi bi-filetype-xml");
        break;
      case "image/svg+xml":
        html += viewFile(item.id, item.name, "bi bi-filetype-svg");
        break;
      case "video/mp4":
        html += viewFile(item.id, item.name, "bi bi-camera-video-fill");
        break;
      case "audio/mpeg":
      case "audio/ogg":
        html += viewFile(item.id, item.name, "bi bi-mic-fill");
        break;
    }
  });
  listFoldersFiles.innerHTML = html;
}

function viewFile(id, name, icono) {
  return `
    <div class="col file" data-id="${id}">
        <div class="d-flex align-items-center gap-3 border p-3 rounded file-item cursor-pointer">
            <div class="detail-icon fs-3 text-primary">
                <i class="${icono}"></i>
            </div>
            <div class="detail-info">
                <p class="fw-bold mb-0">${name}</p>
            </div>
        </div>
    </div>
    
    `;
}

listFoldersFiles.addEventListener("click", (e) => {
  if (e.target.closest(".folder")) {
    const folderId = e.target.closest(".folder").getAttribute("data-id");
    window.location.href = `${base_url}folders?folderId=${folderId}`;
  }
});
