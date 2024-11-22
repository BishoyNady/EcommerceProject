<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style>
        input[type='text']
        {
            width: 400px;
            height: 50px;
        }
        
        .div_deg
        {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px;           
        }

        .table_deg
        {
          text-align: center;
          margin: auto;
          border: 2px solid yellowgreen;
          margin-top: 50px;
          width: 600px;
        }

        th
        {
          background-color: skyblue;
          padding: 15px;
          font-size: 20px;
          font-weight: bold;
          color: white;
        }

        td
        {
          color: white;
          padding: 10px;
          border: 1px solid skyblue;
        }
    </style>
</head>
<body>
      @include('admin.header')
      
      @include('admin.sidebar')
      
      <!-- Sidebar Navigation end-->
      <div class="page-content">
          <div class="page-header">
              <div class="container-fluid">
                  
                  <h1 style="color:white;">Add category</h1>

                  <div class="div_deg">

                 <form action="{{url('add_category')}}" method="post">
                    @csrf
                    <div>
                        <input type="text" name="category">
                        <input class="btn btn-primary" type="submit" value="Add Category">
                    </div>
                 </form>
                 </div>
                 
        </div>
        
      </div>
      <div>
                  <table class="table_deg">
                    <tr>
                      <th>category Name</th>
                      <th>Delete </th>
                      <th>Edit </th>
                    </tr>
                    @foreach($data as $data)
                    <tr>
                      <td>{{$data->category_name}}</td>
                      <td>
                        <a href="{{url('delete_category',$data->id)}}" 
                        onclick="confirmation(event)"class="btn btn-danger">Delete</a>
                      </td>

                      <td>
                      <a class="btn btn-success" 
												data-cat_id="{{$data->id}}"
													data-cat_name="{{$data->category_name}}" 
													 data-toggle="modal" href="#modaldemo8"
													title="Edit">Edit</a>
                      </td>

                    </tr>
                    @endforeach
                  </table>
                 </div>

                 <div class="modal" id="modaldemo8">
<div class="modal-dialog" role="document">
<div class="modal-content modal-content-demo">
<div class="modal-header">
<h6 class="modal-title">Edit Category  </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<form action="{{url('edit_category')}}" method="post" autocomplete="off">
@csrf
@method('Post')

<div class="form-group">
	<input type="hidden" name="cat_id" id="cat_id" value="">
<label for="exampleInputEmail1">Name </label>
<input type="text" class="form-control" id="cat_name" name="cat_name" >
</div>




<div class="modal-footer">
<button type="submit" class="btn btn-success">Edit </button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</form>
</div>
</div>
</div>
    </div>
    <!-- JavaScript files-->

    <script>
      function confirmation(ev)
      {
        ev.preventDefault();
        var urlToRedirect = ev.currentTarget.getAttribute('href');
        console.log(urlToRedirect);

        swal({
          title: "Are You Sure to Delete This",
          text: "this delete will parmanent",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })

        .then((willCancel)=>{
          if(willCancel)
        {
          window.location.href=urlToRedirect;
        }
        })
        
      }
    </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
     <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
     <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
     <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
     <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
     <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
    <script src="{{asset('admincss/js/modal.js')}}"></script>

    <script>
      $('#modaldemo8').on('show.bs.modal' , function(event){
        var button = $(event.relatedTarget)
        var cat_name = button.data('cat_name')
        var cat_id = button.data('cat_id')
        var modal = $(this)
        modal.find('.modal-body #cat_name').val(cat_name);
        modal.find('.modal-body #cat_id').val(cat_id);
      })
    </script>
  </body>
</html>