function initSyllabusPage() {
  const tableBody = document.getElementById("table-values");
  const searchInput = document.querySelector(".search");
  const paginationDiv = document.querySelector(".pagination");

  let currentPage = 1;
  let currentQuery = "";

  function fetchSyllabus(query = "", page = 1) {
    fetch(
      `pages/syllabus/syllabusSearch.php?query=${encodeURIComponent(
        query
      )}&page=${page}`
    )
      .then((res) => res.json())
      .then((data) => {
        currentPage = data.page;
        currentQuery = data.query;
        renderTable(data.data);
        renderPagination(data.page, data.totalPages);
      })
      .catch(console.error);
  }

  function renderTable(rows) {
    tableBody.innerHTML = "";

    if (rows.length == 0 && searchInput.value == "") {
      tableBody.innerHTML = `<tr><td colspan="10">No Syllabus Uploaded yet</td></tr>`;
    } else if (rows.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="10">No results found.</td></tr>`;
      return;
    }

    for (const row of rows) {
      const tr = document.createElement("tr");

      tr.innerHTML = `
              <td>${row.content_title}</td>
              <td>${row.content_type}</td>
              <td>${new Date(row.update_date).toLocaleDateString()}</td>
              <td>${row.available_for}</td>
              <td>${row.class}</td>
              <td>${row.section}</td>
              <td>${row.description}</td>
              <td>${row.created_by}</td>
              <td>${row.status}</td>
              <td>
                  <div class="dropdown">
                      <button class="dropdown-btn">Select</button>
                      <div class="dropdown-content">
                          <button class="dropdown-item" onclick="deleteEntry(${
                            row.id
                          })">Delete</button>
                          <button class="dropdown-item" onclick="window.location.href='./dependencies/download.php?id=${
                            row.id
                          }'">Download</button>
                      </div>
                  </div>
              </td>
          `;
      tableBody.appendChild(tr);
    }
  }

  function renderPagination(current, total) {
    paginationDiv.innerHTML = "";

    const prev = document.createElement("a");
    prev.innerText = "Previous";
    if (current > 1) {
      prev.href = "#";
      prev.onclick = () => fetchSyllabus(currentQuery, current - 1);
    } else {
      prev.classList.add("disabled");
    }

    const next = document.createElement("a");
    next.innerText = "Next";
    if (current < total) {
      next.href = "#";
      next.onclick = () => fetchSyllabus(currentQuery, current + 1);
    } else {
      next.classList.add("disabled");
    }

    const pageInfo = document.createElement("span");
    pageInfo.innerText = ` ${current} of ${total} `;

    paginationDiv.appendChild(prev);
    paginationDiv.appendChild(pageInfo);
    paginationDiv.appendChild(next);
  }

  // Event listener for search
  searchInput.addEventListener("input", () => {
    const query = searchInput.value.trim();
    fetchSyllabus(query, 1);
  });

  // Initial fetch
  fetchSyllabus();
}

initSyllabusPage();
