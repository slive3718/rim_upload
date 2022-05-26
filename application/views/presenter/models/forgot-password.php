<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0D4C93">
                <h5 class="modal-title" id="forgotPasswordModalTitle" style="color:white">Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  style="background-color: #0D4C93">
                <div class="col-auto">
                    <label class="sr-only" for="inlineFormInputGroup">Email</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Email</div>
                        </div>
                        <input type="text" name="emain" id="email"  class="form-control" id="inlineFormInputGroup" placeholder="email">
                    </div>
                </div>

            </div>
            <div class="modal-footer"  style="background-color: #0D4C93">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="forgotPasswordBtn" style="color:white"><i class="fas fa-paper-plane"></i> Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('.forgot-pass').on('click', function(){
            $('#forgotPasswordModal').modal('show');
        })

        $('#forgotPasswordBtn').on('click', function(e){
            e.preventDefault();
            var email = $('#email').val();
            $.post('<?=base_url()?>login/forgot_password',
            {
                'email': email
            },function(response){
                response = JSON.parse(response);
                    console.log(response.msg);
                if(response.msg === 'success'){

                    Swal.fire({
                        title: 'Success',
                        icon: 'success',
                        text: response.status,
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result){
                            $('#forgotPasswordModal').modal('hide');
                        }
                    })

                }else{
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: response.status,
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result){
                            $('#forgotPasswordModal').modal('hide');
                        }
                    })

                }

            })

        })
    })
</script>