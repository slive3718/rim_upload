<title>Admin - LSRS  Presentations</title>

<main role="main" style="margin-top: 70px;margin-left: 20px;margin-right: 20px;">
    <div class="row">
        <div class="col-md-12">
            <h3>Sessions</h3>
            <p>Loaded Sessions are listed here</p>
            <div>
                <button class="btn btn-success float-right createSessionBtn"> <i class="fas fa-plus "></i> Create Session</button>
            </div>
            <div>
                <table id="sessionDataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Session Name</th>
                        <th>Session Full Name</th>
                        <th>Session Date</th>
                        <th>Session Start</th>
                        <th>Session End</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="sessionsTableBody">

                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</main>


<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" crossorigin="anonymous" />

<script>
    let base_url = "<?=base_url()?>";
    $(function(){
        getSession();
        $('.createSessionBtn').on('click', function(){
            $('#saveSession').css('display','block')
            $('#updateSession').css('display','none')
            $('#createSessionModal').modal('show');
        })

        $('#sessionDataTable').on('click', '.editSessionBtn', function(){
            let sessionId = $(this).attr('sessionId');
            let name = $(this).attr('session-name');
            let full_name = $(this).attr('session-full_name');
            let session_start = $(this).attr('session-start');
            let session_end = $(this).attr('session-start');
            let session_date = $(this).attr('session-date');

            $('#saveSession').css('display','none')
            $('#updateSession').css('display','block')

            editSession(sessionId, name, full_name, session_start, session_end, session_date);
        })
    })

function getSession(){
    $.post(base_url+'/admin/sessions/getSessions',
        function(response){
            if(response){

                if ( $.fn.DataTable.isDataTable('#sessionDataTable') ) {
                    $('#sessionDataTable').DataTable().destroy();
                }
                response = JSON.parse(response);
                $('#sessionsTableBody').html('');

                $.each(response, function (i, val){
                    let editBtn = '<button class="btn btn-primary btn-sm text-white editSessionBtn" sessionId="'+val.id+'" session-name="'+val.name+'" session-full_name="'+val.full_name+'" session-start="'+val.start_time+'" session-end="'+val.end_time+'" session-date="'+val.session_date+'"><i class="fas fa-edit"></i>Edit</button>';

                    $('#sessionsTableBody').append('' +
                        '<tr>' +
                        '<td>'+val.name+'</td>' +
                        '<td>'+val.full_name+'</td>' +
                        '<td>'+val.session_date+'</td>' +
                        '<td>'+val.start_time+'</td>' +
                        '<td>'+val.end_time+'</td>' +
                        '<td>'+editBtn+'</td>' +
                        '</tr>')
                });
                $('#sessionDataTable').DataTable({
                   
                });
            }
        }) .fail(function(response) {
        $('#sessionDataTable').DataTable();
        toastr.error("Unable to load your presentations data");
    });
}

</script>