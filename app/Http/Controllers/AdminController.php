<?php

namespace App\Http\Controllers;
use App\Models\category;
use App\Models\product;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function view_category()
    {
        $data = category::all();
        return view('admin.category',compact('data'));
    }
    
    public function add_category(Request $request)
    {
        $category = new category();
        $category->category_name = $request->category;
        $category->save();
        
        toastr()->closeButton()->timeOut(10000)->addSuccess('category added successfuly');
        
        return redirect()->back();
    }

    public function delete_category($id)
    {
        $data = category::find($id);
        $data->delete();
        toastr()->closeButton()->timeOut(10000)->addSuccess('category Deleted successfuly');
        return redirect()->back();
    }

    public function edit_category(Request $request)
    {
        $data = category::find($request->cat_id);
        $data->category_name = $request->cat_name;
        $data->save();
        toastr()->closeButton()->timeOut(10000)->addSuccess('category Updated successfuly');
        return redirect()->back();
    }

    public function add_product()
    {
        $category = category::all();
        return view('admin.add_product',compact('category'));
    }
    
    public function upload_product(Request $request)
    {
        $data = new product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;
        $data->category = $request->category;

        $image = $request->image;

        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
          $data->image = $imagename;
        }
        
        $data->save();
        
        toastr()->closeButton()->timeOut(10000)->addSuccess('product added successfuly');
        return redirect()->back();
    }

    public function view_product()
    {
        $product = product::paginate(3);
        return view('admin.view_product',compact('product'));
    }

    public function delete_product($id)
    {
        $data = product::find($id);
        $data->delete();

        $image_path = public_path('products/'.$data->image);
        if(file_exists($image_path))
        {
            unlink($image_path);
        }

        toastr()->closeButton()->timeOut(10000)->addSuccess('product deleted successfuly');
        return redirect()->back();
    }

    public function update_product($id)
    {
        $data = product::find($id);
        $category = Category::all();
        return view('admin.update_page',compact('data','category'));
    }

    public function edit_product(Request $request,$id)
    {
        $data =  product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->quantity;
        $data->category = $request->category;

        $image = $request->image;

        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
          $data->image = $imagename;
        }
        
        $data->save();
        
        toastr()->closeButton()->timeOut(10000)->addSuccess('product Updated successfuly');
        return redirect('/view_product');
    }

    public function product_search(Request $request)
    {
        $search = $request->search;
        $product = product::where('title','LIKE','%'.$search.'%')->orWhere('category','LIKE','%'.$search.'%')->paginate(3);

        return view('admin.view_product',compact('product'));
    }

    public function view_orders()
    {
        $data = Order::all();
        return view('admin.order',compact('data'));
    }

    public function on_the_way($id)
    {
        $data = Order::find($id);
        $data->status = 'On the way';
        $data->save();
        return redirect()->back();
    }

    public function delivered($id)
    {
        $data = Order::find($id);
        $data->status = 'Delivered';
        $data->save();
        return redirect('view_orders');
    }

    public function print_pdf($id)
    {
        $data = Order::find($id);
        $pdf = Pdf::loadView('admin.invoice',compact('data'));
        return $pdf->download('invoice.pdf');
    }
}
