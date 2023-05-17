var ctx2 = document.getElementById("line-chart").getContext("2d");

new Chart(ctx2, {
  type: "line",
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July"],
    datasets: [
      {
        label: "Registered",
        tension: 0,
        borderWidth: 0,
        pointRadius: 5,
        pointBackgroundColor: "rgba(255, 255, 255, .8)",
        pointBorderColor: "transparent",
        borderColor: "rgba(255, 255, 255, .8)",
        borderColor: "rgba(255, 255, 255, .8)",
        borderWidth: 4,
        backgroundColor: "transparent",
        fill: true,
        data: [0, 10, 5, 2, 20, 30, 45],
        maxBarThickness: 6,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
    },
    interaction: {
      intersect: false,
      mode: "index",
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: "rgba(255, 255, 255, .2)",
        },
        ticks: {
          display: true,
          color: "#f8f9fa",
          padding: 10,
          font: {
            size: 13,
            weight: 300,
            family: "Roboto",
            style: "normal",
            lineHeight: 2,
          },
        },
      },
      x: {
        grid: {
          drawBorder: false,
          display: false,
          drawOnChartArea: false,
          drawTicks: false,
          borderDash: [5, 5],
        },
        ticks: {
          display: true,
          color: "#f8f9fa",
          padding: 10,
          font: {
            size: 9,
            weight: 300,
            family: "Roboto",
            style: "normal",
            lineHeight: 2,
          },
        },
      },
    },
  },
});

var ctx = document.getElementById("bar-chart").getContext("2d");

new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["Sun", "Mon", "Tue", "Wen", "Thu", "Fri", "Sat"],
    datasets: [
      {
        label: "Schedule",
        tension: 0.4,
        borderWidth: 0,
        borderRadius: 4,
        borderSkipped: false,
        backgroundColor: "rgba(255, 255, 255, .8)",
        data: [1, 5, 3, 5, 3, 6, 3],
        maxBarThickness: 6,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      },
    },
    interaction: {
      intersect: false,
      mode: "index",
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: "rgba(255, 255, 255, .2)",
        },
        ticks: {
          suggestedMin: 0,
          suggestedMax: 500,
          beginAtZero: true,
          padding: 10,
          font: {
            size: 14,
            weight: 300,
            family: "Roboto",
            style: "normal",
            lineHeight: 2,
          },
          color: "#fff",
        },
      },
      x: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: "rgba(255, 255, 255, .2)",
        },
        ticks: {
          display: true,
          color: "#f8f9fa",
          padding: 10,
          font: {
            size: 14,
            weight: 300,
            family: "Roboto",
            style: "normal",
            lineHeight: 2,
          },
        },
      },
    },
  },
});
