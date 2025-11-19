import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Confirmation dialogs
window.confirmDelete = function(message) {
  return confirm(message || "Are you sure you want to delete this item? This action cannot be undone.");
};

// Image preview on file upload
document.addEventListener("DOMContentLoaded", function() {
  const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');

  imageInputs.forEach(input => {
    input.addEventListener("change", function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        const preview = document.getElementById("imagePreview");

        reader.onload = function(e) {
          if (preview) {
            preview.src = e.target.result;
            preview.classList.remove("hidden");
          } else {
            // Create preview if doesn't exist
            const img = document.createElement("img");
            img.id = "imagePreview";
            img.src = e.target.result;
            img.className = "mt-4 max-w-xs rounded-lg shadow-md";
            input.parentElement.appendChild(img);
          }
        };

        reader.readAsDataURL(file);
      }
    });
  });

  // Lazy load images
  const images = document.querySelectorAll('img[loading="lazy"]');
  images.forEach(img => {
    img.addEventListener("load", function() {
      this.classList.add("loaded");
    });
  });

  // Form validation feedback
  const forms = document.querySelectorAll("form");
  forms.forEach(form => {
    form.addEventListener("submit", function(e) {
      const requiredFields = form.querySelectorAll("[required]");
      let isValid = true;

      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add("border-red-500");
        } else {
          field.classList.remove("border-red-500");
        }
      });

      if (!isValid) {
        e.preventDefault();
        alert("Please fill in all required fields.");
      }
    });
  });

  // Quantity input validation
  const quantityInputs = document.querySelectorAll('input[name="quantity"]');
  quantityInputs.forEach(input => {
    input.addEventListener("input", function() {
      const max = parseInt(this.getAttribute("max"));
      const value = parseInt(this.value);

      if (value > max) {
        this.value = max;
        alert(`Maximum quantity available: ${max}`);
      }

      if (value < 1) {
        this.value = 1;
      }
    });
  });
});

// Smooth scroll to top
window.scrollToTop = function() {
  window.scrollTo({
    top: 0,
    behavior: "smooth"
  });
};

// Add to top button
document.addEventListener("DOMContentLoaded", function() {
  // Create scroll to top button
  const scrollBtn = document.createElement("button");
  scrollBtn.innerHTML = "↑";
  scrollBtn.className =
    "fixed bottom-8 right-8 bg-indigo-600 text-white p-4 rounded-full shadow-lg hover:bg-indigo-700 transition-all duration-300 opacity-0 pointer-events-none z-50";
  scrollBtn.onclick = scrollToTop;
  document.body.appendChild(scrollBtn);

  // Show/hide scroll button
  window.addEventListener("scroll", function() {
    if (window.pageYOffset > 300) {
      scrollBtn.classList.remove("opacity-0", "pointer-events-none");
    } else {
      scrollBtn.classList.add("opacity-0", "pointer-events-none");
    }
  });
});
