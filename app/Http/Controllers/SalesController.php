<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use \Illuminate\Http\Request;

class SalesController extends Controller
{
    private $salesRepository;
    private $productRepository;
    private $shipping_cost = 10;
    
    public function __construct(SalesRepository $salesRepository, ProductRepository $productRepository) {
        $this->salesRepository = $salesRepository;
        $this->productRepository = $productRepository;
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = $this->salesRepository->all();
        $products = $this->productRepository->all();
        return view('coffee_sales', ['sales' => $sales,'products' => $products]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'product_id' => 'required|exists:App\Models\Product,id'
        ],[
            'quantity.required' => 'A quantity is required',
            'unit_cost.required' => 'A unit cost is required',
            'quantity.numeric' => 'Quantity must be numeric',
            'unit_cost.numeric' => 'Unit cost must be numeric',
        ]);
        try {
            $product_id = $request->get('product_id');
            $product = $this->productRepository->getByColumn($product_id,'id',['id','profit_margin']);
            $unit_cost = $request->get('unit_cost');
            $quantity = $request->get('quantity');
            $cost = $unit_cost * $quantity;
            $cost = round($cost, 2);
            $selling_price = ($cost / (1-$product['profit_margin'])) + $this->shipping_cost;
            $selling_price = round($selling_price, 2);
            $request->merge(['selling_price' => $selling_price, 'cost' => $cost]);
            $request->merge(['product_id' => $product['id']]);
            $this->salesRepository->create($request->only(['quantity','unit_cost','selling_price','cost']));
            return redirect()->back()->withErrors(['msg' => 'Sale successful']);
        } catch (\Exception $e) {
            //Log
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}