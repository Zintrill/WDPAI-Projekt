document.addEventListener('DOMContentLoaded', function() {
    fetchUsers();

    let userIdToDelete = null; // Przechowuje ID użytkownika do usunięcia

    // Pobierz elementy modalu
    const deleteModal = document.getElementById('deleteModal');
    const closeModal = document.getElementById('closeModal');
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');
    const cancelDeleteButton = document.getElementById('cancelDeleteButton');

    // Funkcja do otwierania modalu
    function openModal() {
        deleteModal.style.display = 'block';
    }

    // Funkcja do zamykania modalu
    function closeModalWindow() {
        deleteModal.style.display = 'none';
    }

    // Zamykanie modalu po kliknięciu przycisku "X"
    closeModal.addEventListener('click', closeModalWindow);

    // Zamykanie modalu po kliknięciu przycisku "No"
    cancelDeleteButton.addEventListener('click', closeModalWindow);

    // Obsługa kliknięcia przycisku "Yes" w celu potwierdzenia usunięcia
    confirmDeleteButton.addEventListener('click', function() {
        if (userIdToDelete) {
            fetch('deleteUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `userId=${userIdToDelete}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    fetchUsers();
                    closeModalWindow();
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    function fetchUsers() {
        fetch('getUsers')
            .then(response => response.json())
            .then(users => {
                const userList = document.getElementById('userList');
                userList.innerHTML = '';
                users.forEach(user => {
                    const userItem = document.createElement('div');
                    userItem.classList.add('user-item');

                    userItem.innerHTML = `
                        <span class="user-info-phone">${user.fullname}</span>
                        <span class="user-info">${user.username}</span>
                        <span class="user-info-phone">******** <i class="eye-icon fa-solid fa-eye-low-vision"></i></span>
                        <span class="user-info">${user.role}</span>
                        <span class="user-info">${user.email}</span>
                        <button class="deleteButton" data-id="${user.id}"><i class="fa-solid fa-trash"></i></button>
                    `;

                    userList.appendChild(userItem);
                });

                document.querySelectorAll('.deleteButton').forEach(button => {
                    button.addEventListener('click', function() {
                        userIdToDelete = this.getAttribute('data-id');
                        openModal();
                    });
                });
            })
            .catch(error => console.error('There has been a problem with your fetch operation:', error));
    }
});
