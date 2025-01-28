@extends('admin.layouts.app')
@section('headerTitle', 'Edit  Profile')
@section('title','Edit Admin Profile')
@section('content')
    <div class="middle-section">
        <div class="container mt-1">
            <h2 class="ml-2" style="pointer-events: none; user-select: none; color: #5271FF;">Update Profile</h2>
            <form method="POST" action="{{ route('admin.update', $admin->id) }}" enctype="multipart/form-data" id="adminForm">
                @csrf
                @method('PUT')
                <!-- Name -->
                <div class="mb-3 d-flex">
                    <label for="name" class="form-label col-sm-3">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm col-sm-3" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                </div>

                <!-- Contact Person -->
                <div class="mb-3 d-flex">
                    <label for="contact_person" class="form-label col-sm-3">Contact Person</label>
                    <input type="text" class="form-control form-control-sm col-sm-3" id="contact_person" name="contact_person" value="{{ old('contact_person', $admin->contact_person) }}">
                </div>

                <!-- Contact Phone Number -->
                <div class="mb-3 d-flex">
                    <label for="contact_phone_number" class="form-label col-sm-3">Contact Phone Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-3" id="contact_phone_number" name="contact_phone_number" value="{{ old('contact_phone_number', $admin->contact_phone_number) }}">
                </div>

                <!-- Email -->
                <div class="mb-3 d-flex">
                    <label for="email" class="form-label col-sm-3">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-sm col-sm-3" id="email" name="email" value="{{ old('email', $admin->user->email) }}" required>
                </div>

                <!-- Financial Information -->
                <div class="mb-3 d-flex">
                    <label for="abn_number" class="form-label col-sm-3">ABN Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-3" id="abn_number" name="abn_number" value="{{ old('abn_number', $admin->abn_number) }}">
                </div>
                <div class="mb-3 d-flex">
                    <label for="banking_detail" class="form-label col-sm-3">Banking Detail</label>
                    <input type="text" class="form-control form-control-sm col-sm-3" id="banking_detail" name="banking_detail" value="{{ old('banking_detail', $admin->banking_detail) }}">
                </div>
                <div class="mb-3 d-flex">
                    <label for="bsb_number" class="form-label col-sm-3">BSB Number</label>
                    <input type="text" class="form-control form-control-sm col-sm-3" id="bsb_number" name="bsb_number" value="{{ old('bsb_number', $admin->bsb_number) }}">
                </div>

                <!-- File Uploads (Single column with your preferred design) -->
                <div class="mb-3 d-flex">
                    <label for="terms_conditions_wc_partners" class="form-label col-sm-3">Terms for WC Partners (PDF)</label>
                    <input type="file" class="form-control form-control-sm col-sm-3" id="terms_conditions_wc_partners" name="terms_conditions_wc_partners" accept="application/pdf">
                    @if($admin->terms_conditions_wc_partners)
                        <a href="{{ Storage::url($admin->terms_conditions_wc_partners) }}" class="btn  btn-sm" style="color: #5271FF; " target="_blank">View Current PDF</a>
                    @endif
                </div>

                <div class="mb-3 d-flex">
                    <label for="terms_conditions_wc_consolers" class="form-label col-sm-3">Terms for WC Consolers (PDF)</label>
                    <input type="file" class="form-control form-control-sm col-sm-3" id="terms_conditions_wc_consolers" name="terms_conditions_wc_consolers" accept="application/pdf">
                    @if($admin->terms_conditions_wc_consolers)
                        <a href="{{ Storage::url($admin->terms_conditions_wc_consolers) }}" class="btn  btn-sm" style="color: #5271FF; " target="_blank">View Current PDF</a>
                    @endif
                </div>

                <div class="mb-3 d-flex">
                    <label for="privacy_policy_for_all" class="form-label col-sm-3">Privacy Policy (PDF)</label>
                    <input type="file" class="form-control form-control-sm col-sm-3" id="privacy_policy_for_all" name="privacy_policy_for_all" accept="application/pdf">
                    @if($admin->privacy_policy_for_all)
                        <a href="{{ Storage::url($admin->privacy_policy_for_all) }}" class="btn  btn-sm" style="color: #5271FF; " target="_blank">View Current PDF</a>
                    @endif
                </div>

                <div class="mb-3 d-flex">
                    <label for="master_agreement_for_wconsoler" class="form-label col-sm-3">Master Agreement for WC Consoler (PDF)</label>
                    <input type="file" class="form-control form-control-sm col-sm-3" id="master_agreement_for_wconsoler" name="master_agreement_for_wconsoler" accept="application/pdf">
                    @if($admin->master_agreement_for_wconsoler)
                        <a href="{{ Storage::url($admin->master_agreement_for_wconsoler) }}" class="btn  btn-sm" style="color: #5271FF; " target="_blank">View Current PDF</a>
                    @endif
                </div>

                <div class="mb-3 d-flex">
                    <label for="master_agreement_for_partners" class="form-label col-sm-3">Master Agreement for Partners (PDF)</label>
                    <input type="file" class="form-control form-control-sm col-sm-3" id="master_agreement_for_partners" name="master_agreement_for_partners" accept="application/pdf">
                    @if($admin->master_agreement_for_partners)
                        <a href="{{ Storage::url($admin->master_agreement_for_partners) }}" class="btn  btn-sm" style="color: #5271FF;" target="_blank">View Current PDF</a>
                    @endif
                </div>

                <!-- Submit & Cancel Buttons -->
                <div class="d-flex justify-content-start">
                    <a href="{{ route('admin.profile') }}" class="btn btn-light" style="color: #5271FF;">Cancel</a>
                    <button type="submit" class="btn border-2 font-weight-bold" id="submitBtn" style="color: #5271FF; border-color: #5271FF;">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

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
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.onload = () => {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0]; // Format as YYYY-MM-DD
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.value = formattedDate;
        });
    };
</script>
