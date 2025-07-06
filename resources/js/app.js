import "./bootstrap";

import "bootstrap/dist/js/bootstrap.bundle.min.js";
document.querySelectorAll('.toast').forEach(toastEl => {
    new bootstrap.Toast(toastEl, { delay: 3000 }).show();
});
