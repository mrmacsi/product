<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\SalesRepository;
use App\Repositories\ShipmentRepository;
use \Illuminate\Http\Request;

class SalesController extends Controller
{
    private $salesRepository;
    private $productRepository;
    private $shipmentRepository;
    
    public function __construct(SalesRepository $salesRepository, ProductRepository $productRepository, ShipmentRepository $shipmentRepository) {
        $this->salesRepository = $salesRepository;
        $this->productRepository = $productRepository;
        $this->shipmentRepository = $shipmentRepository;
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = $this->salesRepository->orderBy('id','desc')->get();
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
            $shipment_cost = $this->shipmentRepository->getByColumn(1,'active',['cost'])['cost'];
            $unit_cost = $request->get('unit_cost');
            $quantity = $request->get('quantity');
            $cost = $unit_cost * $quantity;
            $cost = round($cost, 2);
            $selling_price = ($cost / (1-$product['profit_margin'])) + $shipment_cost;
            $selling_price = round($selling_price, 2);
            $request->merge(['selling_price' => $selling_price, 'cost' => $cost]);
            $request->merge(['product_id' => $product['id']]);
            $request->merge(['shipping_cost' => $shipment_cost]);
            $request->merge(['sold_at' => \Carbon\Carbon::now()->toDateTimeString()]);
            $this->salesRepository->create($request->only(['quantity','unit_cost','selling_price','cost','sold_at', 'shipping_cost']));
            return redirect()->back()->with(['msg' => 'Sale successful']);
        } catch (\Exception $e) {
            //Log
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
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
            $shipment_cost = $this->shipmentRepository->getByColumn(1,'active',['cost'])['cost'];
            $unit_cost = $request->get('unit_cost');
            $quantity = $request->get('quantity');
            $cost = $unit_cost * $quantity;
            $cost = round($cost, 2);
            $selling_price = ($cost / (1 - $product['profit_margin'])) + $shipment_cost;
            $selling_price = round($selling_price, 2);
            return ['selling_price' => $selling_price];
        } catch (\Exception $e) {
            //Log
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}