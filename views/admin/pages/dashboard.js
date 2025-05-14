// dashboard.js
if (typeof Chart === "undefined") {
  const script = document.createElement("script");
  script.src = "https://cdn.jsdelivr.net/npm/chart.js";
  script.onload = () => {
    renderChart(); // Only run your chart code after Chart.js is loaded
  };
  document.head.appendChild(script);
} else {
  renderChart();
}

function renderChart() {
  const ctx = document.getElementById("incomeChart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["01", "02", "03", "04", "05"],
      datasets: [
        {
          label: "Income",
          data: [0, 0, 0, 0, 16200],
          backgroundColor: "rgba(54, 162, 235, 0.6)",
        },
        {
          label: "Expenses",
          data: [0, 0, 0, 0, 5000],
          backgroundColor: "rgba(255, 99, 132, 0.6)",
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
