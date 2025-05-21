@extends('layouts.app')

@section('content')

<h3 class="mb-3">Edit Profile</h3>

<div class="row mb-3">
    <div class="col-xl-6">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-11">
            <div class="panel-heading">
                <h4 class="panel-title">Edit Profile</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                </div>
            </div>

            <div class="panel-body">
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success">Password updated successfully.</div>
                @endif

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <fieldset>
                        <legend class="mb-3">Update Password</legend>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="current_password">Current Password *</label>
                                <input class="form-control" id="current_password" name="current_password" type="password" autocomplete="current-password" required>
                                @error('current_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password">New Password *</label>
                                <input class="form-control" id="password" name="password" type="password" autocomplete="new-password" required>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="password_confirmation">Confirm Password *</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ url('/dashboard') }}" class="btn btn-secondary w-100px">Cancel</a>
                                <button type="submit" class="btn btn-primary w-100px">Save</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
