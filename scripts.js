// Custom JavaScript for login/registration enhancements (optional)
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('form');
    
    loginForm.addEventListener('submit', function(event) {
        const username = document.querySelector('[name="username"]').value;
        const password = document.querySelector('[name="password"]').value;
        
        if (username === "" || password === "") {
            alert("Please fill in all fields");
            event.preventDefault();
        }
    });
});
