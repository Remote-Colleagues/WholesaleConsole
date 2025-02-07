
@extends('admin.layouts.app')
@section('headerTitle', 'Add Partner')
@section('title', 'Add Partner')
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Partner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
        }

        .suggestions {
            background-color: white;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            width: 100%;
            z-index: 999;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="middle-section">
    <div class="container mt-1">
        <h2 style="pointer-events: none; user-select: none;">Add Partner</h2>
        <form method="POST" action="{{ route('partners.store') }}" enctype="multipart/form-data" id="partnerForm">
            @csrf

            <!-- Partner Name (for user table) -->
            <div class="mb-3 d-flex">
                <label for="name" class="form-label col-sm-3">User Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="name" name="name" required>
            </div>

            <!-- Email (for user table) -->
            <div class="mb-3 d-flex">
                <label for="email" class="form-label col-sm-3">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm col-sm-3" id="email" name="email" required>
            </div>

            <!-- Password (for user table) -->
            <div class="mb-3 d-flex">
                <label for="password" class="form-label col-sm-3">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password" name="password" required oninput="validatePassword()">
            </div>

            <!-- Confirm Password (for user table) -->
            <div class="mb-3 d-flex">
                <label for="password_confirmation" class="form-label col-sm-3">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password_confirmation" name="password_confirmation" required oninput="validatePassword()">
            </div>
            <div id="passwordError" class="error-message"></div>

            <!-- User Type and Status (for user table) -->
            <input type="hidden" name="user_type" value="partner">
            <input type="hidden" name="status" value="active">

            <!-- Partner Name (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="contact_person" class="form-label col-sm-3">Partner Name</label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="partner_name" name="partner_name" required>
            </div>

            <!-- Contact Person (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="contact_person" class="form-label col-sm-3">Contact Person</label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_person" name="contact_person">
            </div>

            <!-- Contact Phone Number (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="contact_phone_number" class="form-label col-sm-3">Contact Phone Number</label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_phone_number" name="contact_phone_number">
            </div>

            <!-- ABN Number (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="abn_number" class="form-label col-sm-3">ABN</label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="abn_number" name="abn_number" maxlength="11">
            </div>

            <!-- Operation Location (for partner table) -->
            <div class="mb-3 d-flex row">
                <label for="operation_location" class="form-label col-sm-3">Operation Location</label>
                <div class="col-sm-3" id="operation_locations_container">
                    <!-- Initial Address Section -->
                    <div class="operation_location_section mb-3" id="address_1">
                        <input type="text" class="form-control building-input mb-2" name="operation_location[0][building]" placeholder="Building, Apt, Unit" required>
                        <input type="text" class="form-control city-input mb-2" name="operation_location[0][city]" placeholder="City" required>
                        <div class="city-suggestions suggestions"></div>
                        <input type="text" class="form-control state-input mb-2" name="operation_location[0][state]" placeholder="State" required>
                        <div class="state-suggestions suggestions"></div>
                        <input type="text" class="form-control country-input mb-2" name="operation_location[0][country]" placeholder="Country" required>
                        <div class="country-suggestions suggestions"></div>
                        <input type="text" class="form-control postcode-input mb-2" name="operation_location[0][post_code]" placeholder="Post Code" required>
                        <div class="postcode-suggestions suggestions"></div>
                        <input type="hidden" class="latitude-input" name="latitude[0]">
                        <input type="hidden" class="longitude-input" name="longitude[0]">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn border-2 rounded" style="color:#5271FF; border-color: #5271FF;" onclick="addAddress()">Add Another Address</button>
                </div>
            </div>

            <!-- Your Agreement (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="your_agreement" class="form-label col-sm-3">Your Agreement</label>
                <input type="file" class="form-control form-control-sm col-sm-3" id="your_agreement" name="your_agreement" accept="application/pdf">
            </div>

            <!-- Billing Commencement Date (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="billing_commencement_date" class="form-label col-sm-3">Billing Commencement Date</label>
                <input type="date" class="form-control form-control-sm col-sm-3" id="billing_commencement_date" name="billing_commencement_date">
            </div>

            <!-- Establishment Fee (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="establishment_fee" class="form-label col-sm-3">Establishment Fee</label>
                <input type="number" step="0.01" class="form-control form-control-sm col-sm-3" id="establishment_fee" name="establishment_fee">
            </div>
            <!-- Premium Charged-->
            <div class="mb-3 d-flex">
                <label for="premium_charged" class="form-label col-sm-3">Premium Charged</label>
                <input type="number" step="0.01" class="form-control form-control-sm col-sm-3" id="premium_charged" name="premium_charged">
            </div>

            <!-- Monthly Subscription Fee (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="monthly_subscription_fee" class="form-label col-sm-3">Monthly Subscription Fee</label>
                <input type="number" step="0.01" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee" name="monthly_subscription_fee">
            </div>

            <!-- CSV User Number (for partner table) -->
            <div class="mb-3 d-flex">
                <label for="csvusernumber" class="form-label col-sm-3">CSV User Number</label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="csvusernumber" name="csvusernumber" readonly>
            </div>

            <!-- User ID (Hidden) -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <!-- Buttons -->
            <button type="submit" class="btn border-2 rounded " id="submitBtn" style="color:#5271FF; border-color: #5271FF;" disabled>Save</button>
            <a href="{{ route('partner.list') }}" class="btn border-2 " style="color:#5271FF; border-color: #5271FF;">Cancel</a>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
{{--@include('map')--}}
<script>
    // Function to add new address fields
    document.getElementById('operation_locations_container').addEventListener('input', function(e) {
        const input = e.target;
        if (input.classList.contains('city-input')) {
            handleAddressInput(input, 'city');
        } else if (input.classList.contains('state-input')) {
            handleAddressInput(input, 'state');
        } else if (input.classList.contains('country-input')) {
            handleAddressInput(input, 'country');
        } else if (input.classList.contains('postcode-input')) {
            handleAddressInput(input, 'postcode');
        }
    });

    async function handleAddressInput(input, fieldType) {
        const addressSection = input.closest('.operation_location_section');
        const building = addressSection.querySelector('.building-input').value;
        const city = addressSection.querySelector('.city-input').value;
        const state = addressSection.querySelector('.state-input').value;
        const country = addressSection.querySelector('.country-input').value;
        const postcode = addressSection.querySelector('.postcode-input').value;

        const addressQuery = `${building} ${city} ${state} ${country} ${postcode}`.trim();
        const suggestions = await getSuggestions(addressQuery);
        showSuggestions(input, suggestions, fieldType);
    }

    async function getSuggestions(query) {
        const apiKey = 'pk.c955796f3b0f6ba1fcdf78dc7d754395';
        try {
            const response = await axios.get(
                `https://us1.locationiq.com/v1/autocomplete.php?key=${apiKey}&q=${encodeURIComponent(query)}&countrycodes=au&format=json`
            );
            return response.data.slice(0, 5);
        } catch (error) {
            console.error("Error fetching suggestions:", error);
            return [];
        }
    }

    function showSuggestions(input, suggestions, fieldType) {
        const suggestionContainer = input.parentElement.querySelector(`.${fieldType}-suggestions`);
        suggestionContainer.innerHTML = '';

        suggestions.forEach(suggestion => {
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = suggestion.display_name;
            div.onclick = () => selectSuggestion(input, suggestion);
            suggestionContainer.appendChild(div);
        });
    }

    function selectSuggestion(input, suggestion) {
        const addressSection = input.closest('.operation_location_section');
        const address = suggestion.address;

        // Auto-fill known fields
        addressSection.querySelector('.city-input').value = address.city || '';
        addressSection.querySelector('.state-input').value = address.state || '';
        addressSection.querySelector('.country-input').value = address.country || '';
        addressSection.querySelector('.postcode-input').value = address.postcode || '';

        // Auto-fill the 'building' field if available
        let building = '';
        if (address.house_number && address.road) {
            building = `${address.house_number} ${address.road}`;
        } else if (address.road) {
            building = address.road;
        } else if (address.building) {
            building = address.building;
        }
        addressSection.querySelector('.building-input').value = building || '';

        // Update coordinates
        addressSection.querySelector('.latitude-input').value = suggestion.lat;
        addressSection.querySelector('.longitude-input').value = suggestion.lon;

        // Clear suggestions
        addressSection.querySelectorAll('.suggestions').forEach(container => {
            container.innerHTML = '';
        });
    }

    // ... (keep existing addAddress/removeAddress functions, update IDs to classes) ...
    function addAddress() {
        const container = document.getElementById('operation_locations_container');
        const addressCount = container.querySelectorAll('.operation_location_section').length;

        const newSection = document.createElement('div');
        newSection.className = 'operation_location_section mb-3';
        newSection.innerHTML = `
            <input type="text" class="form-control building-input mb-2" name="operation_location[${addressCount}][building]" placeholder="Building, Apt, Unit" required>
            <input type="text" class="form-control city-input mb-2" name="operation_location[${addressCount}][city]" placeholder="City" required>
            <div class="city-suggestions suggestions"></div>
            <input type="text" class="form-control state-input mb-2" name="operation_location[${addressCount}][state]" placeholder="State" required>
            <div class="state-suggestions suggestions"></div>
            <input type="text" class="form-control country-input mb-2" name="operation_location[${addressCount}][country]" placeholder="Country" required>
            <div class="country-suggestions suggestions"></div>
            <input type="text" class="form-control postcode-input mb-2" name="operation_location[${addressCount}][post_code]" placeholder="Post Code" required>
            <div class="postcode-suggestions suggestions"></div>
            <input type="hidden" class="latitude-input" name="latitude[${addressCount}]">
            <input type="hidden" class="longitude-input" name="longitude[${addressCount}]">
            <button type="button" class="btn rounded remove_address_btn" style="color:#5271FF; border-color: #5271FF;" onclick="removeAddress(this)">Remove</button>
        `;

        container.appendChild(newSection);
    }

    function removeAddress(button) {
        button.closest('.operation_location_section').remove();
    }

    function hideAllSuggestions() {
        const suggestionContainers = document.querySelectorAll('.suggestions');
        suggestionContainers.forEach(container => {
            container.innerHTML = ''; // Clear the suggestions
        });
    }
    document.addEventListener('click', function(event) {
        const isInputClick = event.target.matches('input[type="text"]');
        const isSuggestionClick = event.target.matches('.suggestion-item');

        // If the click is outside the input fields and suggestion items, hide all suggestions
        if (!isInputClick && !isSuggestionClick) {
            hideAllSuggestions();
        }
    });

</script>
<script>
    function generateCSVUserNumber() {
        let randomNumber = '';
        for (let i = 0; i < 17; i++) {
            randomNumber += Math.floor(Math.random() * 10);
        }
        document.getElementById('csvusernumber').value = randomNumber;
    }
    window.onload = generateCSVUserNumber;
</script>
<script>
    function validatePassword() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        const errorMessage = document.getElementById('passwordError');
        const submitButton = document.getElementById('submitBtn');

        if (password !== confirmPassword) {
            errorMessage.textContent = "Passwords do not match!";
            submitButton.disabled = true;
        } else {
            errorMessage.textContent = "";
            submitButton.disabled = false;
        }
    }
</script>
</body>
@endsection
</html>

