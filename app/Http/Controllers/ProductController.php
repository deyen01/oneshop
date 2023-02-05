<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mediafile;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product-index', ['products' => Product::orderByDesc('id')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product-edit', ['edit' => 0, 'product' => new Product(), 'categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);
        if ($request->input('setpicture') == 'setpicture') {
            return redirect()->route('products.setpicture', $product);
        } else {
            return redirect()->route('products.show', $product);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product-show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product-edit', ['edit' => 1, 'product' => $product, 'categories' => Category::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $product->fill($validated);
        $product->save();
        if ($request->input('setpicture') == 'setpicture') {
            return redirect()->route('products.setpicture', $product);
        } else {
            return redirect()->route('products.show', $product);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function favadd(Product $product)
    {
        DB::table('user_product')->insert([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'created_at' => now()
        ]);
        return redirect()->route('products.show', $product);
    }

    public function favdel(Product $product)
    {
        DB::table('user_product')->where([
            ['user_id', '=', Auth::id()],
            ['product_id', '=', $product->id]
        ])->delete();
        return redirect()->route('products.show', $product);
    }

    public function setpicture(Product $product)
    {
        return view('product-setpicture', ['product' => $product, 'mediafiles' => Mediafile::orderByDesc('id')->paginate(10)]);
    }
}
