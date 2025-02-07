
@extends('admin.layouts.app')
@section('headerTitle', 'Add Consoler')
@section('title','Add Consoler')
@section('content')
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
        }
        .suggestions {
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            position: absolute;
            background-color: white;
            width: calc(100% - 2px);
            z-index: 1000;
        }

        .suggestion-item {
            padding: 8px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="middle-section">
    <div class="container mt-1">
        <h2 style="pointer-events: none; user-select: none;">Add Consoler</h2>
        <form method="POST" action="{{ route('consolers.store') }}" enctype="multipart/form-data" id="consolerForm">
            @csrf

            <!-- Name -->
            <div class="mb-3 d-flex">
                <label for="name" class="form-label col-sm-3">UserName <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="name" name="name" required>
            </div>

            <!-- Email -->
            <div class="mb-3 d-flex">
                <label for="email" class="form-label col-sm-3">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control form-control-sm col-sm-3" id="email" name="email" required>
            </div>

            <!-- Password -->
            <div class="mb-3 d-flex">
                <label for="password" class="form-label col-sm-3">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password" name="password" required oninput="validatePassword()">
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 d-flex">
                <label for="password_confirmation" class="form-label col-sm-3">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control form-control-sm col-sm-3" id="password_confirmation" name="password_confirmation" required oninput="validatePassword()">
            </div>
            <div id="passwordError" class="error-message"></div>

            <!-- User Type -->
            <input type="hidden" name="user_type" value="consoler">
            <!-- Status -->
            <input type="hidden" name="status" value="active">

            <!-- Console Name -->
            <div class="mb-3 d-flex">
                <label for="console_name" class="form-label col-sm-3">Consoler Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="console_name" name="console_name" required>
            </div>

            <!-- Contact Person -->
            <div class="mb-3 d-flex">
                <label for="contact_person" class="form-label col-sm-3">Contact Person <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_person" name="contact_person" required>
            </div>

            <!-- Contact Phone Number -->
            <div class="mb-3 d-flex">
                <label for="contact_phone_number" class="form-label col-sm-3">Contact Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="contact_phone_number" name="contact_phone_number" required>
            </div>

            <!-- ABN Number -->
            <div class="mb-3 d-flex">
                <label for="abn_number" class="form-label col-sm-3">ABN <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="abn_number" name="abn_number" maxlength="11" required>
            </div>

            <!-- Operation Location -->
            <div class="mb-3 d-flex row">
                <label for="operation_location" class="form-label col-sm-3 ">Operation Location <span class="text-danger">*</span></label>
                <div class="col-sm-3">
                    <input type="text" class="form-control form-control-sm mb-2" id="building" name="building" placeholder="Building, Apt, Unit" required>
                    <input type="text" class="form-control form-control-sm mb-2" id="city" name="city" placeholder="City" required>
                    <div id="citySuggestions" class="suggestions"></div>

                    <input type="text" class="form-control form-control-sm mb-2" id="state" name="state" placeholder="State" required>
                    <div id="stateSuggestions" class="suggestions"></div>

                    <input type="text" class="form-control form-control-sm mb-2" id="country" name="country" placeholder="Country" required>
                    <div id="countrySuggestions" class="suggestions"></div>

                    <input type="text" class="form-control form-control-sm" id="post_code" name="post_code" placeholder="Post Code" required>
                    <div id="postCodeSuggestions" class="suggestions"></div>
                </div>
            </div>

            <!-- Hidden Latitude and Longitude Fields -->
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">


            <!-- Your Agreement -->
            <div class="mb-3 d-flex">
                <label for="your_agreement" class="form-label col-sm-3">Your Agreement <span class="text-danger">*</span></label>
                <input type="file" class="form-control form-control-sm col-sm-3" id="your_agreement" name="your_agreement" accept="application/pdf" required>
            </div>

            <!-- Billing Commencement Period -->
            <div class="mb-3 d-flex">
                <label for="billing_commencement_period" class="form-label col-sm-3">Billing Commencement Period </label>
                <input type="date" class="form-control form-control-sm col-sm-3" id="billing_commencement_period" name="billing_commencement_period">
            </div>

            <!-- Currency -->
            <div class="mb-3 d-flex">
                <label for="currency" class="form-label col-sm-3">Currency </label>
                <input type="text" class="form-control form-control-sm col-sm-3" id="currency" name="currency" value="AUD" readonly required>
            </div>

            <!-- Fees and Charges -->
            <div class="mb-3 d-flex">
                <label for="establishment_fee" class="form-label col-sm-3">Establishment Fee </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="establishment_fee" name="establishment_fee" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="establishment_fee_date" name="establishment_fee_date">
            </div>

            <div class="mb-3 d-flex">
                <label for="monthly_subscription_fee" class="form-label col-sm-3">Monthly Subscription Fee </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee" name="monthly_subscription_fee" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="monthly_subscription_fee_date" name="monthly_subscription_fee_date">
            </div>
            <div class="mb-3 d-flex">
                <label for="admin_fee" class="form-label col-sm-3">Admin Fee for BC </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="admin_fee" name="admin_fee" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="admin_fee_date" name="admin_fee_date">
            </div>

            <div class="mb-3 d-flex">
                <label for="comm_charge" class="form-label col-sm-3">Comm Charge for BC </label>
                <input type="number" class="form-control form-control-sm col-sm-3" id="comm_charge" name="comm_charge" step="0.01">
                <input type="date" class="form-control form-control-sm col-sm-3" id="comm_charge_date" name="comm_charge_date">
            </div>
            <!-- Buttons -->
            <button type="submit" class="btn btn-success" id="submitBtn" disabled>Save</button>
            <a href="{{ route('consoler.list') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@include('map')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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

    document.getElementById('password').addEventListener('input', validatePassword);
    document.getElementById('password_confirmation').addEventListener('input', validatePassword);
    window.onload = () => {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0]; // Format as YYYY-MM-DD
        document.querySelectorAll('input[type="date"]').forEach(input => {
            if (input.id !== 'billing_commencement_period') {
                input.value = formattedDate;
            }
        });
    };
    const locationInputFields = ['city', 'state', 'country', 'post_code'];
    let locationInput = '';
    locationInputFields.forEach(field => {
        document.getElementById(field).addEventListener('input', function() {
            locationInput = `${document.getElementById('building').value} ${document.getElementById('city').value} ${document.getElementById('state').value} ${document.getElementById('country').value} ${document.getElementById('post_code').value}`;
            getSuggestions(field, locationInput);
        });
    });
    function hideAllSuggestions() {
        const suggestionContainers = document.querySelectorAll('.suggestions');
        suggestionContainers.forEach(container => {
            container.innerHTML = ''; // Clear the suggestions
        });
    }
    document.addEventListener('click', function(event) {
        const isInputClick = event.target.matches('input[type="text"]');
        const isSuggestionClick = event.target.matches('.suggestion-item');
        if (!isInputClick && !isSuggestionClick) {
            hideAllSuggestions();
        }
    });
    async function getSuggestions(field, address) {
        const apiKey = 'pk.c955796f3b0f6ba1fcdf78dc7d754395';
        const url = `https://us1.locationiq.com/v1/autocomplete.php?key=${apiKey}&q=${encodeURIComponent(address)}&format=json`;
        // const url = `https://us1.locationiq.com/v1/autocomplete.php?key=${apiKey}&q=${encodeURIComponent(address)}&countrycodes=au&format=json`;
        try {
            const response = await axios.get(url);
            const suggestions = response.data.slice(0, 5); // Limit to 5 suggestions for simplicity
            const suggestionContainer = document.getElementById(`${field}Suggestions`);
            suggestionContainer.innerHTML = '';
            suggestions.forEach(suggestion => {
                const suggestionItem = document.createElement('div');
                suggestionItem.classList.add('suggestion-item');
                suggestionItem.textContent = suggestion.display_name;
                suggestionItem.addEventListener('click', () => selectSuggestion(field, suggestion));
                suggestionContainer.appendChild(suggestionItem);
            });
        } catch (error) {
            console.error("Error fetching suggestions:", error);
        }
    }
    function selectSuggestion(field, suggestion) {
        document.getElementById(field).value = suggestion[field] || suggestion.display_name;

        if (suggestion.address) {
            const address = suggestion.address;
            if (address.country && document.getElementById('country')) {
                document.getElementById('country').value = address.country;
            }
            if (address.postcode && document.getElementById('post_code')) {
                document.getElementById('post_code').value = address.postcode;
            }
            if (address.state && document.getElementById('state')) {
                document.getElementById('state').value = address.state;
            }
            if (address.city && document.getElementById('city')) {
                document.getElementById('city').value = address.city;
            }
            let building = suggestion.display_name;
            if (address.city) {
                building = building.replace(address.city, "").trim();
            }
            if (address.state) {
                building = building.replace(address.state, "").trim();
            }
            if (address.country) {
                building = building.replace(address.country, "").trim();
            }
            if (address.postcode) {
                building = building.replace(address.postcode, "").trim();
            }

            // Set remaining address to the building input
            if (document.getElementById('building')) {
                document.getElementById('building').value = building;
            }
        }

        // Clear suggestions dropdown
        document.getElementById(`${field}Suggestions`).innerHTML = '';

        // Set latitude and longitude if available
        if (suggestion.lat && suggestion.lon) {
            document.getElementById('latitude').value = suggestion.lat;
            document.getElementById('longitude').value = suggestion.lon;
        }
    }


</script>

</body>
@endsection
</html>
