

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agreement Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
<div class="bg-white shadow-md rounded-lg p-6 w-full max-w-2xl">

    <h1 class="text-2xl font-semibold mb-6 text-center">Welcome to WConsole</h1>
    <p class="mb-6 text-left">This is your agreement to our Master Agreement, Terms of Service, and Service Schedule. I, </p>
    <div>
        <div class="grid grid-cols-2 gap-4 items-center">
            <label class="text-sm font-medium text-gray-700">Username:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ ucwords($consoler->user->name) }}</p>

            <label class="text-sm font-medium text-gray-700">Email Address:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->user->email }}</p>

            <label class="text-sm font-medium text-gray-700">Consoler Name:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ ucwords($consoler->console_name) }}</p>

            <label class="text-sm font-medium text-gray-700">ABN Number:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->abn_number }}</p>

            <label class="text-sm font-medium text-gray-700">Address:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->state }}</p>
        </div>
    </div>
<br>
    <div class="flex items-center">
        <input type="checkbox" id="agree" name="agree" class="mr-2">
        <label for="agree" class="text-sm font-medium">Agree to the following:</label>
    </div>
<br>
    <div>
        <div class="grid grid-cols-2 gap-4 items-center">
            <label class="text-sm font-medium text-gray-700">Billing Commencement Period:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->billing_commencement_period ?? 'N/A' }}</p>

            <label class="text-sm font-medium text-gray-700">Currency:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->currency }}</p>

            <label class="text-sm font-medium text-gray-700">Establishment Fee:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->establishment_fee }}</p>

            <label class="text-sm font-medium text-gray-700">Monthly Subscription Fee:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->monthly_subscription_fee }}</p>

            <label class="text-sm font-medium text-gray-700">Admin Fee for Freelance Buyers:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->admin_fee }}</p>

            <label class="text-sm font-medium text-gray-700">Commission Charge for Freelance Buyers:</label>
            <p class="border-2 rounded-full px-4 py-2 text-sm" style="border-color: #5271FF;">{{ $consoler->comm_charge }}</p>
        </div>
    </div>

    <div class="mt-6">
        <p class="text-sm font-medium text-gray-700 text-left">Agreements:</p>
        <ul class="list-disc pl-5 mt-2 text-left">
            <li>
                Master Agreement with WConsole:
                <a href="{{ asset('storage/' . $admin->master_agreement_for_wconsoler) }}" target="_blank" class=" hover:underline" style="color: #5271FF;">View Agreement</a>
            </li>
            <li>
                Terms of Service with WConsole:
                <a href="{{ asset('storage/' . $admin->terms_conditions_wc_consolers) }}" target="_blank" class=" hover:underline" style="color: #5271FF;">Terms of Service</a>
            </li>
            <li>
                Service Schedule with WConsole:
                <a href="{{ asset('storage/agreements/' . basename($consoler->your_agreement)) }}" target="_blank" class=" hover:underline" style="color: #5271FF;">Service Schedule</a>
            </li>
        </ul>
    </div>


    <div class="flex items-center mt-6">
        <input type="checkbox" id="agree" name="agree" class="mr-2">
        <label for="agree" class="text-sm font-bold text-gray-700 ">I agree to the above Terms and Conditions.</label>
    </div>

    <div>
        <form id="agreement-form" action="{{ route('agreement.submit', [$user->id]) }}" method="POST" class="mt-4">
            @csrf
            <div class="flex justify-end items-center space-x-4">
                <button id="submit-button" type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-full hover:bg-blue-700 hidden">
                    Submit Agreement
                </button>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <span class="border-2 py-2 px-4 rounded-full hover:bg-blue-600 hover:text-white" style="border-color: #5271FF;">
                    Cancel
                </span>
                </a>
            </div>
        </form>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <script>
        const agreeCheckboxes = document.querySelectorAll('input[name="agree"]');
        const submitButton = document.getElementById('submit-button');

        agreeCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const allChecked = Array.from(agreeCheckboxes).every(cb => cb.checked);
                if (allChecked) {
                    submitButton.classList.remove('hidden');
                } else {
                    submitButton.classList.add('hidden');
                }
            });
        });
    </script>

    <div class="text-right mt-4">
        <a href="#" class=" hover:underline" style="color: #5271FF">Queries? Talk to Us.</a>
    </div>
</div>
</body>
</html>
