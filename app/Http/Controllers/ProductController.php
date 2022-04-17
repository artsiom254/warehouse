<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Article;
use App\Models\Product;
use App\Models\ProductArticles;
use App\Repositories\ArticleRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $products = ProductRepository::productsWithQuantity();

        return Inertia::render('Products', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Inertia\Response
     */
    public function show(Product $product)
    {
        $articles = ArticleRepository::articlesByProduct($product);

        return Inertia::render('ProductView', ['product' => $product, 'articles' => $articles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $postData = $request->validate([
            'id' => 'required',
        ]);
        $product = Product::findOrFail($postData['id']);
        $productArticles = $product->articles()->get();
        foreach ($productArticles as $productArticle) {
            $productArticleData = $productArticle->toArray();
            $productArticle->delete();
            Article::findOrFail($productArticleData['article_id'])->decrement('stock', $productArticleData['amount']);
        }
        $product->delete();
        return redirect()->route('products');
    }

    /**
     * Import products from json file in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        $postData = $request->validate([
            'files' => 'required|mimetypes:application/json',
        ]);
        $file = $postData['files'];
        $fileName = 'products_auth_' . auth()->id() . '_' . time() . '.' . $file->extension();

        $file->move(public_path('import'), $fileName);

        Product::truncate();
        ProductArticles::truncate();

        $json = File::get(public_path("import/" . $fileName));
        $products = json_decode($json);

        foreach ($products->products as $productKey => $product) {
            $created = Product::create([
                "name" => $product->name,
            ]);

            foreach ($product->contain_articles as $key => $value) {
                ProductArticles::create([
                    "product_id" => $created->id,
                    "article_id" => $value->art_id,
                    "amount" => $value->amount_of
                ]);
            }
        }
        return redirect()->route('products');
    }
}
