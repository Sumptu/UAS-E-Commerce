// Utility Functions

// Format currency to IDR
function formatRupiah(angka) {
  var number_string = angka.toString().replace(/[^,\d]/g, ""),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  return "Rp " + rupiah;
}

// Format date to Indonesian format
function formatTanggal(date) {
  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  return new Date(date).toLocaleDateString("id-ID", options);
}

// Format time to 24 hour format
function formatWaktu(time) {
  return new Date("1970-01-01T" + time).toLocaleTimeString("id-ID", {
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  });
}

// Validate form input
function validateInput(input, pattern, errorMsg) {
  if (!pattern.test(input.value)) {
    input.setCustomValidity(errorMsg);
    return false;
  }
  input.setCustomValidity("");
  return true;
}

// Show loading spinner
function showLoading(targetId = "loading") {
  const target = document.getElementById(targetId);
  if (target) {
    target.style.display = "flex";
  }
}

// Hide loading spinner
function hideLoading(targetId = "loading") {
  const target = document.getElementById(targetId);
  if (target) {
    target.style.display = "none";
  }
}

// Show toast notification
function showToast(message, type = "success") {
  const toast = document.createElement("div");
  toast.className = `toast toast-${type} show`;
  toast.setAttribute("role", "alert");
  toast.setAttribute("aria-live", "assertive");
  toast.setAttribute("aria-atomic", "true");

  toast.innerHTML = `
        <div class="toast-header">
            <i class="fas fa-info-circle me-2"></i>
            <strong class="me-auto">Notifikasi</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">${message}</div>
    `;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 3000);
}

// Copy text to clipboard
function copyToClipboard(text) {
  navigator.clipboard
    .writeText(text)
    .then(() => {
      showToast("Teks berhasil disalin!");
    })
    .catch((err) => {
      showToast("Gagal menyalin teks: " + err, "error");
    });
}

// Debounce function
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Throttle function
function throttle(func, limit) {
  let inThrottle;
  return function (...args) {
    if (!inThrottle) {
      func.apply(this, args);
      inThrottle = true;
      setTimeout(() => (inThrottle = false), limit);
    }
  };
}

// Get URL parameters
function getUrlParams() {
  const params = {};
  new URLSearchParams(window.location.search).forEach((value, key) => {
    params[key] = value;
  });
  return params;
}

// Set URL parameters
function setUrlParams(params) {
  const searchParams = new URLSearchParams();
  Object.keys(params).forEach((key) => {
    if (params[key] !== null && params[key] !== undefined) {
      searchParams.set(key, params[key]);
    }
  });
  const newUrl = `${window.location.pathname}?${searchParams.toString()}`;
  window.history.pushState({}, "", newUrl);
}

// Validate file size and type
function validateFile(file, maxSize, allowedTypes) {
  if (file.size > maxSize) {
    showToast(
      `Ukuran file terlalu besar. Maksimal ${formatFileSize(maxSize)}.`,
      "error"
    );
    return false;
  }

  if (!allowedTypes.includes(file.type)) {
    showToast("Tipe file tidak didukung.", "error");
    return false;
  }

  return true;
}

// Format file size
function formatFileSize(bytes) {
  if (bytes === 0) return "0 Bytes";
  const k = 1024;
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
}

// Generate random string
function generateRandomString(length = 8) {
  const chars =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let result = "";
  for (let i = 0; i < length; i++) {
    result += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return result;
}

// Validate email
function validateEmail(email) {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

// Validate phone number (Indonesia)
function validatePhone(phone) {
  const re = /^(\+62|62)?[\s-]?0?8[1-9]{1}\d{1}[\s-]?\d{4}[\s-]?\d{2,5}$/;
  return re.test(phone);
}

// Format phone number
function formatPhone(phone) {
  return phone.replace(/\D/g, "").replace(/(\d{4})(\d{4})(\d{4})/, "$1-$2-$3");
}

// Scroll to element
function scrollToElement(elementId, offset = 0) {
  const element = document.getElementById(elementId);
  if (element) {
    const y = element.getBoundingClientRect().top + window.pageYOffset + offset;
    window.scrollTo({ top: y, behavior: "smooth" });
  }
}

// Check if element is in viewport
function isInViewport(element) {
  const rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <=
      (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

// Add event listener for outside click
function addOutsideClickListener(element, callback) {
  document.addEventListener("click", function (event) {
    if (!element.contains(event.target)) {
      callback();
    }
  });
}

// Remove event listener for outside click
function removeOutsideClickListener(element, callback) {
  document.removeEventListener("click", function (event) {
    if (!element.contains(event.target)) {
      callback();
    }
  });
}
