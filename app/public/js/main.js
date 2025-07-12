// Main JavaScript File

// Initialize tooltips and popovers
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

  // Initialize form validation
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

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // Back to top button
  var backToTop = document.createElement("button");
  backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
  backToTop.className = "btn btn-primary btn-floating";
  backToTop.id = "back-to-top";
  backToTop.style.display = "none";
  document.body.appendChild(backToTop);

  window.addEventListener("scroll", function () {
    if (window.pageYOffset > 100) {
      backToTop.style.display = "flex";
    } else {
      backToTop.style.display = "none";
    }
  });

  backToTop.addEventListener("click", function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  // Navbar scroll behavior
  var navbar = document.querySelector(".navbar");
  var lastScrollTop = 0;

  window.addEventListener("scroll", function () {
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 100) {
      navbar.style.transform = "translateY(-100%)";
    } else {
      navbar.style.transform = "translateY(0)";
    }

    lastScrollTop = scrollTop;
  });

  // Add loading class to buttons when clicked
  document.querySelectorAll(".btn").forEach((button) => {
    button.addEventListener("click", function (e) {
      if (!this.classList.contains("no-loading") && !this.disabled) {
        const originalContent = this.innerHTML;
        this.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Loading...';
        this.disabled = true;

        // Reset button after 3 seconds if not handled by form submission
        setTimeout(() => {
          if (this.disabled) {
            this.innerHTML = originalContent;
            this.disabled = false;
          }
        }, 3000);
      }
    });
  });

  // Handle form submissions
  document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", function () {
      const submitButton = this.querySelector('button[type="submit"]');
      if (submitButton) {
        submitButton.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';
        submitButton.disabled = true;
      }
    });
  });

  // Image lazy loading
  document.querySelectorAll("img[data-src]").forEach((img) => {
    img.setAttribute("src", img.getAttribute("data-src"));
    img.onload = function () {
      img.removeAttribute("data-src");
    };
  });

  // Handle mobile menu
  const mobileMenuToggle = document.querySelector(".navbar-toggler");
  const mobileMenu = document.querySelector(".navbar-collapse");

  if (mobileMenuToggle && mobileMenu) {
    document.addEventListener("click", function (e) {
      if (
        !mobileMenu.contains(e.target) &&
        !mobileMenuToggle.contains(e.target) &&
        mobileMenu.classList.contains("show")
      ) {
        mobileMenuToggle.click();
      }
    });

    // Close mobile menu when clicking on a link
    mobileMenu.querySelectorAll(".nav-link").forEach((link) => {
      link.addEventListener("click", () => {
        if (mobileMenu.classList.contains("show")) {
          mobileMenuToggle.click();
        }
      });
    });
  }

  // Handle dropdowns
  document.querySelectorAll(".dropdown").forEach((dropdown) => {
    const toggle = dropdown.querySelector(".dropdown-toggle");
    const menu = dropdown.querySelector(".dropdown-menu");

    if (toggle && menu) {
      // Close dropdown when clicking outside
      document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target) && menu.classList.contains("show")) {
          toggle.click();
        }
      });

      // Close dropdown when pressing escape
      document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && menu.classList.contains("show")) {
          toggle.click();
        }
      });
    }
  });

  // Handle alerts
  document.querySelectorAll(".alert").forEach((alert) => {
    if (!alert.classList.contains("alert-permanent")) {
      setTimeout(() => {
        alert.style.opacity = "0";
        setTimeout(() => {
          alert.remove();
        }, 300);
      }, 5000);
    }

    const closeButton = alert.querySelector(".btn-close");
    if (closeButton) {
      closeButton.addEventListener("click", () => {
        alert.style.opacity = "0";
        setTimeout(() => {
          alert.remove();
        }, 300);
      });
    }
  });

  // Handle file inputs
  document.querySelectorAll(".custom-file-input").forEach((input) => {
    input.addEventListener("change", function (e) {
      let fileName = "";
      if (this.files && this.files.length > 1) {
        fileName = `${this.files.length} files selected`;
      } else {
        fileName = e.target.value.split("\\").pop();
      }
      if (fileName) {
        let label = this.nextElementSibling;
        if (label) {
          label.innerHTML = fileName;
        }
      }
    });
  });

  // Handle password toggle
  document.querySelectorAll(".password-toggle").forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      e.preventDefault();
      const input = document.querySelector(this.dataset.target);
      if (input) {
        const type = input.getAttribute("type");
        input.setAttribute("type", type === "password" ? "text" : "password");
        this.querySelector("i").classList.toggle("fa-eye");
        this.querySelector("i").classList.toggle("fa-eye-slash");
      }
    });
  });

  // Handle modals
  document.querySelectorAll(".modal").forEach((modal) => {
    modal.addEventListener("show.bs.modal", function () {
      document.body.style.overflow = "hidden";
    });

    modal.addEventListener("hidden.bs.modal", function () {
      document.body.style.overflow = "";
    });
  });
});

