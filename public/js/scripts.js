/*!
* Start Bootstrap - Freelancer v7.0.7 (https://startbootstrap.com/theme/freelancer)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-freelancer/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        // Add navbar-at-top class when scrollY is 0, remove navbar-shrink
        // Otherwise, remove navbar-at-top and add navbar-shrink
        if (window.scrollY < 10) { // Using a small threshold instead of === 0 for robustness
            navbarCollapsible.classList.add('navbar-at-top');
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.remove('navbar-at-top');
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Apply dynamic styles on page load
    navbarShrink();

    // Apply dynamic styles when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

document.addEventListener("DOMContentLoaded", () => {
    const newsList = document.getElementById("news-list");
    const addForm = document.getElementById("add-form");
    const titleInput = document.getElementById("add-title");
    const descInput = document.getElementById("add-description");
  
    // Baca dari localStorage dan tampilkan
    function loadNews() {
      newsList.innerHTML = "";
      const newsArray = JSON.parse(localStorage.getItem("newsData")) || [];
  
      newsArray.forEach((item, index) => {
        const newsItem = document.createElement("div");
        newsItem.className = "news-item";
        newsItem.dataset.id = index;
        newsItem.innerHTML = `
          <h2 class="news-title">${item.title}</h2>
          <p class="news-description">${item.description}</p>
          <button class="edit-btn">Edit</button>
          <button class="delete-btn">Hapus</button>
        `;
        newsList.appendChild(newsItem);
      });
    }
  
    // Tambah berita baru
    addForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const title = titleInput.value;
      const desc = descInput.value;
  
      const newsArray = JSON.parse(localStorage.getItem("newsData")) || [];
      newsArray.push({ title, description: desc });
      localStorage.setItem("newsData", JSON.stringify(newsArray));
  
      titleInput.value = "";
      descInput.value = "";
      loadNews();
    });
  
    loadNews(); // Panggil saat halaman dibuka
  });
  