const app = {
  init: () => {
    document.addEventListener("DOMContentLoaded", app.load);
    console.log("DOM Loaded");
  },

  load: () => {
    app.bindingInteraction();
  },

  bindingComponentInteraction: () => {
    app.alert();
  },

  bindingInteraction: () => {
    let page = document.body.id;
    let section = document.querySelectorAll("section")[1].id;

    switch (page) {
      case "dashboard-page":
        app.dashboardInteractions();
        break;
    }

    switch (section) {
      case "edit-product":
        app.sortableDragAndDrop();
      case "edit-product":
      case "add-product":
        app.formValidation();
        app.dragAndDropUploader();
        console.log("Component Loaded");
        break;
      default:
        console.log("Log out something else");
    }
  },

  alert: () => {
    document.querySelector(".close-btn").addEventListener("click", function(e) {
      document.querySelector(".alert").classList.remove("show");
      document.querySelector(".alert").classList.add("hide");
    });
  },

  sortableDragAndDrop: () => {
    const draggableItems = document.querySelectorAll(".sortable-image");
    const draggableItemsContainer = document.querySelector(".sortable-images");

    draggableItems.forEach(draggableItem => {
      draggableItem.addEventListener("dragstart", e => {
        draggableItem.classList.add("dragging");
      });

      draggableItem.addEventListener("dragend", e => {
        draggableItem.classList.remove("dragging");
      });
    });

    draggableItemsContainer.addEventListener("dragover", e => {
      e.preventDefault();
      const dragable = document.querySelector(".dragging");
      const afterElement = getDragAfterElement(
        draggableItemsContainer,
        e.clientY
      );
      if (afterElement == null) {
        draggableItemsContainer.appendChild(dragable);
      } else {
        draggableItemsContainer.insertBefore(dragable, afterElement);
      }
      draggableItemsContainer.appendChild(dragable);

      console.log("From Script file : ", getImageIds().value);
    });

    function getDragAfterElement(container, y) {
      const dragableElements = [
        ...container.querySelectorAll(".sortable-image:not(.dragging)")
      ];

      dragableElements.reduce(
        (closest, child) => {
          const box = child.getBoundingClientRect();
          const offset = y - box.bottom - (box.height / 2 );
          if (offset < 0 && offset > closest.offset) {
            return { offset, element: child };
          } else {
            return closest;
          }
        },
        { offset: Number.NEGATIVE_INFINITY.element }
      );
    }
  },
  dragAndDropUploader: () => {
    document.querySelectorAll(".drop-image__holder").forEach(inputElement => {
      const dropZoneElement = inputElement.closest(".drop-image");

      dropZoneElement.addEventListener("click", e => {
        inputElement.click();
      });

      inputElement.addEventListener("change", e => {
        if (inputElement.files.length) {
          updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
      });

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
        if (inputElement.classList.contains("drop-image__holder")) {
          console.log(inputElement);
        }

        inputElement.addEventListener("input", () =>
          inputElement.parentElement.removeAttribute("data-error")
        );
      });
  },

  dashboardInteractions: () => {
    let state = {
      showSidebar: true
    };

    const { showSidebar } = state;

    // Sidebar Toggler
    const sidebarToggler = document.querySelector(".sidebar-toggler");
    const dashboardSidebar = document.querySelector("#dashboard-sidebar");
    const dashboard = document.querySelector("#dashboard");

    if (showSidebar) {
      dashboardSidebar.classList.add("active");
      dashboard.classList.add("shrink");
    } else {
      dashboardSidebar.classList.remove("active");
      dashboard.classList.remove("shrink");
    }

    sidebarToggler.addEventListener("click", () => {
      state.showSidebar = !state.showSidebar;
      dashboardSidebar.classList.toggle("active");
      dashboard.classList.toggle("shrink");
    });

    // Sidebar Accordion List
    const accordionHeader = document.querySelector(".accordion-header");
    accordionHeader.addEventListener("click", function(event) {
      this.nextElementSibling.classList.toggle("active");
      this.classList.toggle("active");
    });
  }
};

app.init();
