// Admin Dashboard JavaScript

document.addEventListener("DOMContentLoaded", function () {
  // Initialize any dropdowns
  const dropdownElementList = [].slice.call(
    document.querySelectorAll(".dropdown-toggle")
  );
  dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl);
  });

  // Auto-hide flash messages after 5 seconds
  const flashMessages = document.querySelectorAll(".alert-dismissible");
  if (flashMessages.length > 0) {
    setTimeout(function () {
      flashMessages.forEach(function (message) {
        const closeButton = message.querySelector(".btn-close");
        if (closeButton) {
          closeButton.click();
        }
      });
    }, 5000);
  }

  // Initialize DataTables
  if (typeof $.fn.DataTable !== "undefined") {
    const dataTables = document.querySelectorAll(".data-table");
    if (dataTables.length > 0) {
      dataTables.forEach(function (table) {
        $(table).DataTable({
          language: {
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            search: "Cari:",
            paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Selanjutnya",
              previous: "Sebelumnya",
            },
          },
        });
      });
    }
  }

  // Aktifkan menu navbar yang sedang aktif
  const currentUrl = window.location.href;
  const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

  navLinks.forEach(function (link) {
    const href = link.getAttribute("href");
    if (href && currentUrl.indexOf(href) !== -1) {
      // Jika ini bukan dropdown toggle dan bukan homepage
      if (
        !link.classList.contains("dropdown-toggle") &&
        href !== BASE_URL + "/"
      ) {
        link.classList.add("active");

        // Jika ini adalah submenu, aktifkan parent menu juga
        const parentDropdown = link.closest(".dropdown-menu");
        if (parentDropdown) {
          const dropdownToggle = parentDropdown.previousElementSibling;
          if (
            dropdownToggle &&
            dropdownToggle.classList.contains("dropdown-toggle")
          ) {
            dropdownToggle.classList.add("active");
          }
        }
      }
    }
  });

  // Initialize charts if Chart.js is available and canvas elements exist
  if (typeof Chart !== "undefined") {
    // Dashboard Chart - Example
    const ctxDashboard = document.getElementById("dashboardChart");
    if (ctxDashboard) {
      new Chart(ctxDashboard, {
        type: "line",
        data: {
          labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "Pemesanan",
              data: [10, 15, 12, 18, 24, 28, 32, 35, 30, 25, 20, 15],
              backgroundColor: "rgba(78, 115, 223, 0.05)",
              borderColor: "rgba(78, 115, 223, 1)",
              borderWidth: 2,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "#fff",
              pointBorderWidth: 2,
              pointRadius: 4,
              tension: 0.3,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                borderDash: [2],
                drawBorder: false,
                color: "rgba(0, 0, 0, 0.1)",
              },
              ticks: {
                padding: 10,
              },
            },
            x: {
              grid: {
                display: false,
                drawBorder: false,
              },
              ticks: {
                padding: 10,
              },
            },
          },
          plugins: {
            legend: {
              display: false,
            },
          },
        },
      });
    }

    // Revenue Chart - Example
    const ctxRevenue = document.getElementById("revenueChart");
    if (ctxRevenue) {
      new Chart(ctxRevenue, {
        type: "bar",
        data: {
          labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
          ],
          datasets: [
            {
              label: "Pendapatan",
              data: [
                5000000, 7500000, 6000000, 8500000, 10000000, 12000000,
                15000000, 17000000, 14000000, 12000000, 10000000, 9000000,
              ],
              backgroundColor: "rgba(28, 200, 138, 0.8)",
              borderColor: "rgba(28, 200, 138, 1)",
              borderWidth: 1,
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                borderDash: [2],
                drawBorder: false,
                color: "rgba(0, 0, 0, 0.1)",
              },
              ticks: {
                padding: 10,
                callback: function (value) {
                  return "Rp " + value.toLocaleString("id-ID");
                },
              },
            },
            x: {
              grid: {
                display: false,
                drawBorder: false,
              },
            },
          },
          plugins: {
            tooltip: {
              callbacks: {
                label: function (context) {
                  return "Rp " + context.parsed.y.toLocaleString("id-ID");
                },
              },
            },
          },
        },
      });
    }
  }

  // Handle form validation
  const forms = document.querySelectorAll(".needs-validation");
  Array.from(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });

  // Format currency inputs
  const currencyInputs = document.querySelectorAll(".currency-input");
  currencyInputs.forEach(function (input) {
    input.addEventListener("input", function (e) {
      // Remove non-numeric characters
      let value = this.value.replace(/[^0-9]/g, "");

      // Format with thousand separator
      if (value.length > 0) {
        value = parseInt(value, 10).toLocaleString("id-ID");
      }

      this.value = value;
    });
  });
});

