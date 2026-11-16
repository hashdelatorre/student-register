<script>
document.querySelectorAll('form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        if (form.dataset.submitted === '1') {
            e.preventDefault();
            return;
        }
        form.dataset.submitted = '1';
        var btn = form.querySelector('button[type="submit"]');
        if (btn) {
            btn.dataset.label = btn.textContent;
            btn.disabled = true;
            btn.textContent = 'Please wait...';
        }
    });
});

// re-enable buttons if the user comes back with the Back button
window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
        document.querySelectorAll('form').forEach(function (form) {
            form.dataset.submitted = '0';
            var btn = form.querySelector('button[type="submit"]');
            if (btn && btn.dataset.label) {
                btn.disabled = false;
                btn.textContent = btn.dataset.label;
            }
        });
    }
});
</script>