const app = {
  init: () => {
    document.addEventListener("DOMContentLoaded", app.load);
    console.log("DOM Loaded");
  },

  load: () => {
    app.bindingInteraction();
  },

  bindingInteraction: () => {
    
    let page = document.body.id;
    let section = document.querySelectorAll("section")[0].id;


    switch (page) {
      case "home":
      case "category":
      case "product-detail":
        app.navbarInteractions();
        break;

      case "dashboard-page":
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
      this.classList.toggle('active');
      this.nextElementSibling.classList.toggle("active");
    })

    // Searh box toggler
    const searchToggler = document.querySelector(".search-toggler");
    const searchBar = document.querySelector(".search-bar");
    const navBar = document.querySelector(".navbar");

    searchToggler.addEventListener("click", () => {
      searchBar.classList.toggle("search-bar-show");
      navBar.classList.remove("navbar-show");
    });

    const exitSearchBar = document.querySelector(".search-box-exit");
    exitSearchBar.addEventListener("click", function (event) {
      this.parentElement.parentElement.classList.remove("search-bar-show");
      document.querySelector(".navbar").classList.add("navbar-show");
    });
  },
};

app.init();
