<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="bg-info">
    <div class="container w-25 mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>To-do List</h3>
                <form action="{{ route('store') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="Yeni Bir Görev Ekleyin">
                        <button type="submit" class="btn btn-dark btn-sm px-4"><i class="fas fa-plus"></i></button>
                    </div>
                    </form>
                    @if(count($todolists))
                    <ul class="list-group list-group-flush mt-3">
                        @foreach($todolists as $todolist)
                        <li class="list-group-item">
                            <form action="{{route('destroy', $todolist->id) }}">
                                {{$todolist->content}}
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-link btn-sm float-end"><i class="fas fa-trash"></i></button>
                            </form>
                        </li>
                        @endforeach
                    </ul>  
                    @else
                    <p class="text-center mt-3">Görev Yok</p>
                    @endif 
            </div>
            @if(count($todolists))
            <div class="card-footer" ></div>
               <p style="margin-left:80px"> {{count($todolists)}} göreviniz bulunmaktadır.</p>
            @else
            @endif
        </div>
    </div>



</body>
</html>