<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data; // Replace with your model


class AutoDataRefreshController extends Controller
{
    public function getData()
    {
        $data = Data::all(); // Example: Fetch data from database

        return response()->json($data);
    }
}
