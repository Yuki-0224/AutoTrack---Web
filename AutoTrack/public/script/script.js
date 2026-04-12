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


document.addEventListener("DOMContentLoaded", function () {
     // PRA SA CAR TYPE IF MAY IDADAGDAG SA DROWPDOWN
    const carTypeSelect = document.getElementById('car_type');
    const carTypeInput = document.getElementById('car_type_others');

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

    carTypeInput.addEventListener()
});

document.addEventListener("DOMContentLoaded", function () {

    // para sa count days sa add rental page 

    const start = document.querySelector('[name="date_rental_start"]');
    const end = document.querySelector('[name="date_rental_end"]');
    const days = document.querySelector('[name="days"]');

    function calculateDays() {
        if (start.value && end.value) {
            const startDate = new Date(start.value);
            const endDate = new Date(end.value);

            const diff = (endDate - startDate) / (1000 * 60 * 60 * 24);
            days.value = diff > 0 ? diff : 0;
        }
    }

    start.addEventListener('input', calculateDays);
    end.addEventListener('input', calculateDays);


    // para sa automatic na nag rerecomend ng license 
    const lastNameInput = document.getElementById("lastNameInput");
    const nameList = document.getElementById("nameList");

    const plate_numberInput = document.getElementById("plate_numberInput");
    const carList = document.getElementById("carList");

    if (lastNameInput && nameList) {

        lastNameInput.addEventListener("input", function () {
            const query = this.value;

            if (query.length < 1) {
                nameList.innerHTML = "";
                return;
            }

            fetch("search_customer?q=" + query)
                .then(res => res.json())
                .then(data => {

                    console.log(data); 

                    nameList.innerHTML = "";

                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.classList.add("dropdown-item");

                        div.textContent = item.first_name + " " + item.last_name;

                        div.onclick = () => {
                            document.getElementById("firstNameInput").value = item.first_name;
                            document.getElementById("lastNameInput").value = item.last_name;
                            document.getElementById("licenseInput").value = item.driver_license;
                            document.getElementById("AddressInput").value = item.address;
                            document.getElementById("EmailInput").value = item.email;
                            document.getElementById("ContactInput").value = item.phone;

                            nameList.innerHTML = "";
                        };

                        nameList.appendChild(div);
                    });

                })
                .catch(err => console.log("ERROR:", err));
        });

    }

    if (plate_numberInput && carList) {

        plate_numberInput.addEventListener("input", function () {
            const query = this.value;

            if (query.length < 1) {
                nameList.innerHTML = "";
                return;
            }

            fetch("search_car?q=" + query)
                .then(res => res.json())
                .then(data => {

                    console.log(data); 

                    nameList.innerHTML = "";

                    data.forEach(item => {
                        const div = document.createElement("div");
                        div.classList.add("dropdown-item");

                        div.textContent = item.plate_number;

                        div.onclick = () => {
                            document.getElementById("plate_numberInput").value = item.plate_number;
                            document.getElementById("NameInput").value = item.car_name;
                            document.getElementById("BrandInput").value = item.brand;
                            document.getElementById("ModelInput").value = item.model;
                            document.getElementById("YearInput").value = item.year;
                            document.getElementById("CarTypeInput").value = item.car_type;
                            document.getElementById("ColorInput").value = item.color;
                            document.getElementById("PricePerDayInput").value = item.price_per_day;

                            nameList.innerHTML = "";
                        };

                        carList.appendChild(div);
                    });

                })
                .catch(err => console.log("ERROR:", err));
        });

    }

    document.addEventListener("click", function(e) {
        if (!lastNameInput.contains(e.target)) {
            nameList.innerHTML = "";
        }
        if (!plate_numberInput.contains(e.target)) {
            carList.innerHTML = "";
        }
    });
});