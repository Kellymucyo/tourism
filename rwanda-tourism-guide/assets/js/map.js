// Interactive map for Rwanda Tourism website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Rwanda map if element exists
    const rwandaMapElement = document.getElementById('rwandaMap');
    if (rwandaMapElement) {
        // Create the map centered on Rwanda
        const rwandaMap = L.map('rwandaMap').setView([-1.9403, 29.8739], 7);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(rwandaMap);
        
        // Define province boundaries (simplified coordinates)
        const provinces = {
            kigali: {
                name: "Kigali City",
                coords: [[-1.95, 30.05], [-1.95, 30.1], [-1.9, 30.1], [-1.9, 30.05]],
                fillColor: "#28a745",
                color: "#218838"
            },
            northern: {
                name: "Northern Province",
                coords: [[-1.4, 29.5], [-1.4, 30.2], [-2.0, 30.2], [-2.0, 29.5]],
                fillColor: "#17a2b8",
                color: "#138496"
            },
            southern: {
                name: "Southern Province",
                coords: [[-2.0, 29.5], [-2.0, 30.2], [-2.6, 30.2], [-2.6, 29.5]],
                fillColor: "#6f42c1",
                color: "#5a3d8e"
            },
            eastern: {
                name: "Eastern Province",
                coords: [[-1.4, 30.2], [-1.4, 30.8], [-2.0, 30.8], [-2.0, 30.2]],
                fillColor: "#fd7e14",
                color: "#d66b0d"
            },
            western: {
                name: "Western Province",
                coords: [[-1.8, 29.0], [-1.8, 29.5], [-2.4, 29.5], [-2.4, 29.0]],
                fillColor: "#dc3545",
                color: "#b02a37"
            }
        };
        
        // Add province polygons to the map
        for (const [id, province] of Object.entries(provinces)) {
            const polygon = L.polygon(province.coords, {
                fillColor: province.fillColor,
                color: province.color,
                weight: 2,
                opacity: 1,
                fillOpacity: 0.5
            }).addTo(rwandaMap);
            
            // Add click event to show attractions in this province
            polygon.on('click', function() {
                window.location.href = `${BASE_URL}/pages/destinations.php?province=${id}`;
            });
            
            // Add hover effects
            polygon.on('mouseover', function() {
                this.setStyle({
                    fillOpacity: 0.7
                });
            });
            
            polygon.on('mouseout', function() {
                this.setStyle({
                    fillOpacity: 0.5
                });
            });
            
            // Add province label
            const center = getCenter(province.coords);
            L.marker(center, {
                icon: L.divIcon({
                    html: `<div style="background-color: ${province.fillColor}; color: white; padding: 5px 10px; border-radius: 4px; font-weight: bold;">${province.name}</div>`,
                    className: 'province-label',
                    iconSize: null
                })
            }).addTo(rwandaMap);
        }
        
        // Function to calculate center of polygon
        function getCenter(coords) {
            let lat = 0, lng = 0;
            coords.forEach(coord => {
                lat += coord[0];
                lng += coord[1];
            });
            return [lat / coords.length, lng / coords.length];
        }
    }
});

// Function to initialize destination map (used in single_destination.php)
function initDestinationMap(latitude, longitude, name) {
    const map = L.map('destinationMap').setView([latitude, longitude], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup(name)
        .openPopup();
}