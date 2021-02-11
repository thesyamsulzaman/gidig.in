const app = {
  init: () => {
    document.addEventListener("DOMContentLoaded", app.load);
    console.log("DOM Loaded");
  },

  load: () => {
    app.bindingInteraction();
    app.bindingComponentInteraction();
  },

  bindingComponentInteraction: () => {},

  alert: () => {
    document.querySelector("close-btn").addEventListener("click", function(e) {
      document.querySelector("alert").classList.remove("show");
      document.querySelector("alert").classList.add("hide");
    });
  },

  bindingInteraction: () => {
    let page = document.body.id;
    let section = document.querySelectorAll("section")[0].id;

    let dashboardContent = document
      .querySelector(".content-container")
      .querySelector(".content-form").classList[0];

    switch (page) {
      case "home":
      case "category":
      case "product-detail":
        app.navbarInteractions();
        break;

      case "dashboard-page":
        app.dragAndDropUploader();
        app.dashboardInteractions();
        break;

      default:
        console.log("Log out something else");
    }

    switch (section) {
      case "login":
      case "register":
        app.formValidation();
        break;
    }

    switch (dashboardContent) {
      case "content-form":
        app.formValidation();
        console.log("Component Loaded");
        break;
    }
  },

  dragAndDropUploader: () => {
    document.querySelectorAll(".drop-image__holder").forEach(inputElement => {
      const dropZoneElement = inputElement.closest(".drop-image");

      dropZoneElement.addEventListener("click", e => {
        inputElement.click();
      })

      inputElement.addEventListener("change", e => {
        if (inputElement.files.length) {
          updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
      })

      dropZoneElement.addEventListener("dragover", e => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-image--over");
      });

      let arr = ["dragleave", "dragend"];
      arr.forEach(type => {
        dropZoneElement.addEventListener(type, e => {
          dropZoneElement.classList.remove("drop-image--over");
        });
      });

      dropZoneElement.addEventListener("drop", e => {
        e.preventDefault();
        if (e.dataTransfer.files) {
          inputElement.files = e.dataTransfer.files;
          updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }
        dropZoneElement.classList.remove("drop-image--over");
      });

      function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(
          ".drop-image__thumbnail"
        );

        if (dropZoneElement.querySelector(".drop-image__prompt")) {
          dropZoneElement.querySelector(".drop-image__prompt").remove();
        }

        if (!thumbnailElement) {
          thumbnailElement = document.createElement("div");
          thumbnailElement.classList.add("drop-image__thumbnail");
          dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        if (file.type.startsWith("image/")) {
          const reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url(${reader.result})`;
          };
        }
      }
    });
  },
  formValidation: () => {
    document
      .querySelectorAll(".form-group[data-error] .form-control")
      .forEach(inputElement => {
        inputElement.addEventListener("input", () =>
          inputElement.parentElement.removeAttribute("data-error")
        );
      });
  },

  dashboardInteractions: () => {
    // Sidebar Toggler
    const sidebarToggler = document.querySelector(".sidebar-toggler");
    const dashboardSidebar = document.querySelector("#dashboard-sidebar");
    const dashboard = document.querySelector("#dashboard");

    sidebarToggler.addEventListener("click", () => {
      dashboardSidebar.classList.toggle("active");
      dashboard.classList.toggle("shrink");
    });

    // Sidebar Accordion List
    const accordionHeader = document.querySelector(".accordion-header");
    accordionHeader.addEventListener("click", function(event) {
      this.nextElementSibling.classList.toggle("active");
      this.classList.toggle("active");
    });
  },

  navbarInteractions: () => {
    // Dropdown Menu
    const navMenuToggler = document.querySelector(".nav-menu-toggler");
    const navMenuContainer = document.querySelector(".sidebar");

    navMenuToggler.addEventListener("click", function(event) {
      this.classList.toggle("active");
      navMenuContainer.classList.toggle("active");
    });

    // Categories Accordion
    const dropDownButton = document.querySelector(".dropdown-button");
    dropDownButton.addEventListener("click", function(event) {
      this.classList.toggle("active");
      this.nextElementSibling.classList.toggle("active");
    });

    // Searh box toggler
    const searchToggler = document.querySelector(".search-toggler");
    const searchBar = document.querySelector(".search-bar");
    const navBar = document.querySelector(".navbar");

    searchToggler.addEventListener("click", () => {
      searchBar.classList.toggle("search-bar-show");
      navBar.classList.remove("navbar-show");
    });

    const exitSearchBar = document.querySelector(".search-box-exit");
    exitSearchBar.addEventListener("click", function(event) {
      this.parentElement.parentElement.classList.remove("search-bar-show");
      document.querySelector(".navbar").classList.add("navbar-show");
    });
  }
};

app.init();
