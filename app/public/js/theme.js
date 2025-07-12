// Theme Switcher
document.addEventListener("DOMContentLoaded", function () {
  // Check for saved theme preference
  const savedTheme = localStorage.getItem("theme") || "light";
  document.documentElement.setAttribute("data-theme", savedTheme);

  // Add theme toggle button to navbar if it doesn't exist
  if (!document.querySelector(".theme-toggle")) {
    const navbar = document.querySelector(".navbar-nav");
    if (navbar) {
      const themeToggle = document.createElement("li");
      themeToggle.className = "nav-item";
      themeToggle.innerHTML = `
                <button class="nav-link theme-toggle btn btn-link" type="button">
                    <i class="fas ${
                      savedTheme === "dark" ? "fa-sun" : "fa-moon"
                    }"></i>
                    <span class="ms-2 d-none d-lg-inline">${
                      savedTheme === "dark" ? "Mode Terang" : "Mode Gelap"
                    }</span>
                </button>
            `;
      navbar.appendChild(themeToggle);
    }
  }

  // Theme toggle functionality
  const themeToggle = document.querySelector(".theme-toggle");
  if (themeToggle) {
    themeToggle.addEventListener("click", function () {
      const currentTheme = document.documentElement.getAttribute("data-theme");
      const targetTheme = currentTheme === "light" ? "dark" : "light";

      // Update theme
      document.documentElement.setAttribute("data-theme", targetTheme);
      localStorage.setItem("theme", targetTheme);

      // Update toggle button
      const icon = this.querySelector("i");
      const text = this.querySelector("span");

      if (targetTheme === "dark") {
        icon.classList.replace("fa-moon", "fa-sun");
        if (text) text.textContent = "Mode Terang";
      } else {
        icon.classList.replace("fa-sun", "fa-moon");
        if (text) text.textContent = "Mode Gelap";
      }

      // Show toast notification
      showToast(
        `Mode ${targetTheme === "dark" ? "Gelap" : "Terang"} diaktifkan`
      );
    });
  }

  // Add theme class to body for transition effects
  document.body.classList.add("theme-transition");
  setTimeout(() => {
    document.body.classList.remove("theme-transition");
  }, 1000);
});

// Theme transition styles
const style = document.createElement("style");
style.textContent = `
    .theme-transition {
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .theme-transition * {
        transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
    }
`;
document.head.appendChild(style);

// Media query for system theme preference
const systemThemeQuery = window.matchMedia("(prefers-color-scheme: dark)");

// Function to handle system theme changes
function handleSystemThemeChange(e) {
  // Only apply system theme if no theme is saved
  if (!localStorage.getItem("theme")) {
    const theme = e.matches ? "dark" : "light";
    document.documentElement.setAttribute("data-theme", theme);

    // Update toggle button if it exists
    const themeToggle = document.querySelector(".theme-toggle");
    if (themeToggle) {
      const icon = themeToggle.querySelector("i");
      const text = themeToggle.querySelector("span");

      if (theme === "dark") {
        icon.classList.replace("fa-moon", "fa-sun");
        if (text) text.textContent = "Mode Terang";
      } else {
        icon.classList.replace("fa-sun", "fa-moon");
        if (text) text.textContent = "Mode Gelap";
      }
    }
  }
}

// Listen for system theme changes
systemThemeQuery.addListener(handleSystemThemeChange);

// Apply system theme on initial load if no theme is saved
if (!localStorage.getItem("theme")) {
  handleSystemThemeChange(systemThemeQuery);
}

// Function to get current theme
function getCurrentTheme() {
  return document.documentElement.getAttribute("data-theme");
}

// Function to set theme
function setTheme(theme) {
  if (theme !== "light" && theme !== "dark") return;

  document.documentElement.setAttribute("data-theme", theme);
  localStorage.setItem("theme", theme);

  // Update toggle button if it exists
  const themeToggle = document.querySelector(".theme-toggle");
  if (themeToggle) {
    const icon = themeToggle.querySelector("i");
    const text = themeToggle.querySelector("span");

    if (theme === "dark") {
      icon.classList.replace("fa-moon", "fa-sun");
      if (text) text.textContent = "Mode Terang";
    } else {
      icon.classList.replace("fa-sun", "fa-moon");
      if (text) text.textContent = "Mode Gelap";
    }
  }

  // Show toast notification
  showToast(`Mode ${theme === "dark" ? "Gelap" : "Terang"} diaktifkan`);
}

// Function to toggle theme
function toggleTheme() {
  const currentTheme = getCurrentTheme();
  setTheme(currentTheme === "light" ? "dark" : "light");
}

// Export theme functions
window.themeUtils = {
  getCurrentTheme,
  setTheme,
  toggleTheme,
};
