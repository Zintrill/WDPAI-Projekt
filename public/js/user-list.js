document.addEventListener('DOMContentLoaded', function() {
    fetchUsers();

    function fetchUsers() {
        fetch('getUsers')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
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
                        <button class="editButton"><i class="fa-solid fa-pencil"></i></button>
                        <button class="deleteButton"><i class="fa-solid fa-trash"></i></button>
                    `;

                    userList.appendChild(userItem);
                });
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
    }
});
