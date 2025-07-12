// Dashboard Initialization
document.addEventListener("DOMContentLoaded", function () {
  // Initialize tooltips
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Initialize popovers
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });

  // Auto-hide alerts after 5 seconds
  var alerts = document.querySelectorAll(".alert:not(.alert-permanent)");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      var bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });

  // Toggle sidebar on mobile
  var sidebarToggle = document.querySelector(".sidebar-toggle");
  if (sidebarToggle) {
    sidebarToggle.addEventListener("click", function (e) {
      e.preventDefault();
      document.body.classList.toggle("sidebar-collapsed");
    });
  }

  // Responsive tables
  var tables = document.querySelectorAll(".table");
  tables.forEach(function (table) {
    if (!table.parentElement.classList.contains("table-responsive")) {
      var wrapper = document.createElement("div");
      wrapper.classList.add("table-responsive");
      table.parentNode.insertBefore(wrapper, table);
      wrapper.appendChild(table);
    }
  });

  // Form validation
  var forms = document.querySelectorAll(".needs-validation");
  Array.prototype.slice.call(forms).forEach(function (form) {
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

  // Dynamic textarea height
  var textareas = document.querySelectorAll("textarea.auto-height");
  textareas.forEach(function (textarea) {
    textarea.addEventListener("input", function () {
      this.style.height = "auto";
      this.style.height = this.scrollHeight + "px";
    });
  });

  // File input preview
  var fileInputs = document.querySelectorAll(".custom-file-input");
  fileInputs.forEach(function (input) {
    input.addEventListener("change", function (e) {
      var fileName = e.target.files[0].name;
      var label = input.nextElementSibling;
      label.textContent = fileName;
    });
  });

  // Confirm delete actions
  var deleteButtons = document.querySelectorAll("[data-confirm]");
  deleteButtons.forEach(function (button) {
    button.addEventListener("click", function (e) {
      if (
        !confirm(
          this.dataset.confirm || "Apakah Anda yakin ingin menghapus item ini?"
        )
      ) {
        e.preventDefault();
      }
    });
  });

  // Toggle password visibility
  var passwordToggles = document.querySelectorAll(".password-toggle");
  passwordToggles.forEach(function (toggle) {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      var input = document.querySelector(this.dataset.target);
      if (input) {
        if (input.type === "password") {
          input.type = "text";
          this.querySelector("i").classList.replace("fa-eye", "fa-eye-slash");
        } else {
          input.type = "password";
          this.querySelector("i").classList.replace("fa-eye-slash", "fa-eye");
        }
      }
    });
  });

  // Handle back button
  var backButtons = document.querySelectorAll(".btn-back");
  backButtons.forEach(function (button) {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      window.history.back();
    });
  });

  // Print button
  var printButtons = document.querySelectorAll(".btn-print");
  printButtons.forEach(function (button) {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      window.print();
    });
  });

  // Refresh button
  var refreshButtons = document.querySelectorAll(".btn-refresh");
  refreshButtons.forEach(function (button) {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      location.reload();
    });
  });
});
