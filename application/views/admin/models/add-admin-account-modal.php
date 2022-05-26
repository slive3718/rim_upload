<!-- Add Admin Modal  -->
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalTitle">Add Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddAccount" action="" method="post">
            <div class="modal-body">



                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Account Type</span>
                    </div>
                    <select id="label"  name="level" class="form-control" aria-label="email">
                        <option value="1"> Super Admin </option>
                        <option value="2"> Client </option>
                        <option value="3"> Tech </option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">First Name</span>
                    </div>
                    <input name="first_name" id="first_name" type="text" class="form-control" aria-label="First Name">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Last Name</span>
                    </div>
                    <input name="last_name" id="last_name" type="text" class="form-control" aria-label="Last Name">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Email</span>
                    </div>
                    <input name="email" id="email" type="text" class="form-control" aria-label="email">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Password</span>
                    </div>
                    <input name="password" id="password" type="text" class="form-control" aria-label="email">
                </div>
                <input type="submit" id="saveAccountBtn" value="Save Account" class="btn btn-primary text-white w-100">

            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" >Reset</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(function(){
        $('.add-account-btn').on('click', function(){
            let url = "<?=base_url().'admin/Account/saveAdminAccount'?>";
            $('#addAdminModal').modal('show')
            $('#formAddAccount').attr('action', url)
        })

        $('#formAddAccount').on('submit',
            function (e) {
            e.preventDefault();
                let values = $(this).serialize();
                Swal.fire({
                    title: 'Confirm Account Information',
                    html: "<br><div>Account type : "+$('#label').find(':selected').text()+"<br> Email : "+$('#email').val()+"<br> Passowrd : "+$('#password').val()+" </div>",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Create it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('#formAddAccount').attr('action'),
                            type: "post",
                            data: values,
                            success: function (response) {
                                response = JSON.parse(response)
                                if(response.status == 'success'){
                                    Swal.fire(
                                        'Success',
                                        response.msg,
                                        'success'
                                    )
                                }else{
                                    Swal.fire(
                                        response.status,
                                        response.msg,
                                        response.icon
                                    )
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                    }
                })
            })
    })
</script>