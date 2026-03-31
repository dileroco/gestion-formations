<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'results' => [],
            ]);
        }

        return view('admin.search');
    }
}
