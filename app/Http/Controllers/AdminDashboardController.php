<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
class AdminDashboardController extends Controller
{
    public function  index(){
        return view('dashboard');
    }
     public function  adminprofile(){
        return view('layouts.components.profile');
    }
    public function customedit()
    {
      return view('layouts.components.customprofile', [
        'user' => Auth::user()
    ]);

        
    }
      public function custompassedit()
    {
      return view('layouts.components.custompasswordedit', [
        'user' => Auth::user()
    ]);

}
public function setting()
{
    return view('layouts.components.setting');
}
public function admintable()
{
  return view('layouts.components.tables');
}
}

