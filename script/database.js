const switchMode = document.getElementById('switch-mode');
if (switchMode) {
    switchMode.addEventListener('change', function () {
        if(this.checked) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
    });
}