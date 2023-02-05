<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Mediafile;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category = null)
    {
        if ($category) {
            return view('category-index', ['categories' => Category::where([['parent_id','=',$category->id]])->orderByDesc('id')->paginate(10)]);
        } else {
            return view('category-index', ['categories' => Category::orderByDesc('id')->paginate(10)]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category-edit', ['edit' => 0, 'category' => new Category(), 'categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create($validated);
        if ($request->input('setpicture') == 'setpicture') {
            return redirect()->route('categories.setpicture', $category);
        } else {
            return redirect()->route('categories.show', $category);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request)
    {
        $sort_by_date = $request->input('sort_by_date');
        $sort_by_comments = $request->input('sort_by_comments');
        $order_by_date = FALSE;
        $order_by_comments = FALSE;
        if ($sort_by_date == 2) {
            $order_by_date = 'asc';
        } elseif ($sort_by_date == 1) {
            $order_by_date = 'desc';
        }
        if ($sort_by_comments == 2) {
            $order_by_comments = 'asc';
        } elseif ($sort_by_comments == 1) {
            $order_by_comments = 'desc';
        }
        $products = FALSE;
        // SELECT *, (SELECT COUNT(*) FROM `comments` WHERE `comments`.`product_id` = `products`.`id`) AS `CountComments` FROM `products` WHERE `category_id`=1 ORDER BY `CountComments`;
        if ($order_by_date) {
            $products = Product::where([['category_id','=',$category->id]])->orderBy('created_at', $order_by_date)->paginate(10);
        } elseif ($order_by_comments) {
            $products = Product::selectRaw('*, (SELECT COUNT(*) FROM `comments` WHERE `comments`.`product_id` = `products`.`id`) AS `CountComments`')->where([['category_id','=',$category->id]])->orderBy('CountComments', $order_by_comments)->paginate(10);
        } elseif (($order_by_comments) && ($order_by_date)) {
            $products = Product::selectRaw('*, (SELECT COUNT(*) FROM `comments` WHERE `comments`.`product_id` = `products`.`id`) AS `CountComments`')->where([['category_id','=',$category->id]])->orderBy('created_at', $order_by_date)->orderBy('CountComments', $order_by_comments)->paginate(10);
        } else {
            $products = Product::where([['category_id','=',$category->id]])->paginate(10);
        }
        return view('category-show', ['category' => $category, 'products' => $products, 'sort_by_comments' => $sort_by_comments, 'sort_by_date' => $sort_by_date]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('category-edit', ['edit' => 1, 'category' => $category, 'categories' => Category::where([['id','<>',$category->id]])->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $category->fill($validated);
        $category->save();
        if ($request->input('setpicture') == 'setpicture') {
            return redirect()->route('categories.setpicture', $category);
        } else {
            return redirect()->route('categories.show', $category);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');
    }

    public function setpicture(Category $category)
    {
        return view('category-setpicture', ['category' => $category, 'mediafiles' => Mediafile::orderByDesc('id')->paginate(10)]);
    }
}
