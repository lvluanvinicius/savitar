$(document).ready(function () {
    document.getElementById("copy-key").addEventListener('click', () => {
        toastr.success("Token copiado.");
        window.event.preventDefault();
        document.getElementById('text-token').innerHTML;
        document.execCommand('copy');
    });
});
