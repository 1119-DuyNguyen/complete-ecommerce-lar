<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $id=Auth::user()->id;


        $totalOrders = Order::count();
        $totalPendingOrders = Order::where('order_status', 'pending')->where('user_id',  $id)->count();
        $totalCanceledOrders = Order::where('order_status', 'canceled')->where('user_id',  $id)->count();
        $totalCompleteOrders = Order::where('order_status', 'delivered')->where('user_id',  $id)->count();





        return view('frontend.dashboard.dashboard', compact(

            'totalOrders',
            'totalPendingOrders',
            'totalCanceledOrders',
            'totalCompleteOrders',

        ));
//        return view('frontend.dashboard.dashboard', compact(
//            'totalOrders',
//            'totalPendingOrders',
//            'totalCompleteOrders',
//            'totalReviews',
//            'wishlist'
//        ));
    }
}
