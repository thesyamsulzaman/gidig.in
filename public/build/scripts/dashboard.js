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
      case "add-product":
        app.formValidation();
        console.log("Component Loaded")
        break;
      default:
        console.log("Log out something else");
    }



  },

  alert: () => {
    document.querySelector(".close-btn").addEventListener("click", function(e) {
      document.querySelector(".alert").classList.remove("show");
      document.querySelector(".alert").classList.add("hide");
    })
  },

  formValidation: () => {

    document
      .querySelectorAll(".form-group[data-error] .form-control")
      .forEach((inputElement) => {
        inputElement.addEventListener("input", () =>
          inputElement.parentElement.removeAttribute("data-error")
        );
      });

  },

  dashboardInteractions: () => {
    let state = {
      showSidebar: true,
    }

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
    accordionHeader.addEventListener("click", function (event) {
      this.nextElementSibling.classList.toggle("active");
      this.classList.toggle("active");
    });
  },

};

app.init();
