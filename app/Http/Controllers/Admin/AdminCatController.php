<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCatController extends Controller
{

    public function index()
    {
        return 'index';
    }




    public function show(string $id)
    {
        return 'show';
    }

    public function update(Request $request, string $id)
    {
        return 'update';
    }

    public function destroy(string $id)
    {
        return 'destroy';
    }
}
