<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.23/dist/sweetalert2.all.min.js"></script>
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Blog Post System</h1>
                <form class="form-row" method="post" id="post-form">
                    @csrf
                    <div id="id-div"></div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" required id="title">
                    </div>
                    <div class="form-group">
                        <label for="title">Details</label>
                        <textarea name="content" row="10" class="form-control" required id="content"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="title"></label>
                        <button type="button" class="btn btn-primary form-control" onclick="storePost()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" style="margin-top:30px;">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table-content">
                        @php
                            $count=1;
                        @endphp
                        @foreach($posts as $post)
                            <tr>
                                <td>{{$count++}}</td>
                                <td>{{$post->title}}</td>
                                <td>{{$post->content}}</td>
                                <td>
                                    <a data-id="{{$post->id}}"
                                    type="button" class="btn btn-warning btn-sm" onclick="editPost(this)">Edit

                                    </a>
                                    <a id="{{$post->id}}" onclick="deletePost()" type="button" class="btn btn-danger btn-sm">Del</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    function storePost(){
        let title=$('#title').val();
        let content=$('#content').val();
        let id=$('#id').val();
        if(title=='' || content==''){
            Swal.fire({
                // icon: 'warning',
                title: 'Oops...',
                text: 'Please fill all the fields!'
            })
            return false;
        }
        $.ajax({
            url:"{{route('post.store')}}",
            method:"POST",
            data:{
                title:title,
                content:content,
                id:id,
                _token:"{{csrf_token()}}"
            },
            success:function(data){
                console.log(data[0])
                if (data[0].success==0) {
                    // Display SweetAlert2 error message for validation errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fix the following errors:',
                        html: Object.values(data[0].errors).join('<br>')
                    });
                } else {
                    let table_content='';
                    let count=1;
                    $.each(data[0].post, function(key, value){
                        table_content+=`
                            <tr>
                                <td>${count++}</td>
                                <td>${value.title}</td>
                                <td>${value.content}</td>
                                <td><a data-id="${value.id}" type="button" class="btn btn-warning btn-sm" onclick="editPost(this)">Edit</a>
                                    <a id="${value.id}" onclick="deletePost()" type="button" class="btn btn-danger btn-sm">Del</a>
                                </td>
                            </tr>
                        `;
                    })
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message
                    });
                    $('#table-content').html(table_content);
                    resetField();
                }
            }
        })
    }
    function editPost(button){
        let row = $(button).closest('tr');
        $('tr').css('background-color', '');
        row.css('background-color', '#e1f2e4');
        let id = $(button).attr('data-id');
        let title = row.find('td:eq(1)').text();
        let content = row.find('td:eq(2)').text();
        $('#title').val(title);
        $('#content').val(content);
        $('#post-form button[type="button"]').text('Update');
        $('#id-div').html('<input type="hidden" name="id" value="'+id+'" id="id">');
    }
    function resetField(){
        $('#id-div').html('');
        $('#post-form button[type="button"]').text('Submit');
        $('#title').val('');
        $('#content').val('');
    }
</script>