document.addEventListener("DOMContentLoaded", function() {
    const itemsPerPage = 15;
    const deviceList = document.getElementById("DeviceList");
    const deviceItems = deviceList.querySelectorAll(".device-item");
    const pageCount = Math.ceil(deviceItems.length / itemsPerPage);

    let currentPage = 1;
    showPage(currentPage);

    function showPage(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = page * itemsPerPage;

        deviceItems.forEach((item, index) => {
            if (index >= startIndex && index < endIndex) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    function navigateToPage(page) {
        if (page < 1 || page > pageCount) return;
        currentPage = page;
        showPage(currentPage);
    }

    const paginationContainer = document.createElement("div");
    paginationContainer.classList.add("pagination");

    for (let i = 1; i <= pageCount; i++) {
        const pageButton = document.createElement("button");
        pageButton.textContent = i;
        pageButton.addEventListener("click", function() {
            navigateToPage(i);
        });
        paginationContainer.appendChild(pageButton);
    }

    document.body.appendChild(paginationContainer);
});
