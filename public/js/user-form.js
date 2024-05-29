document.addEventListener('DOMContentLoaded', function() {
    const addUserButton = document.getElementById('addUserButton');
    const userForm = document.getElementById('userForm');
    const cancelUserButton = document.getElementById('cancelUserButton');

    addUserButton.addEventListener('click', function() {
        userForm.style.display = 'block';
    });

    cancelUserButton.addEventListener('click', function() {
        userForm.style.display = 'none';
    });

});

function submitUserForm() {
    // Logika wysyłania formularza użytkownika
    document.getElementById("userForm").style.display = "none";
}

function cancelUserForm() {
    // Logika anulowania formularza użytkownika
    document.getElementById("userForm").style.display = "none";
}

