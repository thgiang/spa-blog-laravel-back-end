<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() {
        $categories = array();
        //$categories[] = array('id' => 0, 'name' => 'Tất cả bài viết', 'slug' => 'tat-ca');
        $categories = array_merge($categories, Category::get()->toArray());

        return response()->json($categories);
    }
}
