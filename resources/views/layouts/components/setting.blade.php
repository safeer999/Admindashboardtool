@extends('layouts.app')

@section('content')
    <h3 class="mb-3 px-4">Edit profile</h3>

    <div class="row mb-3 px-xl-4 px-md-3 ">
        <div class="col-12">
            <div class="panel " data-sortable-id="form-stuff-11">
                <div class="w-100" style="height: 5px; background-color: #00ACAC; margin-bottom: 10px;"></div>
                <div class="panel-heading p-0 m-0">
                    <!-- Top colored line -->
                    <div class="w-100 p-0 m-0">

                        <!-- Heading -->
                        <h4 class="mb-1 px-5">Edit Profile</h4>

                        <!-- Bottom black line -->
                        <div class="" style="height: 2px; background-color: #c7bfbf; margin-bottom: 20px;"></div>
                    </div>


                </div>

                <div class="col-sm-12 col-md-12 col-xl-6 px-xl-5">
                    <h5 class="mb-3 text-danger">
                        Once your account is deleted, all of its resources and data will be permanently deleted.
                        Please download any information you want to keep.
                    </h5>

                    <form method="POST" action="{{ route('profile.destroy') }}"
                        onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="current_password">Current Password *</label>
                                <input class="form-control" id="password" name="password" type="password"
                                    autocomplete="current-password">
                                @error('current_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>



                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>
                        <div class="col-12 d-flex justify-content-between mb-xl-5 mt-xl-5">
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-danger"
                                style="text-color:red; width:100px">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="text-color:red">
                                Delete Account
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
