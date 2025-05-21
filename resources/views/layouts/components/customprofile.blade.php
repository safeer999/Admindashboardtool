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
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success">Profile updated successfully.</div>
                @endif

              <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <fieldset>
        <legend class="mb-3">Profile Information</legend>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" id="name" name="name" type="text"
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="phone">Phone</label>
                <input class="form-control" id="phone" name="phone" type="text"
                       value="{{ old('phone', $user->phone) }}" required autocomplete="phone">
                @error('phone') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="cnic">CNIC</label>
                <input class="form-control" id="cnic" name="cnic" type="text"
                       value="{{ old('cnic', $user->cnic) }}" required autocomplete="cnic">
                @error('cnic') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="address">Address</label>
                <input class="form-control" id="address" name="address" type="text"
                       value="{{ old('address', $user->address) }}" required autocomplete="address">
                @error('address') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email"
                       value="{{ old('email', $user->email) }}" required autocomplete="username" readonly>
                @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 text-warning">
                        Your email address is unverified.
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                Click here to re-send the verification email.
                            </button>
                        </form>

                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success mt-1">
                                A new verification link has been sent to your email address.
                            </div>
                        @endif
                    </div>
                @endif
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
