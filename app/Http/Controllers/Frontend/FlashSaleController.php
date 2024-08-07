<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashSale; 
use App\Models\FlashSaleItem; 
use App\Models\Product;
use Carbon\Carbon;

class FlashSaleController extends Controller
{
    public function index()
    {  
        $flashSaleDate = FlashSale::first() ?? Carbon::now()->format('Y-m-d');
        $flashSaleItems = FlashSaleItem::where('status', 1)->orderBy('id', 'DESC')->paginate(20); 
        return view('frontend.pages.flash-sale', compact( 
            'flashSaleDate',
            'flashSaleItems',
        ));
    }
}
