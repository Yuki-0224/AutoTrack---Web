document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper', {
       slidesPerView: 3,     
        spaceBetween: 12,  
        loop: true,
        speed: 600,

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});

const parallaxLayers = document.querySelectorAll('.parallax-layer');

window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset;
    parallaxLayers.forEach(layer => {
        const speed = parseFloat(layer.dataset.speed) || 0;
        layer.style.transform = `translate3d(0, ${scrollTop * speed}px, 0)`;
    });
});

const themeToggle = document.getElementById('theme-toggle');
const themeLabel = document.getElementById('theme-toggle-label');

function setTheme(theme) {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
    if (themeToggle) themeToggle.classList.toggle('active', isDark);
    if (themeLabel) themeLabel.textContent = isDark ? 'Dark' : 'Light';
    localStorage.setItem('theme', theme);
}

function initTheme() {
    const savedTheme = localStorage.getItem('theme');
    const preferredTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    setTheme(savedTheme || preferredTheme);
}

window.addEventListener('DOMContentLoaded', () => {
    initTheme();
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            setTheme(document.documentElement.classList.contains('dark') ? 'light' : 'dark');
        });
    }
});



document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".add-car");
    const inputs = form.querySelectorAll("input[type='text']");
    const imageInput = document.getElementById("imageInput");
    const priceInput = document.getElementById("price");

    function showError(input) {
        input.classList.add("error-input");
    }

    function clearError(input) {
        input.classList.remove("error-input");
    }

    form.addEventListener("submit", function (e) {
        let valid = true;

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                showError(input);
                valid = false;
            } else {
                clearError(input);
            }
        });

        if (!imageInput.files.length) {
            imageInput.classList.add("error-input");
            valid = false;
        }

        if (!valid) e.preventDefault();
    });

    inputs.forEach(input => {
        input.addEventListener("input", () => clearError(input));
    });

    imageInput.addEventListener("change", () => {
        imageInput.classList.remove("error-input");
    });

    function formatNumber(value) {
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    priceInput.addEventListener("input", function () {
        let raw = this.value.replace(/[^0-9]/g, "");
        if (raw === "") {
            this.value = "";
            return;
        }
        this.value = "₱ " + formatNumber(raw);
    });

    // PRA SA CAR TYPE IF MAY IDADAGDAG SA DROWPDOWN
    const carTypeSelect = document.getElementById('car_type');
    const carTypeInput = document.getElementById('car_type_other');

    carTypeSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            carTypeSelect.style.display = 'none'; 
            carTypeInput.style.display = 'block'; 
            carTypeInput.required = true;
        } else {
            carTypeSelect.style.display = 'block';
            carTypeInput.style.display = 'none';
            carTypeInput.required = false;
        }
    });

    // PARA SA IMAGE NY UPDATE CAR
    const input = document.getElementById("imageInput");
    const fileName = document.getElementById("fileName");
    const preview = document.getElementById("previewImg");

    input.addEventListener("change", function() {
        const file = this.files[0];

        if (file) {
            fileName.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = "No file chosen";
        }
    });

});


