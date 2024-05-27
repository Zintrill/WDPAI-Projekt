document.addEventListener('DOMContentLoaded', function() {
    const addDeviceButton = document.getElementById('addDeviceButton');
    const deviceForm = document.getElementById('deviceForm');
    const cancelButton = document.getElementById('cancelButton');
    const addAnotherButton = document.querySelector('.add-another-button');

    addDeviceButton.addEventListener('click', function() {
        deviceForm.style.display = 'block';
    });

    cancelButton.addEventListener('click', function() {
        deviceForm.style.display = 'none';
    });

    addAnotherButton.addEventListener('click', function() {
        // Optionally reset form fields before showing the form again
        document.querySelectorAll('.device-form input, .device-form select').forEach(function(element) {
            element.value = '';
        });
        deviceForm.style.display = 'block';
    });
});

function submitForm() {
    // Your submit form logic
    document.getElementById("deviceForm").style.display = "none";
}

function cancelForm() {
    // Your cancel form logic
    document.getElementById("deviceForm").style.display = "none";
}

function addAnotherDevice() {
    // Your add another device logic
    document.getElementById("deviceForm").style.display = "block";
}
