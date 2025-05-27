@extends('layouts.app')

@section('content')
   <div class="d-flex justify-content-between align-items-center px-4 mb-3">
  <h2 class="mb-0">Edit Profile</h2>
  <span class="text-muted">Profile / Edit Password</span>
</div>


    <div class="row mb-3  px-4">
        <div class="col-xl-12">
            <div class="panel  " data-sortable-id="form-stuff-11">
                <div class="w-100" style="height: 5px; background-color: #00ACAC; margin-bottom: 10px;"></div>

                <div class="panel-heading ">
                    <!-- Top colored line -->
                    <div class="w-100 p-0 m-0">

                        <!-- Heading -->
                        <h4 class="mb-1 px-4">Edit Profile</h4>

                        <!-- Bottom black line -->
                        <div class="" style="height: 2px; background-color: #c7bfbf; margin-bottom: 20px;"></div>
                    </div>





                    <div class="panel-heading-btn">

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
                                        <label class="form-label"  for="current_password">Current Password <span style="color: red">*</span></label>
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
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="password_confirmation">Confirm Password <span style="color: red">*</span></label>
                                        <input placeholder="Confirm Password" class="form-control" id="password_confirmation" name="password_confirmation"
                                            type="password" autocomplete="new-password" required>
                                        @error('password_confirmation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
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
