<!DOCTYPE html>
<html>
<head>
    <title>Employees</title>
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
    <table id="employees_table" class="table table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>E-mail</th>
            <th>Company</th>
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
                        <label>Enter First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Enter Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" />
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
                        <label>Enter Company</label>
                        <input type="text" name="company_id" id="company_id" class="form-control" />
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
        $('#employees_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxdata1.getdata1') }}",
            "columns":[
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "phone" },
                { "data": "email" },
                { "data": "company_id" },
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
                url:"{{ route('ajaxdata1.postdata1') }}",
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
                        $('#employees_table').DataTable().ajax.reload();
                    }
                }
            })
        });
        $(document).on('click', '.edit', function(){
            var employee_id = $(this).attr("employee_id");
            $('#form_output').html('');
            $.ajax({
                url:"{{route('ajaxdata1.fetchdata1')}}",
                method:'get',
                data:{employee_id:employee_id},
                dataType:'json',
                success:function(data)
                {
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#phone').val(data.phone);
                    $('#email').val(data.email);
                    $('#company_id').val(data.company_id);
                    $('#employee_id').val(employee_id);
                    $('#projectModal').modal('show');
                    $('#action').val('Edit');
                    $('.modal-title').text('Edit Data');
                    $('#button_action').val('update');
                }
            })
        });
        $(document).on('click', '.delete', function(){
            var employee_id = $(this).attr('employee_id');
            if(confirm("Are you sure you want to Delete this data?"))
            {
                $.ajax({
                    url:"{{route('ajaxdata1.removedata1')}}",
                    mehtod:"get",
                    data:{employee_id:employee_id},
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
