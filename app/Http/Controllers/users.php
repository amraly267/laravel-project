<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class users extends Controller
{
    function userData(Request $request)
    {
      return response()->cookie('name', 'Amr Aly', 60);
    }
}
