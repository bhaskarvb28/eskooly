function deleteCategory(id) {
  if (!confirm("Are you sure you want to delete this category?")) return;

  fetch(`pages/library/deleteCategory.php?id=${id}`)
    .then((res) => res.json())
    .then((data) => {
      alert(data.message);
      if (data.status === "success") {
        location.reload();
      }
    })
    .catch((err) => {
      console.error("Delete failed:", err);
      alert("Something went wrong while deleting.");
    });
}

function cancelMembership(id) {
  if (!confirm("Are you sure you want to cancel this membership?")) return;

  fetch(`pages/library/cancelMembership.php?id=${id}`)
    .then((res) => res.json())
    .then((data) => {
      alert(data.message);
      if (data.status === "success") {
        location.reload();
      }
    })
    .catch((err) => {
      console.error("Membership Cancelation Failed:", err);
      alert("Something went wrong while canceling membership.");
    });
}

// const mainContent = document.getElementById("main-content");
document.addEventListener("DOMContentLoaded", () => {
  const mainContent = document.getElementById("main-content");
  const navLinks = document.querySelectorAll(".sidebar nav a");
  const sidebar = document.querySelector(".sidebar");
  const overlay = document.getElementById("overlay");
  const toggleBtn1 = document.getElementById("toggle-btn-1");
  const toggleBtn2 = document.getElementById("toggle-btn-2");
  const topbar = document.querySelector(".topbar");

  document.querySelectorAll('[data-toggle="collapse"]').forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.classList.toggle("show");
      }
    });
  });

  async function loadPage(page) {
    try {
      const response = await fetch(`/eskooly/views/admin/pages/${page}`);
      if (!response.ok) throw new Error("Page not found");

      const content = await response.text();
      mainContent.innerHTML = content;

      const jsPath = `/eskooly/views/admin/pages/${page.replace(
        ".php",
        ".js"
      )}`;

      // Try loading the JS file
      const script = document.createElement("script");
      script.src = jsPath;
      script.onload = () => {
        console.log(`Loaded ${jsPath}`);
      };
      script.onerror = () => {
        // Suppress 404 error for missing JS
        console.info(`Optional JS not found: ${jsPath}`);
      };
      document.body.appendChild(script);

      // Close sidebar if on small screen
      if (window.innerWidth <= 768) {
        closeSidebar();
      }
    } catch (error) {
      mainContent.innerHTML = `<h2>Error</h2><p>Could not load the page "${page}".</p>`;
    }
  }

  //   function adjustIframeWidth() {
  //     const iframe = document.querySelector("iframe");

  //     if (sidebar.classList.contains("collapsed") || width <= 768) {
  //       mainContent.style.width = "100%";
  //     } else {
  //       const sidebarWidth = sidebar.offsetWidth;
  //       mainContent.style.width = `calc(100% - ${sidebarWidth}px)`;
  //     }
  //   }

  function closeSidebar() {
    sidebar.classList.remove("show");
    overlay.classList.remove("active");
    topbar.classList.add("show-topbar");
  }

  // Sidebar toggle on large screens
  toggleBtn1?.addEventListener("click", () => {
    if (window.innerWidth > 768) {
      sidebar.classList.toggle("collapsed");
    } else {
      sidebar.classList.add("collapsed");
      overlay.classList.remove("active");
    }
  });

  // Open sidebar on small screens
  toggleBtn2?.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
      topbar.classList.remove("show-topbar");
      sidebar.classList.add("show");
      sidebar.classList.remove("collapsed");
      overlay.classList.add("active");
    }
  });

  // Clicking overlay closes sidebar and shows topbar
  overlay?.addEventListener("click", () => {
    closeSidebar();
  });

  // Responsive sidebar and topbar behavior
  window.addEventListener("resize", () => {
    if (window.innerWidth > 768) {
      overlay.classList.remove("active");
      sidebar.classList.remove("collapsed", "show");
      topbar.classList.remove("show-topbar");
    } else {
      sidebar.classList.add("collapsed");
      sidebar.classList.remove("show");
      overlay.classList.remove("active");
      topbar.classList.add("show-topbar");
    }
  });

  // Nav link click handling
  navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const page = link.getAttribute("data-page");
      if (!page) return;

      loadPage(page);

      navLinks.forEach((l) => l.classList.remove("active"));
      link.classList.add("active");
    });
  });

  // function deleteEntry(id) {
  //   if (confirm("Are you sure you want to delete this entry?")) {
  //     const xhr = new XMLHttpRequest();
  //     xhr.open("GET", "./dependencies/delete.php?id=" + id, true);
  //     xhr.onload = function () {
  //       if (xhr.status === 200) {
  //         const response = JSON.parse(xhr.responseText);
  //         if (response.status === "success") {
  //           alert("Successfully deleted entry");
  //           location.reload();
  //         } else {
  //           alert(response.message);
  //         }
  //       } else {
  //         alert("Error deleting entry.");
  //       }
  //     };

  //     xhr.onerror = function () {
  //       alert("Request failed.");
  //     };

  //     xhr.send();
  //   }
  // }

  loadPage("dashboard.php");
});
