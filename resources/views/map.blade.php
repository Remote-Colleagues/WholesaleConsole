
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
<div id="map"></div>
@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
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

        const apiKey = 'pk.c955796f3b0f6ba1fcdf78dc7d754395';

        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            updateMarker(lat, lng);
            fetch(`https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    const address = data.address;
                    document.getElementById('building').value = address.building || address.house_number || '';
                    document.getElementById('city').value = address.city || address.town || address.village || '';
                    document.getElementById('state').value = address.state || '';
                    document.getElementById('country').value = address.country || '';
                    document.getElementById('post_code').value = address.postcode || '';
                })
                .catch(error => console.error('Error fetching address:', error));
        });
        function geocodeAddress() {
            let address = document.getElementById('building').value + ', ' +
                document.getElementById('city').value + ', ' +
                document.getElementById('state').value + ', ' +
                document.getElementById('country').value;

            fetch(`https://us1.locationiq.com/v1/search.php?key=${apiKey}&q=${encodeURIComponent(address)}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = data[0].lat;
                        const lng = data[0].lon;
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                        updateMarker(lat, lng);
                    } else {
                        console.error('No results found for the entered address');
                    }
                })
                .catch(error => console.error('Error fetching geocode:', error));
        }
        document.getElementById('building').addEventListener('change', geocodeAddress);
        document.getElementById('city').addEventListener('change', geocodeAddress);
        document.getElementById('state').addEventListener('change', geocodeAddress);
        document.getElementById('country').addEventListener('change', geocodeAddress);

        map.on('zoomend', function () {
            var center = map.getCenter();
            map.setView(center, map.getZoom(), { animate: true });
        });
        // Function to update the marker and show popup with address details
        let marker;
        function updateMarker(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
            map.flyTo([lat, lng], map.getZoom());

            fetch(`https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    const address = data.address;
                    const building = address.building || address.house_number || 'Unknown building';
                    const city = address.city || address.town || address.village || 'Unknown city';
                    const state = address.state || 'Unknown state';
                    const country = address.country || 'Unknown country';
                    const postCode = address.postcode || 'Unknown postcode';

                    marker.bindPopup(`
                        <b>Building:</b> ${building}<br>
                        <b>City:</b> ${city}<br>
                        <b>State:</b> ${state}<br>
                        <b>Country:</b> ${country}<br>
                        <b>Postal Code:</b> ${postCode}
                    `).openPopup();
                })
                .catch(error => console.error('Error fetching address:', error));
        }
    </script>
@endsection
