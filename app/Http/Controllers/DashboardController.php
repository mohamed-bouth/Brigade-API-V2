<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Plat;
use App\Models\Ingredient;
use App\Models\Recommendation;
use Nette\Utils\Json;

class DashboardController extends Controller
{
    public function index(){
        $userCount = User::count();
        $categoriesCount = Category::count();
        $platsCount = Plat::count();
        $ingredientsCount = Ingredient::count();
        $recommmendationsCount = Recommendation::count();

        return response()->json([
            'message' => 'this is dashboard static',
            'userCount' => $userCount,
            'categoriesCount' => $categoriesCount,
            'platsCount' => $platsCount,
            'ingredientsCount' => $ingredientsCount,
            'recommmendationsCount' => $recommmendationsCount
        ]);
    }
}
