<title>Admin - LSRS  Presentations</title>

<main role="main" style="margin-top: 70px;margin-left: 20px;margin-right: 20px;">
    <div class="row">
        <div class="col-md-12">
            <h3>Presenters</h3>
            <p>Loaded Presenters are listed here</p>
            <button class="btn btn-info" style="float:right; margin-bottom: 10px" id="addPresenterBtn">Add Presenter</button>
            <div id="lastUpdatedAlert" class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
                This list was last loaded on <strong><span id="lastUpdated"></span></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>

        <div class="col-md-12">
            <table id="presenterTable" class="table table-striped table-bordered" style="width:100%">
                <thead>

                <tr>

                    <th>ID</th>
                    <th>Name Prefix</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Option</th>

                </tr>

                </thead>

                <tbody id="presenterTableBody">
                <!-- Will be filled by JQuery AJAX -->
                </tbody>

            </table>
        </div>

    </div>

    <hr>
</main>
<!-- Add Presenter Modal -->
<div class="modal fade" id="addPresenterModal" tabindex="-1" role="dialog" aria-labelledby="addPresenterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPresenterModalTitle">Add Presenter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Name Prefix</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Name Prefix</div>
                        </div>
                        <input type="text" class="form-control" id="name-prefix" placeholder="">
                    </div>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">First Name</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">First Name</div>
                        </div>
                        <input type="text" class="form-control" id="first-name" placeholder="">
                    </div>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Last Name</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Last Name</div>
                        </div>
                        <input type="text" class="form-control" id="last-name" placeholder="">
                    </div>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Email</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Email</div>
                        </div>
                        <input type="text" class="form-control" id="email" placeholder="">
                    </div>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Password</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Password</div>
                        </div>
                        <input type="text" class="form-control" id="password" placeholder="">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savePresenter">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" crossorigin="anonymous" />

<script>
    $(document).ready(function() {

        loadPresenters();

        $('#presenterTableBody').on('click','.edit-presenter-btn', function () {

            var presenter_id = $(this).attr('data-presenter_id');
            var first_name = $(this).data('first_name');
            var last_name = $(this).data('last_name');
            var email = $(this).data('email');
            var password = $(this).data('password');
            var namePrefix = $(this).data('prefix');

            $('#modalEditPresenter').modal('show');
            $('#modalEditPresenter').find('input[name="presenter_id"]').val(presenter_id);
            $('#modalEditPresenter').find('input[name="first_name"]').val(first_name);
            $('#modalEditPresenter').find('input[name="last_name"]').val(last_name);
            $('#modalEditPresenter').find('input[name="email"]').val(email);
            $('#modalEditPresenter').find('input[name="password"]').val(password);
            $('#modalEditPresenter').find('input[name="name_prefix"]').val(namePrefix);

        });

    });

    $('#addPresenterBtn').on('click', function(e){
        e.preventDefault();
        $('#addPresenterModal').modal('show');

    })

    $('#savePresenter').on('click', function(e){
        e.preventDefault();
        var email = $('#addPresenterModal #email').val();
        var name_prefix = $('#addPresenterModal #name-prefix').val();
        var last_name = $('#addPresenterModal #last-name').val();
        var first_name = $('#addPresenterModal #first-name').val();
        var password = $('#addPresenterModal #password').val();

        $.post('<?=base_url('admin/presenters/add_presenter')?>',
            {
                'email': email,
                'name_prefix': name_prefix,
                'last_name' : last_name,
                'first_name' : first_name,
                'password' : password
            },
            function(response) {
                if (response == 'success') {
                    Swal.fire(
                        'Success',
                        'Presenter Added',
                        'success'
                    )
                }
                else if(response == 'email_exist')
                {
                    Swal.fire(
                        'Sorry',
                        'Email Already Exist',
                        'info'
                    )
                }
            else
                {
                    Swal.fire(
                        'Error',
                        'Something went wrong',
                        'error'
                    )
                }
                $('#addPresenterModal').modal('hide');
        },'json')
    });

    function loadPresenters() {
        $.get( "<?=base_url('admin/presenters/getPresenters')?>", function(response) {
            response = JSON.parse(response);
            console.log(response);
            if ( $.fn.DataTable.isDataTable('#presenterTable') ) {
                $('#presenterTable').DataTable().destroy();
            }

            $('#presenterTableBody').html('');
            $.each(response.data, function(i, presenter) {
                let editBtn = '<button style="width:50%" class="edit-presenter-btn btn btn-sm btn-primary text-white" data-presenter_id = "'+presenter.presenter_id+'" data-first_name = "'+presenter.first_name+'" data-last_name = "'+presenter.last_name+'" data-email = "'+presenter.email+'" data-password = "'+presenter.password+'" data-prefix = "'+presenter.name_prefix+'"><i class="fas fa-edit" ></i> Edit</button>';

                $('#presenterTableBody').append('' +
                    '<tr>\n' +
                    '  <td>'+presenter.presenter_id+'</td>\n' +
                    '  <td>'+presenter.name_prefix+'</td>\n' +
                    '  <td>'+presenter.first_name+' '+presenter.last_name+'</td>\n' +
                    '  <td>'+presenter.email+'</td>\n' +
                    '  <td>\n' +
                    '   '+editBtn+'\n' +
                    '  </td>\n' +
                    '</tr>');
            });

            $('#presenterTable').DataTable({
                initComplete: function() {
                    $(this.api().table().container()).find('input').attr('autocomplete', 'off');
                    $(this.api().table().container()).find('input').attr('type', 'text');
                    $(this.api().table().container()).find('input').val('upload');
                    //$(this.api().table().container()).find('input').val('');
                }
            });
        })
            .fail(function(response) {
                $('#sessionsTable').DataTable();
                toastr.error("Unable to load your presentations data");
            });
    }
</script>

