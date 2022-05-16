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
        return view('coffee_sales', ['sales' => $sales]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric'
        ],[
            'quantity.required' => 'A quantity is required',
            'unit_cost.required' => 'A unit cost is required',
            'quantity.numeric' => 'Quantity must be numeric',
            'unit_cost.numeric' => 'Unit cost must be numeric',
        ]);
        try {
            $product_id = $this->productRepository->getByColumn('gold_coffee','slug',['id','profit_margin']);
            $unit_cost = $request->get('unit_cost');
            $quantity = $request->get('quantity');
            $cost = $unit_cost * $quantity;
            $cost = number_format((float)$cost, 2, '.', '');
            $selling_price = ($cost / (1-$product_id['profit_margin'])) + $this->shipping_cost;
            $selling_price = number_format((float)$selling_price, 2, '.', '');
            $request->merge(['selling_price' => $selling_price, 'cost' => $cost]);
            $request->merge(['product_id' => $product_id['id']]);
            $this->salesRepository->create($request->only(['quantity','unit_cost','selling_price','cost']));
            return redirect()->back()->withErrors(['msg' => 'Sale successful']);
        } catch (\Exception $e) {
            //Log
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}