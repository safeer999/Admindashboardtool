@extends('layouts.app')

@section('content')
    <h3 class="mb-3">Edit profile</h3>

    <div class="row mb-3">
        <div class="col-xl-6">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-11">
                <div class="panel-heading">
                    <h4 class="panel-title">Delete Acccount</h4>
                </div>

                <div class="panel-body">
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
                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{ url('/dashboard') }}" class="btn btn-secondary w-100px">Cancel</a>
                            <button type="submit" class="btn btn-danger">
                                Delete Account
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
