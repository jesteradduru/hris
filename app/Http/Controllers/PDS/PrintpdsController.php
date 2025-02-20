<?php

namespace App\Http\Controllers\PDS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrintpdsController extends Controller
{
 public function index(Request $request){
    return inertia("Profile/PDS/PDSForm/MainLayout", [
        "personal_information" => $request->user()->personal_information,
        "profile" => $request->user()
    ]);
 }
}
