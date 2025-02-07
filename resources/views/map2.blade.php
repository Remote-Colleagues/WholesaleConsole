<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 400px; width: 60%; margin: 0 auto; }
    </style>
</head>
<body>

<!-- Map Section -->
<div class="mb-3">
    <label for="map">Select Location on Map</label>
    <input type="text" id="searchBox" class="form-control mb-2" placeholder="Search location...">
    <div id="map"></div>
</div>

@section('scripts')
    <!-- Leaflet.js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        const apiKey = 'pk.c955796f3b0f6ba1fcdf78dc7d754395';
        var map = L.map('map', {
            center: [-33.8688, 151.2093],
            zoom: 12,
            zoomControl: true,
            scrollWheelZoom: true,
            dragging: true,
            doubleClickZoom: true,
            touchZoom: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        let markers = [];
        let addressIndex = 0;
        let firstClick = true; // Flag to check if it's the first click

        function addMarker(lat, lng, isNew) {
            let marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            markers[addressIndex] = marker;

            marker.on('dragend', function () {
                let newLat = marker.getLatLng().lat;
                let newLng = marker.getLatLng().lng;
                updateAddress(newLat, newLng, addressIndex);
            });

            if (isNew) {
                map.setView(marker.getLatLng(), 12);
            }

            // Fetch the address and bind it to the marker's popup
            fetch(`https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    let address = data.display_name || 'Unknown location';
                    marker.bindPopup(address).openPopup();
                    document.getElementById('searchBox').value = address;

                })
                .catch(error => console.error('Error fetching address:', error));

            addressIndex++;
        }

        function updateAddress(lat, lng, index) {
            fetch(`https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    let address = data.display_name || 'Unknown location';
                    document.querySelector('.building-input').value = address;
                    document.querySelector('.city-input').value = data.address.city || '';
                    document.querySelector('.state-input').value = data.address.state || '';
                    document.querySelector('.country-input').value = data.address.country || '';
                    document.querySelector('.postcode-input').value = data.address.postcode || '';
                    document.querySelector('.latitude-input').value = lat;
                    document.querySelector('.longitude-input').value = lng;

                    markers[index].bindPopup(address).openPopup();
                    document.getElementById('searchBox').value = address;

                })
                .catch(error => console.error('Error fetching address:', error));
        }

        function removeAddress(button) {
            const section = button.closest('.operation_location_section');
            section.remove();
            markers.pop();
        }

        map.on('click', function (e) {
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;

            if (firstClick) {
                // Add marker and fill address fields with the first click
                addMarker(lat, lng, true);

                fetch(`https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        let address = data.display_name || 'Unknown location';
                        let city = data.address.city || '';
                        let state = data.address.state || '';
                        let country = data.address.country || '';
                        let postcode = data.address.postcode || '';

                        // Fill the first address fields
                        document.querySelector('.building-input').value = address;
                        document.querySelector('.city-input').value = city;
                        document.querySelector('.state-input').value = state;
                        document.querySelector('.country-input').value = country;
                        document.querySelector('.postcode-input').value = postcode;
                        document.querySelector('.latitude-input').value = lat;
                        document.querySelector('.longitude-input').value = lng;
                        markers[addressIndex].bindPopup(address).openPopup();
                        document.getElementById('searchBox').value = address;

                    })
                    .catch(error => console.error('Error fetching address:', error));

                // Set the flag to false after first click
                firstClick = false;
            } else {
                // Add a new section and marker for subsequent clicks
                addMarker(lat, lng, true);

                fetch(`https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        let address = data.display_name || 'Unknown location';
                        let city = data.address.city || '';
                        let state = data.address.state || '';
                        let country = data.address.country || '';
                        let postcode = data.address.postcode || '';

                        addAddress();
                        const addressCount = document.querySelectorAll('.operation_location_section').length - 1;
                        const newSection = document.querySelectorAll('.operation_location_section')[addressCount];

                        newSection.querySelector('.building-input').value = address;
                        newSection.querySelector('.city-input').value = city;
                        newSection.querySelector('.state-input').value = state;
                        newSection.querySelector('.country-input').value = country;
                        newSection.querySelector('.postcode-input').value = postcode;
                        newSection.querySelector('.latitude-input').value = lat;
                        newSection.querySelector('.longitude-input').value = lng;
                        markers[addressIndex - 1].bindPopup(address).openPopup();
                        document.getElementById('searchBox').value = address;

                    })
                    .catch(error => console.error('Error fetching address:', error));
            }
        });

        document.getElementById('searchBox').addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                let searchQuery = event.target.value;
                fetch(`https://us1.locationiq.com/v1/search.php?key=${apiKey}&q=${searchQuery}&format=json`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let lat = data[0].lat;
                            let lng = data[0].lon;
                            addMarker(lat, lng, true); // Add marker for search result
                            updateAddress(lat, lng, addressIndex - 1); // Update address for the new marker
                        }
                    })
                    .catch(error => console.error('Error fetching search results:', error));
            }
        });

    </script>


@endsection
