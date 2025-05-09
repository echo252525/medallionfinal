function togglePassword(field) {
    const passwordInput = document.getElementById(field);
    const icon = document.querySelector(
        `i[alt="Show ${field === 'password' ? 'password' : 'confirm password'}"]`
    );

    // Check if password is hidden
    if (passwordInput.type === "password") {
        passwordInput.type = "text";  // Show password
        icon.classList.remove("bx-hide");  // Remove the "closed eye" icon
        icon.classList.add("bx-show");  // Add the "open eye" icon
    } else {
        passwordInput.type = "password";  // Hide password
        icon.classList.remove("bx-show");  // Remove the "open eye" icon
        icon.classList.add("bx-hide");  // Add the "closed eye" icon
    }
}

function validatePasswords() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
