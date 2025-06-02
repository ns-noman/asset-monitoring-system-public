<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getRelatedCatIds($cat_id)
    {
        $category = Category::find($cat_id);
        if (!$category) {
            return [];
        }
        $category_ids = [$cat_id];
        if (!$category->parent_cat_id) {
            $child_ids = Category::where('parent_cat_id', $cat_id)->pluck('id')->toArray();
            $category_ids = array_merge($category_ids, $child_ids);
        }
        return $category_ids;
    }
}
