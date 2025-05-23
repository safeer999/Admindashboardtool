@extends('layouts.app')

@section('content')


<h2 class="mb-3 ">Edit Profile</h2>

<div class="row mb-3">
    <div class="col-12  ">
        <div class="panel   " data-sortable-id="form-stuff-11">
             <div class="w-100" style="height: 5px; background-color: #00ACAC; margin-bottom: 10px;"></div>
                    <div class="panel-heading p-0 m-0">
 <!-- Top colored line -->
 <div class="w-100 p-0 m-0">

<!-- Heading -->
<h4 class="mb-1">Edit Profile</h4>

<!-- Bottom black line -->
<div class="" style="height: 2px; background-color: #c7bfbf; margin-bottom: 20px;"></div>
 </div>
                <div class="panel-heading-btn">
                
                </div>
            </div>

            <div class="panel-body ">
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success">Profile updated successfully.</div>
                @endif

              <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

<fieldset class="w-50"> <!-- full width -->


  <!-- First Row -->
  <div class="row mb-3">
    <div class="col-md-6">
      <label class="form-label" for="first_name">First Name</label>
      <input class="form-control" id="first_name" name="first_name" type="text"
             value="{{ old('first_name', $user->first_name) }}" required autofocus autocomplete="first_name">
      @error('first_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
      <label class="form-label" for="last_name">Last Name</label>
      <input class="form-control" id="last_name" name="last_name" type="text"
             value="{{ old('last_name', $user->last_name) }}" required autocomplete="last_name">
      @error('last_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>
  </div>

  <!-- Second Row -->
  <div class="row mb-3">
    <div class="col-md-6">
      <label class="form-label" for="phone">Phone</label>
      <input class="form-control" id="phone" name="phone" type="text"
             value="{{ old('phone', $user->phone) }}" required autocomplete="phone">
      @error('phone') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </div>

   <div class="col-md-6">
  <label class="form-label" for="address">Address</label>
  <textarea class="form-control" id="address" name="address" rows="3" required autocomplete="address">{{ old('address', $user->address) }}</textarea>
  @error('address') <div class="text-danger mt-1">{{ $message }}</div> @enderror
</div>


  <!-- Third Row - Full width input aligned left -->
  <div class="row mb-3">
    <div class="col-md-6">
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
  </div>

  <!-- Buttons -->
    <div class="col-12 d-flex justify-content-between">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-danger w-100px" style="text: red;">Cancel</a>
                                <button type="submit" class="btn btn-primary w-100px">Save</button>
                            </div>
</fieldset>



</form>

            </div>
        </div>
    </div>
</div>

@endsection
