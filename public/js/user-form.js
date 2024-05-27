document.addEventListener('DOMContentLoaded', function() {
    const addUserButton = document.getElementById('addUserButton');
    const userForm = document.getElementById('userForm');
    const cancelUserButton = document.getElementById('cancelUserButton');
    const addAnotherUserButton = document.querySelector('.add-another-button');

    addUserButton.addEventListener('click', function() {
        userForm.style.display = 'block';
    });

    cancelUserButton.addEventListener('click', function() {
        userForm.style.display = 'none';
    });

    addAnotherUserButton.addEventListener('click', function() {
        // Opcjonalnie resetujemy pola formularza przed ponownym pokazaniem
        document.querySelectorAll('.user-form input, .user-form select').forEach(function(element) {
            element.value = '';
        });
        userForm.style.display = 'block';
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

function addAnotherUser() {
    // Logika dodawania kolejnego użytkownika
    document.getElementById("userForm").style.display = "block";
}
