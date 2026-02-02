// ===================== COMMON.JS =====================

// ✅ Load Header & Footer automatically on every page
document.addEventListener("DOMContentLoaded", async () => {
  try {
    // --- Load Header ---
    const headerContainer = document.createElement("div");
    headerContainer.id = "header-container";
    document.body.prepend(headerContainer);

    const headerRes = await fetch("header.html");
    if (!headerRes.ok) throw new Error("Header file not found");
    const headerHTML = await headerRes.text();
    headerContainer.innerHTML = headerHTML;

    // Initialize header scripts
    initHeaderScripts();

    // --- Load Footer (after header loaded) ---
    const footerContainer = document.createElement("div");
    footerContainer.id = "footer-container";
    document.body.append(footerContainer);

    const footerRes = await fetch("footer.html");
    if (!footerRes.ok) throw new Error("Footer file not found");
    const footerHTML = await footerRes.text();
    footerContainer.innerHTML = footerHTML;

  } catch (e) {
    console.error("❌ Header/Footer load failed:", e);
  }
});

// ===================== HEADER FUNCTIONALITY =====================

function initHeaderScripts() {
  // ✅ Mobile menu open/close
  window.toggleMenu = function (show) {
    const nav = document.getElementById("navLinks");
    if (nav) {
      if (show) nav.classList.add("active");
      else nav.classList.remove("active");
    }
  };

  // ✅ Dropdown toggle
  window.toggleSubMenu = function (element) {
    const menu = element.parentElement;
    const allMenus = document.querySelectorAll(".menu");
    allMenus.forEach((m) => {
      if (m !== menu) m.classList.remove("active");
    });
    menu.classList.toggle("active");
  };

  // ✅ Accordion toggle
  window.toggleAccordion = function (button) {
    const content = button.nextElementSibling;

    // Collapse all
    document.querySelectorAll(".accordion-header").forEach((h) => {
      if (h !== button) h.classList.remove("active");
    });
    document.querySelectorAll(".accordion-content").forEach((c) => {
      if (c !== content) c.classList.remove("active");
    });

    // Toggle current
    button.classList.toggle("active");
    content.classList.toggle("active");
  };

  // ✅ Close dropdowns when clicking outside
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".menu")) {
      document.querySelectorAll(".menu").forEach((menu) => menu.classList.remove("active"));
    }
  });

  // ✅ ESC key closes menu
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      const nav = document.getElementById("navLinks");
      if (nav) nav.classList.remove("active");
    }
  });
}
window.addEventListener("scroll", function() {
  const header = document.querySelector("header");
  if (window.scrollY > 10) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});
