<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;

class FormationController extends Controller
{
    public function show(Formation $formation)
    {
        return new FormationResource($formation);
    }
}
