<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*
        SELECT
            `categories`.`id` AS `category_id`,
            `categories`.`title` AS `category_title`,
            COUNT(`comments`.`id`) AS `count_comments`
        FROM
            `categories`
        INNER JOIN `products` ON `products`.`category_id` = `categories`.`id`
        INNER JOIN `comments` ON `comments`.`product_id` = `products`.`id`
        GROUP BY `category_id`
        */
        $popularcats = Category::selectRaw('`categories`.`id` AS `id`, `categories`.`title` AS `title`, `categories`.`picture_id` AS `picture_id`, COUNT(`comments`.`id`) AS `count_comments`')
            ->join('products', 'products.category_id','=','categories.id')
            ->join('comments', 'comments.product_id','=','products.id')
            ->groupBy('id', 'title', 'picture_id')
            ->orderByDesc('count_comments')
            ->paginate(10);
        return view('home', ['favproducts' => Auth::user()->favproducts()->paginate(10), 'popularcats' => $popularcats]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        if (strlen($search) > 0) {
            $searchproducts = Product::where([["title", "like", "%$search%"]])->paginate(10);
            $searchcats = Category::where([["title", "like", "%$search%"]])->paginate(10);
            return view('home', ['search' => $search, 'searchproducts' => $searchproducts, 'searchcats' => $searchcats]);
        }
    }
}
