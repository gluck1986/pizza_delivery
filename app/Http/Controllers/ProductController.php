<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductEditRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->only(['store', 'update', 'destroy']);
        $this->middleware('can:write,'.Product::class)
            ->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Responsable
     */
    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        throw new NotFoundHttpException();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCreateRequest $productCreate
     *
     * @return Responsable
     */
    public function store(ProductCreateRequest $productCreate)
    {
        $product = Product::create($productCreate->all());

        return $this->show($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     *
     * @return Responsable
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     *
     * @return Response
     */
    public function edit(Product $product)
    {
        throw new NotFoundHttpException();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductEditRequest  $request
     * @param Product $product
     *
     * @return ProductResource|Responsable|Response
     */
    public function update(ProductEditRequest $request, Product $product)
    {

        $product->update($request->all());

        return $this->show($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product  $product
     *
     * @return Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return true;
    }
}
