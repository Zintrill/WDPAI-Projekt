document.addEventListener('DOMContentLoaded', function() {
    const addUserButton = document.getElementById('addUserButton');
    const userModal = document.getElementById('userModal');
    const closeUserModal = document.getElementById('closeUserModal');
    const cancelUserButton = document.getElementById('cancelUserButton');
    const userForm = document.getElementById('userForm');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const usernameError = document.getElementById('usernameError');
    const emailError = document.getElementById('emailError');

    addUserButton.addEventListener('click', function() {
        userModal.style.display = 'block';
    });

    closeUserModal.addEventListener('click', function() {
        userModal.style.display = 'none';
    });

    cancelUserButton.addEventListener('click', function() {
        userModal.style.display = 'none';
    });

    // Zamknij modal, jeśli użytkownik kliknie poza modalem
    window.addEventListener('click', function(event) {
        if (event.target == userModal) {
            userModal.style.display = 'none';
        }
    });

    // Sprawdź dostępność nazwy użytkownika
    usernameInput.addEventListener('blur', function() {
        const username = usernameInput.value;
        if (username) {
            fetch(`checkUsername?username=${username}`)
                .then(response => response.json())
                .then(data => {
                    if (data.isTaken) {
                        usernameError.textContent = 'Username is already taken';
                    } else {
                        usernameError.textContent = '';
                    }
                });
        }
    });

    // Sprawdź dostępność adresu e-mail
    emailInput.addEventListener('blur', function() {
        const email = emailInput.value;
        if (email) {
            fetch(`checkEmail?email=${email}`)
                .then(response => response.json())
                .then(data => {
                    if (data.isTaken) {
                        emailError.textContent = 'Email is already taken';
                    } else {
                        emailError.textContent = '';
                    }
                });
        }
    });

    // Sprawdź formularz przed wysłaniem
    userForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const username = usernameInput.value;
        const email = emailInput.value;

        Promise.all([
            fetch(`checkUsername?username=${username}`).then(response => response.json()),
            fetch(`checkEmail?email=${email}`).then(response => response.json())
        ]).then(results => {
            const [usernameData, emailData] = results;
            let valid = true;

            if (usernameData.isTaken) {
                usernameError.textContent = 'Username is already taken';
                valid = false;
            } else {
                usernameError.textContent = '';
            }

            if (emailData.isTaken) {
                emailError.textContent = 'Email is already taken';
                valid = false;
            } else {
                emailError.textContent = '';
            }

            if (valid) {
                userForm.submit();
            }
        });
    });
});
