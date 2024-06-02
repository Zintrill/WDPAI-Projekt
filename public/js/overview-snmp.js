document.addEventListener('DOMContentLoaded', function () {
    fetch('getDevices')
        .then(response => response.json())
        .then(devices => {
            const deviceList = document.getElementById('DeviceList');
            deviceList.innerHTML = '';
            devices.forEach(device => {
                const deviceItem = document.createElement('div');
                deviceItem.classList.add('device-item');

                let statusClass = '';
                if (device.status === 'online') {
                    statusClass = 'status-online';
                } else if (device.status === 'offline') {
                    statusClass = 'status-offline';
                } else if (device.status === 'waiting') {
                    statusClass = 'status-waiting';
                }

                deviceItem.innerHTML = `
                    <span class="device-info">${device.device_name}</span>
                    <span class="device-info ${statusClass}">${device.status}</span>
                    <span class="device-info">${device.type}</span>
                    <span class="device-info"><a href="http://${device.address_ip}" target="_blank">${device.address_ip}</a></span>
                    <span class="device-info">${device.mac_address}</span>
                    <span class="device-info">12D 12H</span>
                    <button class="ellipsisButton"><i class="fa-solid fa-ellipsis"></i></button>
                `;

                deviceList.appendChild(deviceItem);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
