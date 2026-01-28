window.addEventListener("load", function () {
  createVerify();
});

const folderId = document.getElementById("folderId");
const listMonths = document.getElementById("listMonths");

function createVerify() {
  fetch(`${base_url}foldersMonths/${folderId.value}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status == "error") {
        alert(data.message);
        return;
      }

      loadMonths();
    });
}

function loadMonths() {
  fetch(`${base_url}loadFolderMonths/${folderId.value}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status == "error") {
        alert(data.message);
        return;
      }

      viewLoadedMonths(data.foldersMonths);
    });
}

function viewLoadedMonths(foldersMonths) {
  let html = "";
  foldersMonths.forEach((month) => {
    html += `
            <div class="col folder cursor-pointer" data-id="${month.id}">
                <div class="d-flex align-items-center gap-3 border p-3 rounded file-item">
                    <div class="detail-icon fs-3 text-warning">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                    <div class="detail-info">
                        <p class="fw-bold mb-0">${month.name}</p>
                    </div>
                </div>
            </div>
        `;
  });

  listMonths.innerHTML = html;
}

listMonths.addEventListener("click", (e) => {
  if (e.target.closest(".folder")) {
    const folderId = e.target.closest(".folder").getAttribute("data-id");
    window.location.href = `${base_url}folders?folderId=${folderId}`;
  }
});
