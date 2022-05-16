<?php

namespace App\Http\Controllers;

use App\Repositories\ShipmentRepository;
use Illuminate\Http\Request;

class ShipmentCostController extends Controller
{
    private $shipmentRepository;
    
    public function __construct(ShipmentRepository $shipmentRepository) {
        $this->shipmentRepository = $shipmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipment_costs = $this->shipmentRepository->orderBy('id','desc')->get();
        return view('shipping_partners', ['shipment_costs'=>$shipment_costs]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cost' => 'required|numeric',
        ],[
            'cost.required' => 'A cost is required',
            'cost.numeric' => 'Cost must be numeric',
        ]);
        try {
            $request->merge(['active' => 1]);
            $this->shipmentRepository->setAllToDeactive();
            $this->shipmentRepository->create($request->only(['cost','active']));
            return redirect()->back()->with(['msg' => 'New shipment price successfully set']);
        } catch (\Exception $e) {
            //Log
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }
}
