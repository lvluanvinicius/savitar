import './bootstrap';
import.meta.glob([
    '../assets/**'
]);


document.getElementById("handle-keys-dropdown").addEventListener('click', (event) => {
    const siteContainer = document.getElementsByClassName('side-dropdown-container');
    for (let idx = 0; idx < siteContainer.length; idx++) {
        if (siteContainer[idx].attributes.handle.value == event.target.attributes.id.value) {
            if (siteContainer[idx].style.display === "block") {
                siteContainer[idx].style.display = "none";
            } else {
                siteContainer[idx].style.display = "block"
            }
        }
    }
});


document.getElementById("handle-users-dropdown").addEventListener('click', (event) => {
    const siteContainer = document.getElementsByClassName('side-dropdown-container');
    for (let idx = 0; idx < siteContainer.length; idx++) {
        if (siteContainer[idx].attributes.handle.value == event.target.attributes.id.value) {

            if (siteContainer[idx].style.display === "block") {
                siteContainer[idx].style.display = "none";
            } else {
                siteContainer[idx].style.display = "block"
            }
        }
    }
});

document.getElementById("handle-groups-dropdown").addEventListener('click', (event) => {
    const siteContainer = document.getElementsByClassName('side-dropdown-container');
    for (let idx = 0; idx < siteContainer.length; idx++) {
        if (siteContainer[idx].attributes.handle.value == event.target.attributes.id.value) {

            if (siteContainer[idx].style.display === "block") {
                siteContainer[idx].style.display = "none";
            } else {
                siteContainer[idx].style.display = "block"
            }
        }
    }
});


// ============================= Datatable Config;


// ============================= /End Datatable Config;



// ============================= Users Config;

// ============================= /End Users Config;