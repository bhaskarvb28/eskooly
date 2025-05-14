function initlibraryPage() {
  const tableBody = document.getElementById("table-values");
  const searchInput = document.querySelector(".search");
  const paginationDiv = document.querySelector(".pagination");

  let currentPage = 1;
  let currentQuery = "";

  function fetchMembers(query = "", page = 1) {
    fetch(
      `pages/library/searchMembers.php?query=${encodeURIComponent(
        query
      )}&page=${page}`
    )
      .then((res) => {
        if (!res.ok) {
          throw new Error(`Server returned ${res.status}`);
        }
        // **THIS** actually reads the body as text
        return res.text();
      })
      .then((text) => {
        // console.log("Raw response body:", text);
        // now try to parse it
        try {
          const data = JSON.parse(text);
          if (data.error) throw new Error(data.error);

          currentPage = data.page;
          currentQuery = data.query;
          //   console.log(data.data);
          renderTable(data.data);
          renderPagination(data.page, data.totalPages);
        } catch (e) {
          console.error("Failed to parse JSON:", e.message);
        }
      })
      .catch((err) => {
        console.error("Fetch error:", err.message);
      });
  }

  function renderTable(rows) {
    tableBody.innerHTML = "";

    if (rows.length == 0 && searchInput.value == "") {
      tableBody.innerHTML = `<tr><td colspan="10">No Members Added yet</td></tr>`;
    } else if (rows.length === 0) {
      tableBody.innerHTML = `<tr><td colspan="10">No results found.</td></tr>`;
      return;
    }

    for (const row of rows) {
      const tr = document.createElement("tr");

      tr.innerHTML = `
                    <td>${row.memberName}</td>
                    <td>
                        ${(() => {
                          switch (row.memberType) {
                            case 1:
                              return "Admin";
                            case 2:
                              return "Teacher";
                            case 3:
                              return "Student";
                            default:
                              return row.memberType; // If no match, return the original value
                          }
                        })()}
                    </td>
                    <td>${row.memberId}</td>
                    <td>${row.memberEmail}</td>
                    <td>${row.phone}</td>
                    <td>
                        <button class="dropdown-btn" onclick="cancelMembership(${
                          row.memberId
                        })">Cancel Membership</button>
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
      prev.onclick = () => fetchMembers(currentQuery, current - 1);
    } else {
      prev.classList.add("disabled");
    }

    const next = document.createElement("a");
    next.innerText = "Next";
    if (current < total) {
      next.href = "#";
      next.onclick = () => fetchMembers(currentQuery, current + 1);
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
    fetchMembers(query, 1);
  });

  //   // Initial fetch
  fetchMembers();
}

initlibraryPage();
