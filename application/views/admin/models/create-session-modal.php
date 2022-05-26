<!-- Create Session Modal -->
<div class="modal fade" id="createSessionModal" tabindex="-1" role="dialog" aria-labelledby="createSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSessionModalTitle">Create Session</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="addSessionForm" action="" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session Name</span>
                    </div>
                    <input name="session_name" id="session_name" type="text" class="form-control" aria-label="Session Name">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session Full Name</span>
                    </div>
                    <input name="session_full_name" id="session_full_name" type="text" class="form-control" aria-label="Session Full Name">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session Date</span>
                    </div>
                    <input name="session_date" id="session_date" type="date" class="form-control" aria-label="Session Date" >
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session Start Time</span>
                    </div>
                    <input name="session_start" id="session_start" type="time" class="form-control required-field" aria-label="Session Start Time" timeformat="24h" >
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session End Time</span>
                    </div>
                    <input name="session_end" id="session_end" type="time" class="form-control required-field" aria-label="Session End Time" timeformat="24h" >
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="saveSession" type="button" class="btn btn-primary text-white"> Save </button>
                <button id="updateSession" type="button" class="btn btn-primary text-white"> Update </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        let base_url = "<?=base_url()?>";
        $('#saveSession').on('click', function(e){
            e.preventDefault();
            let session_name = $('#session_name').val();
            let session_full_name = $('#session_full_name').val();
            let session_date = $('#session_date').val();
            let session_start = $('#session_start').val();
            let session_end = $('#session_end').val();

            $.post(base_url+'/admin/sessions/saveSession',
                {
                    'session_name': session_name,
                    'session_full_name': session_full_name,
                    'session_date': session_date,
                    'session_start': session_start,
                    'session_end': session_end,
                }, function(response){
                   if(response){
                       Swal.fire(
                            '',
                            response.msg,
                            response.status,
                       )
                   }
                },'json')
        })

        $('#updateSession').on('click', function(){
            let session_name = $('#session_name').val();
            let session_full_name = $('#session_full_name').val();
            let session_date = $('#session_date').val();
            let session_start = $('#session_start').val();
            let session_end = $('#session_end').val();
            let sessionId = $(this).attr('session-id');

            $.post(base_url+'/admin/sessions/updateSession',
                {
                    'sessionId':sessionId,
                    'name': session_name,
                    'full_name': session_full_name,
                    'session_date': session_date,
                    'session_start': session_start,
                    'session_end': session_end
                }, function(response){
                    if(response.status === 'success'){
                        Swal.fire(
                            'Success',
                            'Session Updated',
                            'success'
                        )
                        $('#session_name').val('');
                        $('#session_full_name').val('');
                        $('#session_date').val('');
                        $('#session_start').val('');
                        $('#session_end').val('');
                        getSession();
                    }else{
                        toastr.error(response.msg);
                    }
                }, 'json')
        })
    })

    function editSession(sessionId, name, full_name, session_start, session_end, session_date){

        $('#createSessionModal').modal('show');
        $('#session_name').val(name);
        $('#session_full_name').val(full_name);
        $('#session_date').val(session_date);
        $('#session_start').val(session_start);
        $('#session_end').val(session_end);
        $('#updateSession').attr('session-id',sessionId);


    }
</script>