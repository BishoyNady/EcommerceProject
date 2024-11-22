<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Stripe;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('usertype','user')->get()->count();
        $product = Product::all()->count();
        $order = Order::all()->count();
        $deliver = Order::where('status','Delivered')->get()->count();
        return view('admin.index',compact('user','product','order','deliver'));
    }
    
    public function home()
    {
        $product = product::all();
        return view('home.index',compact('product'));
    }

    public function login_home()
    {
        $product = product::all();
        return view('home.index',compact('product'));
    }

    public function product_details($id)
    {
        $data = product::find($id);
        return view('home.product_details',compact('data'));
    }
    
    public function add_cart($id)
    {
        $product_id = $id;
        $user_id = Auth::user()->id;

        $data = new Cart;
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $data->save();
        
        toastr()->closeButton()->timeOut(10000)->addSuccess('product added to the cart successfuly');
        return redirect()->back();
    }
    
    public function mycart()
    {
        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id',$user_id)->get();

        return view('home.mycart',compact('cart'));
    }

    public function comfirm_order(Request $request)
    {
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $userid = Auth::User()->id;
        $cart = Cart::where('user_id',$userid)->get();

        foreach($cart as $carts)
        {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $carts->product_id;
            $order->save();
        }

        $cart_remove = Cart::where('user_id',$userid)->get();
        foreach($cart_remove as $remove)
        {
            $data = Cart::find($remove->id);
            $data->delete();
        }
        toastr()->closeButton()->timeOut(10000)->addSuccess('product ordered successfuly');
        return redirect()->back();
    return redirect()->back();
    }
    
    public function remove($id)
    {
        $data = cart::find($id);
        $data->delete();
        toastr()->closeButton()->timeOut(10000)->addSuccess('product deleted successfuly');
        return redirect()->back();

    }

    public function myorders()
    {
        $user = Auth::user()->id;
        $order = Order::where('user_id',$user)->get();
        return view('home.order',compact('order'));
    }

    public function stripe($value)
    {
        return view('home.stripe',compact('value'));
    }

    public function stripePost(Request $request,$value)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    

        Stripe\Charge::create ([

                "amount" => $value * 100,

                "currency" => "usd",

                "source" => $request->stripeToken,

                "description" => "Test payment from complete" 

        ]);

      

        $name = Auth::User()->name;
        $phone = Auth::User()->phone;
        $address = Auth::User()->address;
        $userid = Auth::User()->id;
        $cart = Cart::where('user_id',$userid)->get();

        foreach($cart as $carts)
        {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $carts->product_id;
            $order->payment_status = "paid";
            $order->save();
        }

        $cart_remove = Cart::where('user_id',$userid)->get();
        foreach($cart_remove as $remove)
        {
            $data = Cart::find($remove->id);
            $data->delete();
        }
        toastr()->closeButton()->timeOut(10000)->addSuccess('product ordered successfuly');
        return redirect('mycart');
    

    }

    public function shop()
    {
        $product = product::all();
        return view('home.shop',compact('product'));
    }

    public function why()
    {
        return view('home.why');
    }
}
