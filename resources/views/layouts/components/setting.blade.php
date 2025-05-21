@extends('layouts.app')

@section('content')

<h3 class="mb-3">Edit Profile</h3>

<div class="row mb-3">
    <div class="col-xl-6">
        <div class="panel panel-inverse" data-sortable-id="form-stuff-11">
            <div class="panel-heading">
                <h4 class="panel-title">Edit Profile</h4>
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

                    <button type="submit" class="btn btn-danger">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
