@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center px-4 mb-3">
        <h2 class="mb-0">Edit Profile</h2>
        <span class="text-muted">Profile / Edit Password</span>
    </div>

    <div class="row mb-3 px-4">
        <div class="col-xl-12">
            <div class="panel" data-sortable-id="form-stuff-11">
                <div class="w-100" style="height: 5px; background-color: #00ACAC; margin-bottom: 10px;"></div>

                <div class="panel-heading ">
                    <div class="w-100 p-0 m-0">
                        <h4 class="mb-1 px-4">Edit Profile</h4>
                        <div class="" style="height: 2px; background-color: #c7bfbf; margin-bottom: 20px;"></div>
                    </div>
                </div>

                <div class="panel-body ">
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success">Password updated successfully.</div>
                    @endif

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="col-sm-12 col-md-12 col-xl-6 px-4">
                            <fieldset class="">

                                <div class="">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="current_password">Current Password <span style="color: red">*</span></label>
                                        <input placeholder="Current Password" class="form-control" id="current_password" name="current_password"
                                            type="password" autocomplete="current-password" required>
                                        @error('current_password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="password">New Password <span style="color: red">*</span></label>
                                        <input placeholder="New Password" class="form-control" id="password" name="password" type="password"
                                            autocomplete="new-password" required>
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                        {{-- Password Requirements Checklist --}}
                                        <div id="password-requirements" class="mt-2 text-muted small">
                                            <ul class="list-unstyled">
                                                <li id="length-check"><i class="fa fa-times text-danger"></i> At least 8 characters</li>
                                                <li id="uppercase-check"><i class="fa fa-times text-danger"></i> At least one uppercase letter</li>
                                                <li id="lowercase-check"><i class="fa fa-times text-danger"></i> At least one lowercase letter</li>
                                                <li id="number-check"><i class="fa fa-times text-danger"></i> At least one number</li>
                                                <li id="special-check"><i class="fa fa-times text-danger"></i> At least one special character (!@#$%^&*)</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="password_confirmation">Confirm Password <span style="color: red">*</span></label>
                                        <input placeholder="Confirm Password" class="form-control" id="password_confirmation" name="password_confirmation"
                                            type="password" autocomplete="new-password" required>
                                        @error('password_confirmation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                        <div id="confirm-password-match" class="mt-2 text-muted small">
                                            <i class="fa fa-times text-danger"></i> Passwords do not match
                                        </div>
                                    </div>

                                    <div class="col-xl-6 d-flex justify-content-between mb-xl-5 mt-xl-4 mt-sm-5">
                                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-danger w-100px"
                                            style="text: red;">Cancel</a>
                                        <button type="submit" class="btn btn-primary-custom w-100px">Save</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const newPasswordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        const passwordRequirements = document.getElementById('password-requirements');
        const confirmPasswordMatch = document.getElementById('confirm-password-match');

        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const numberCheck = document.getElementById('number-check');
        const specialCheck = document.getElementById('special-check');

        function updateRequirement(element, isValid) {
            const icon = element.querySelector('i');
            if (isValid) {
                icon.classList.remove('fa-times', 'text-danger');
                icon.classList.add('fa-check', 'text-success');
            } else {
                icon.classList.remove('fa-check', 'text-success');
                icon.classList.add('fa-times', 'text-danger');
            }
        }

        function checkPasswordRequirements() {
            const password = newPasswordField.value;

            // Length
            const hasLength = password.length >= 8;
            updateRequirement(lengthCheck, hasLength);

            // Uppercase
            const hasUppercase = /[A-Z]/.test(password);
            updateRequirement(uppercaseCheck, hasUppercase);

            // Lowercase
            const hasLowercase = /[a-z]/.test(password);
            updateRequirement(lowercaseCheck, hasLowercase);

            // Number
            const hasNumber = /[0-9]/.test(password);
            updateRequirement(numberCheck, hasNumber);

            // Special Character (Common special characters)
            const hasSpecial = /[!@#$%^&*()]/.test(password);
            updateRequirement(specialCheck, hasSpecial);
        }

        function checkConfirmPassword() {
            const password = newPasswordField.value;
            const confirmPassword = confirmPasswordField.value;
            const passwordsMatch = password === confirmPassword && confirmPassword !== '';

            const icon = confirmPasswordMatch.querySelector('i');
            if (passwordsMatch) {
                icon.classList.remove('fa-times', 'text-danger');
                icon.classList.add('fa-check', 'text-success');
                confirmPasswordMatch.textContent = 'Passwords match'; // Update text
            } else {
                icon.classList.remove('fa-check', 'text-success');
                icon.classList.add('fa-times', 'text-danger');
                confirmPasswordMatch.textContent = 'Passwords do not match'; // Update text
            }
        }

        newPasswordField.addEventListener('input', function() {
            checkPasswordRequirements();
            checkConfirmPassword(); // Also check confirm password when new password changes
        });

        confirmPasswordField.addEventListener('input', checkConfirmPassword);

        // Initial checks on page load (if fields might have pre-filled values)
        checkPasswordRequirements();
        checkConfirmPassword();
    });
</script>
@endpush