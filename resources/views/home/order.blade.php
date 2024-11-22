<!DOCTYPE html>
<html>

<head>
 @include('home.css')

 <style>
     table
        {
            border: 2px solid black;
            text-align: center;
           width: 800px;
            
        }

        th
        {
          border: 2px solid black;
          background-color: black;
          padding: 10px;
          font-size: 18px;
          font-weight: bold;
          text-align: center;
          color: white;
        }

        .div_center
        {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        td
        {
            border: 2px solid black;
          color: black;
          padding: 10px;
          
          text-align: center;
        }
 </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
   @include('home.header')
    <!-- end header section -->

  </div>
  <!-- end hero area -->
   <div class="div_center">
    <table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Delivery Status</th>
            <th>Image</th>
        </tr>
        @foreach($order as $order)
        <tr>
            <td>{{$order->product->title}}</td>
            <td>{{$order->product->price}}</td>
            <td>{{$order->status}}</td>
            <td>
                <img width="100" src="/products/{{$order->product->image}}" alt="">
            </td>
        </tr>
        @endforeach
    </table>
   </div>

 
  
  
  
  
  
  
  

  
  
  
  <!-- info section -->
  
  @include('home.footer')
  

</body>

</html>