<!DOCTYPE html>
<html>
<head>
    <title>Companies</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <br />
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
    </div>
    <br />
    <table id="companies_table" class="table table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>E-mail</th>
            <th>Logo</th>
            <th>Website</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>
</div>
<div id="projectModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="project_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Data</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <span id="form_output"></span>
                    <div class="form-group">
                        <label>Enter Name</label>
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Address</label>
                        <input type="text" name="address" id="address" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Phone</label>
                        <input type="number" name="phone" id="phone" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter E-mail</label>
                        <input type="text" name="email" id="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Choose Logo</label>
                        <input type="text" name="logo" id="logo" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Website</label>
                        <input type="text" name="website" id="website" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="button_action" id="button_action" value="insert" />
                    <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#companies_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxdata.getdata') }}",
            "columns":[
                { "data": "name" },
                { "data": "address" },
                { "data": "phone" },
                { "data": "email" },
                { "data": "logo" },
                { "data": "website" },
                { "data": "action", orderable:false, searchable: false}
            ]
        });
        $('#add_data').click(function(){
            $('#projectModal').modal('show');
            $('#project_form')[0].reset();
            $('#form_output').html('');
            $('#button_action').val('insert');
            $('#action').val('Add');
            $('.modal-title').text('Add Data');
        });

        $('#project_form').on('submit', function(event){
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url:"{{ route('ajaxdata.postdata') }}",
                method:"POST",
                data:form_data,
                dataType:"json",
                success:function(data)
                {
                    if(data.error.length > 0)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                        }
                        $('#form_output').html(error_html);
                    }
                    else
                    {
                        $('#form_output').html(data.success);
                        $('#project_form')[0].reset();
                        $('#action').val('Add');
                        $('.modal-title').text('Add Data');
                        $('#button_action').val('insert');
                        $('#companies_table').DataTable().ajax.reload();
                    }
                }
            })
        });
        $(document).on('click', '.edit', function(){
            var id = $(this).attr("company_id");
            $('#form_output').html('');
            $.ajax({
                url:"{{route('ajaxdata.fetchdata')}}",
                method:'get',
                data:{company_id:id},
                dataType:'json',
                success:function(data)
                {
                    $('#name').val(data.name);
                    $('#address').val(data.address);
                    $('#phone').val(data.phone);
                    $('#email').val(data.email);
                    $('#logo').val(data.logo);
                    $('#website').val(data.website);
                    $('#company_id').val(id);
                    $('#projectModal').modal('show');
                    $('#action').val('Edit');
                    $('.modal-title').text('Edit Data');
                    $('#button_action').val('update');
                }
            })
        });
        $(document).on('click', '.delete', function(){
            var company_id = $(this).attr('company_id');
            if(confirm("Are you sure you want to Delete this data?"))
            {
                $.ajax({
                    url:"{{route('ajaxdata.removedata')}}",
                    mehtod:"get",
                    data:{company_id:company_id},
                    success:function(data)
                    {
                        alert(data);
                        $('#companies_table').DataTable().ajax.reload();
                    }
                })
            }
            else
            {
                return false;
            }
        });

    });
</script>

</body>
</html>

