<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMediafileRequest;
use App\Http\Requests\UpdateMediafileRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
use App\Models\Mediafile;

class MediafileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mediafile', ['mediafiles' => Mediafile::orderByDesc('id')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mediafile-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMediafileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediafileRequest $request)
    {
        $validated = $request->validated();
        if ($request->file('mediafile')->isValid()) {
            $mid = 0;
            $tempuri = $request->file('mediafile')->store('public');
            $temphash = hash_file('sha256', Storage::path($tempuri), true);
            $efile = Mediafile::where('sha256checksum', $temphash)->first();
            if ($efile) {
                Storage::delete($tempuri);
                $mid = $efile->id;
            } else {
                $m = new Mediafile;
                $m->uri = $tempuri;
                $m->sha256checksum = $temphash;
                $m->save();
                $mid = $m->id;
            }
            if ($request->input('category_id') > 0)
            {
                $category = Category::findOrFail($request->input('category_id'));
                $category->picture_id = $mid;
                $category->save();
                return redirect()->route('categories.show', $category);
            } elseif ($request->input('product_id') > 0)
            {
                $product = Product::findOrFail($request->input('product_id'));
                $product->picture_id = $mid;
                $product->save();
                return redirect()->route('products.show', $product);
            } else {
                return redirect()->route('mediafiles.index');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mediafile  $mediafile
     * @return \Illuminate\Http\Response
     */
    public function show(Mediafile $mediafile)
    {
        return view('mediafile', ['mediafiles' => [$mediafile]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mediafile  $mediafile
     * @return \Illuminate\Http\Response
     */
    public function edit(Mediafile $mediafile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMediafileRequest  $request
     * @param  \App\Models\Mediafile  $mediafile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMediafileRequest $request, Mediafile $mediafile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mediafile  $mediafile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mediafile $mediafile)
    {
        Storage::delete($mediafile->uri);
        if (Storage::missing($mediafile->uri))
        {
            $mediafile->delete();
        }
        return redirect()->route('mediafiles.index');
    }

    public function attach(Request $request)
    {
        if ($request->input('category_id') > 0)
        {
            $category = Category::findOrFail($request->input('category_id'));
            $category->picture_id = $request->input('picture_id');
            $category->save();
            return redirect()->route('categories.show', $category);
        } elseif ($request->input('product_id') > 0)
        {
            $product = Product::findOrFail($request->input('product_id'));
            $product->picture_id = $request->input('picture_id');
            $product->save();
            return redirect()->route('products.show', $product);
        }
    }
}
