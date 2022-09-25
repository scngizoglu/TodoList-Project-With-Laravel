<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-info">
    <div class="container w-25 mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>To-do List</h3>
                <div class="input-group mb-3">
         <div class="input-group-prepend">
           <span class="input-group-text" id="inputGroup-sizing-default">Search for a task</span>
         </div>
         <input type="text" class="form-control js-search-input" onkeyup="searchTodo()" aria-label="Default" vire:model="searchTerm"aria-describedby="inputGroup-sizing-default">
         </div>
                <form action="{{ route('store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" required placeholder="Add a new task">
                        <button type="submit" class="btn btn-dark btn-sm px-4"><i class="fas fa-plus"></i></button>
                    </div>
                    <div class="input-group">
                        <input type="hidden" name="userId" class="form-control" value="{{Session::get('loginId')}}">
                    </div>
                    </form>
                    @if(count($todolists))
                    <ul class="list-group list-group-flush mt-3">
                        @foreach($todolists as $todolist)
                        <li class="list-group-item" id="{{$todolist->id}}">
                            <form action="{{ route('destroy', $todolist->id) }}" method="post">
                                <label class="js-todo" data-id="{{$todolist->id}}">{{$todolist->content}}</label>
                                @csrf
                                @method('delete')
                                <button type="submit" href="{{ route('destroy', $todolist->id) }}" class="btn btn-link btn-sm float-end"><i class="fas fa-trash"></i></button>
                            </form>
                            <div id="todoButtonItem_{{$todolist->id}}">
                            <a href="javascript:void(0)" data-id="{{$todolist->id}}" data-content="{{ $todolist->content }}"  class="btn btn-link btn-sm float-end js-edit-todo">düzenle</a>
                            <a href="javascript:void(0)" class="btn btn-link btn-sm float-end d-none js-save-button">kaydet</a>
                            <a href="javascript:void(0)" data-id="{{$todolist->id}}" class="btn btn-link btn-sm float-end d-none js-cancel-button">iptal</a>
                            <div class="js-edit-input-div"></div>
                            <div class="alert alert-danger d-none mt-2">Düzenleme işlemi başarısız oldu.</div>
                            </div>                            
                        </li>
                        @endforeach
                        
                    </ul>  
                    <nav aria-label="Pagination" style="display:flex; justify-content:center; align-items:center" class="nav-pagination mt-3">
                      <ul class="pagination" >
                      </ul>
                    </nav>
                    @else
                    <p class="text-center mt-3">No Task</p>
                    @endif 
            </div>
            @if(count($todolists))
            <div class="card-footer" ></div>
               <p style="margin-left:80px" class="js-sum-todo"> {{count($todolists)}} tasks listed.</p>
            @else
            @endif
            <a href="logout" style="margin-left:140px">Log Out</a>
        </div>
    </div>
</body>
</html>
<script>

  var currentPageNumber = 1;
  var showTodosStart = 0;
  var showTodosEnd = 10;
  const url = "{{ route('list-update') }}";
  const token = "{{ csrf_token() }}";

  var todoList = [];
  $('.js-todo').each(function(){
    var item = {
      'id' : $(this).attr('data-id'),
      'content' : $(this).html()
    }
    todoList.push(item);
  });

  paginationManagement(todoList);

  function paginationManagement(todoList){
    if(todoList.length>10){
      $('.nav-pagination').removeClass('d-none');
      var pageCount = Math.ceil(parseFloat(todoList.length / 10));
      for(var i=1; i<=pageCount; i++){
        var pageElement = '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage('+i+')">'+i+'</a></li>';
        $('.pagination').append(pageElement);
      }
      todoList.forEach(function(value,index){
        if(index>9){
          $('#'+value.id).addClass('d-none');
        }
      });
    } else {      
      $('.nav-pagination').addClass('d-none');
    }
    pageItemActive();
  }

  function changePage(pageNumber){
    var pageLimit = 10;
    showTodosStart = (pageNumber-1) * 10;
    showTodosEnd = pageNumber * 10;
    currentPageNumber = pageNumber;
    if(pageNumber<2){
       showTodosStart = 0;
       showTodosEnd = 10;
    }
    
    todoList.forEach(function(value,index){
      var newIndex = index+1;
      if(newIndex>showTodosStart && newIndex<=showTodosEnd){
        $('#'+value.id).removeClass('d-none');
      } else {
        $('#'+value.id).addClass('d-none');
      }
    });
    pageItemActive();
  }

  function pageItemActive(){
    $('.page-item').removeClass('active');
    $('.page-item').each(function(){
      if($(this).children().html()==currentPageNumber){
        $(this).addClass('active');
      }
    });
  }

  function searchTodo(){
    var term = $('.js-search-input').val();
    var search = new RegExp(term , 'i');
    const result = todoList.filter(item => search.test(item.content));
    $('li').addClass('d-none');
    result.forEach(function(value,index){
      $('#'+value.id).removeClass('d-none');
    });
    $('.js-sum-todo').html(result.length+' tasks listed.');
    paginationManagement(result);
  }

  $('.js-edit-todo').click(function(){
    const todoId = $(this).attr('data-id');
    const todoContent = $(this).attr('data-content');
    const editInput = '<input type="text" class="form-control js-edit-input" value="'+todoContent+'">';
    $('#todoButtonItem_'+todoId+' .js-edit-input-div').append(editInput);
    $('#todoButtonItem_'+todoId+' .js-save-button').removeClass('d-none');
    $('#todoButtonItem_'+todoId+' .js-cancel-button').removeClass('d-none');
    $(this).addClass('d-none');

    $('.js-save-button').click(function(){
      const newContent = $('#todoButtonItem_'+todoId+' .js-edit-input-div input').val();
      $.ajax({
        url : url,
        type : 'POST',
        dataType : 'JSON',
        data : {
          _token : token,
          id : todoId,
          content : newContent
        },
        success : function (response){
          if(response.status){
            location.reload();
          } else {
            $('#todoButtonItem_'+todoId+' .alert').removeClass('d-none');
          }
        }
      });
    });
  });

  $('.js-cancel-button').click(function(){
    const todoId = $(this).attr('data-id');
    $('#todoButtonItem_'+todoId+' .js-save-button').addClass('d-none');
    $('#todoButtonItem_'+todoId+' .js-cancel-button').addClass('d-none');
    $('#todoButtonItem_'+todoId+' .js-edit-todo').removeClass('d-none');
    $('#todoButtonItem_'+todoId+' .js-edit-input').remove();
  });
</script>
  