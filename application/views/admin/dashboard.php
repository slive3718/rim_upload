<title>Admin - LSRS  Presentations</title>

<main role="main" style="margin-top: 70px;margin-left: 20px;margin-right: 20px;">
    <div class="row">
        <div class="col-md-12">
            <h3>Presentations</h3>
            <p>Loaded presentations are listed here</p>
            <h6 class="text-info">Tip:  Click on multiple records to group select</h6><br>

            <div id="lastUpdatedAlert" class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
                This list was last loaded on <strong><span id="lastUpdated"></span></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
        <a href="<?=base_url().'admin/dashboard/presentationToCsv'?>" target="_blank" class="btn btn-primary float-left mb-2 text-white ml-3" style="cursor: pointer"><i class="fas fa-file-csv"></i> Export CSV</a>
        <a href="#" target="_blank" class="btn btn-primary float-left mb-2 ml-3 text-white" style="cursor: pointer" id="downloadSelectedPresentation"><i class="fas fa-file-archive"></i> Zip and Download Selected Presentation(s)</a>
        <div class="col-md-12">
            <button class="create-presentation-btn btn btn-success float-right"><i class="fas fa-plus"></i> Create New Presentation</button>
            <button class="select-all-presentation btn btn-info btn-sm mr-2 float-left"><i class="fas fa-check-double"></i> Select All Filtered</button>
            <button class="undowload-selected-presentation btn btn-info btn-sm mr-2 float-left"><i class="fa fa-refresh"></i> Undownload Selected Presentation </button>
            <br><br>

            <div class="row my-4">
                <select class="filterDt filter-status form-control" name="select_status" id="select_status" style="width:200px; margin-right:20px" >
                    <option value="">Select Status</option>
                    <?php if(isset($new_uploads) && !empty($new_uploads)):?>
                        <option value="new-uploads" >New Uploads</option>
                    <?php endif; ?>
                    <option value="active">Active</option>
                    <option value="disabled">Disabled</option>
                </select>
                <select class="filterDt filter-session-date form-control" name="select_session_date" id="select_session_date" style="max-width: 200px; margin-right:20px">
                    <option value="">Session Date</option>
                    <?php if(isset($session_dates) && !empty($session_dates)):?>
                        <?php foreach ($session_dates as $session_date) :?>
                            <option value="<?=($session_date)?>"><?=($session_date)?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <select class="filterDt filter-session-room form-control" name="select_session_room" id="select_session_room" style="max-width: 200px; margin-right:20px">
                    <option value="">Select Room</option>
                    <?php if(isset($rooms) && !empty($rooms)):?>
                        <?php foreach ($rooms as $room) :?>
                            <option value="<?=($room)?>"><?=($room)?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <select class="filterDt filter-session form-control" name="select_session_name" id="select_session_name" style="max-width: 250px; margin-right: 20px">
                    <option value="">Select Session</option>
                    <?php if(isset($session_names) && !empty($session_names)):?>
                        <?php foreach ($session_names as $session_name) :?>
                            <option value="<?=($session_name)?>"><?=($session_name)?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button class="btn btn-warning btn-sm clearFilterBtn">Clear Filter</button>
            </div>
            <h6 class="searching-for"> searching for:  <label id="sf_status" class="text-info"></label> <label id="sf_session_date" style="color: deepskyblue"></label>  <label id="sf_session_room" style="color: green"></label>  <label id="sf_session_name" style="color: violet"></label></h6>
        </div>
        <br>
        <table id="presentationTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <!--                    <th>Select All</th>-->
                <!--                    <th><input type="checkbox" name="check" id="checkAllPresentation">Select All</th>-->
                <th>Status</th>
                <th>ID</th>
                <th>Assigned ID</th>
                <th style=" white-space: nowrap ">Session Date</th>
                <th>Session Time</th>
                <th>Presentation Start</th>
                <th>Room</th>
                <th>Session Name</th>
                <th>Presentation Title</th>
                <th>Presenter FirstName</th>
                <th>Presenter LastName</th>
                <th>Email</th>
                <th>Info</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody id="presentationTableBody">
            <!-- Will be filled by JQuery AJAX -->
            </tbody>

        </table>
    </div>

    </div>

    <hr>
</main>

<div class="modal fade" id="logsModal" tabindex="-1" role="dialog" aria-labelledby="logsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logsModalLabel">Logs (<span id="logPersonName"></span>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="height: 500px;overflow: scroll;">
                <ul id="logsList" class="list-group">
                    <!-- Will be filled by JS -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css" crossorigin="anonymous" />

<style>
    .swal2-timer-progress-bar{
        background: #8cdf11;
    }
</style>
<script>
    let selected = [];
    let allFiltered = [];
    let isAllSelected = false;
    let presentationDt;
    let file_name;
    $(document).ready(function() {

        loadPresentations();

        $('#example-upload-btn').on('click', function () {
            toastr.warning('You need to click one of the similar buttons listed below to upload files.');
        });

        $('.change-pass-btn').on('click', function () {
            $('#changePasswordModal').modal('show');
        });

        $('#presentationTable').on('click', '.files-btn', function () {

            let user_id = $(this).attr('user-id');
            let presentation_id = $(this).attr('presentation-id');
            let presentation_name = $(this).attr('presentation-name');
            let session_name = $(this).attr('session-name');
            let room_id = $(this).attr('room_id');
            let room_name = $(this).attr('room_name');
            let session_date = $(this).attr('session_date');

            showFiles(user_id, presentation_id, session_name, presentation_name, room_id, room_name, session_date);
        });

        $('#presentationTable').on('click', '.details-btn', function () {

            let user_id = $(this).attr('user-id');
            let presentation_id = $(this).attr('presentation-id');
            let presentation_name = $(this).attr('presentation-name');
            let session_name = $(this).attr('session-name');
            let presentation_type = $(this).attr('data-presentation_type');
            let speaker_lname = $(this).attr('speaker_lname');
            let session_id = $(this).attr('session_id');
            let room_id = $(this).attr('room_id');
            let room_name = $(this).attr('room_name');
            let session_date = $(this).attr('session_date');
            let presentation_start = $(this).attr('presentation_start');
            let assigned_id = $(this).attr('assigned-id');

            showUploader(user_id, presentation_id, session_name, presentation_name, presentation_type, speaker_lname, session_id, room_id, room_name, session_date, presentation_start, assigned_id);
        });

        $('#presentationTable').on('click', '.activate-presentation-btn', function () {
            let button = $(this);
            let presentationId = $(this).attr('presentation-id');

            activatePresentation(presentationId, button);
        });

        $('#presentationTable').on('click', '.disable-presentation-btn', function () {
            let button = $(this);
            let presentationId = $(this).attr('presentation-id');

            disablePresentation(presentationId, button);
        });

        $('#presentationTable').on('click', '.presentation-logs-btn', function () {
            toastr['info']('Please wait...');

            let userId = $(this).attr('user-id');
            $.get(`<?=base_url()?>admin/dashboard/getLogs/${userId}`, function (logs) {
                logs=JSON.parse(logs);

                if (logs.length == 0)
                {
                    toastr['warning']('No logs found');
                    return false;
                }

                $('#logPersonName').text(logs[0].first_name+' '+logs[0].last_name);

                $('#logsList').html('');
                $.each(logs, function(i, log){

                    let presentation_name = (log.ref_presentation_id != null)?`<br><span><small>Presentation: ${log.name}</small></span>`:'';
                    let file = (log.other_ref != null)?`<br><span><small>File: <a href="<?=base_url()?>admin/dashboard/openFile/${log.other_ref}">${log.file_name}</a></small></span>`:'';

                    $('#logsList').append('' +
                        `<li class="list-group-item">
                                <i style="color: ${log.color}" class="${log.icon}"></i>
                                ${log.log_name}
                                <small class="float-right">${log.date_time}</small>
                                ${presentation_name}
                                ${file}
                             </li>`);
                });

                $('body').find('#toast-container').remove();
                $('#logsModal').modal('show');
            });
        });

        $('#presentationTable').on('click', '.edit-presentation-btn', function () {
            let button = $(this);
            let presentationId = $(this).attr('presentation-id');
            let upload_status = $(this).attr('upload-status');

            edit_presentation(presentationId, upload_status);
        });

        $('.create-presentation-btn').on('click', function (e) {
            e.preventDefault();
            $('#createPresentationModal').modal('show');
        });


        $('.select-all-presentation').on('click', function(){
            if (isAllSelected == false && selected.length == 0)
            {
                presentationDt.rows().every(function(e) {
                    selected.push(this.nodes().to$().attr("id"));
                    this.nodes().to$().addClass('selected');
                });

                $(this).removeClass('btn-info');
                $(this).addClass('btn-danger');
                $(this).html('<i class="fas fa-ban"></i> Unselect All');
                isAllSelected = true;
            }else{
                selected = [];
                presentationDt.rows().every(function() {
                    this.nodes().to$().removeClass('selected');
                });

                $(this).removeClass('btn-danger');
                $(this).addClass('btn-info');
                $(this).html('<i class="fas fa-check-double"></i> Select All Filtered');
                isAllSelected = false;
            }
        });

        $('#downloadSelectedPresentation').on('click', function(e){
            e.preventDefault();
            //toastr['info']('please wait...')

            var timerInterval
            Swal.fire({
                title: 'Please wait',
                html: 'Compressing files <br> <b></b>',
                timer: 120000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Math.round((Swal.getTimerLeft())/1000) + ' seconds left'
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    toastr['info']('Please wait...');
                    //console.log('I was closed by the timer')
                }
            })

            checkedPresentationIds = selected.join('-')


            $.post('<?=base_url()?>admin/dashboard/download_checked_presentation_zip/',
                {
                    'checkedPresentationIds':checkedPresentationIds
                },
                function(response){
                    response = JSON.parse(response);
                    // console.log(response);return false;
                    if(response.status === 'success'){
                        file_name = response.file_name;
                        toastr.clear();
                        Swal.fire({
                            title: 'Done!',
                            html:`<a id="confirmDownloadZipPresentation" href="#" onclick="confirmDownload(checkedPresentationIds, file_name);"><h3> Click here to Download Files <i class="fas fa-download"></i></h3></a>
                         <br><small class="text-danger">Zipping and downloading files will remove the New Upload status</small>`,
                            icon: 'success',
                            confirmButtonText: 'Close'
                        })
                    }else{
                        toastr.clear();
                        toastr['error'](response.msg);
                    }

                    $.each(selected, function(i, presentation_id){
                        // getUndownloadedData(presentation_id);
                    })
                })
        })

        $('.undowload-selected-presentation').on('click', function(){
            checkedPresentationIds = selected.join('-')

            $.post('<?=base_url()?>admin/dashboard/undownload_checked_presentation/',
                {
                    'checkedPresentationIds':checkedPresentationIds
                },
                function(response){
                    if(response.status === 'success'){
                        toastr.clear();
                        toastr['success'](response.msg)
                        loadPresentations();
                        selected = [];
                    }else{
                        toastr.clear();
                        toastr['error'](response.msg);
                    }
                }, 'json');
        })

        $('.filter-status').val('');
        $('.searching-for').css('display', 'none')
        let filter_array = [];
        $('.filterDt').on('change', function(){
            let data = $(this).val();
            let db_name = $(this).attr('name')
            if(data) {
                if ($.inArray(db_name, filter_array)) {
                    filter_array.push(db_name)
                }
            }else{
                for(var i in filter_array){
                    if(filter_array[i]==db_name){
                        filter_array.splice(i,1);
                        break;
                    }
                }
            }
            if(filter_array.length == 0){
                $('.searching-for').css('display', 'none')
            }else{
                $('.searching-for').css('display', 'block')
            }
            if(db_name == 'select_session_date'){
                $('#sf_session_date').html(data)
            }
            if(db_name == 'select_session_room'){
                $('#sf_session_room').html(data)
            }
            if(db_name == 'select_session_name'){
                $('#sf_session_name').html(data )
            }
            if(db_name == 'select_status'){
                $('#sf_status').html(data)
            }

            $.post(base_url+'admin/dashboard/setSessionFilter',
                {
                    "db_name":db_name,
                    "data":data,
                },function(response) {
                    loadPresentations();
                });
        });

        $('.clearFilterBtn').on('click', function(){
            $('#select_session_date').val('').change();
            $('#select_session_room').val('').change();
            $('#select_session_name').val('').change();
            $('#select_status').val('').change();
        })

    } );

    function confirmDownload(presentation_ids, file_name) {
            $.post('<?=base_url()?>admin/dashboard/confirmedDownloadZip/' + presentation_ids,
                function (response) {
                if(response == 'success'){
                    window.location.href="<?=base_url()?>"+file_name
                  $.each(selected, function(i, val){
                      $('#undownloadedFileCount_'+val).css('display', 'none');
                  })
                }
            },'json')
    }



    function selectPresentationRow(){
        $('#presentationTable tbody').on('click', 'tr', function () {
            var id = parseInt(this.id);
            var index = $.inArray(id, selected);

            if ( index === -1 ) {
                selected.push( id );
            } else {
                selected.splice( index, 1 );
            }

            $(this).toggleClass('selected');
            if(selected.length > 0)
            {
                $('.select-all-presentation').removeClass('btn-info');
                $('.select-all-presentation').addClass('btn-danger');
                $('.select-all-presentation').html('<i class="fas fa-ban"></i> Unselect All');
            }else{
                $('.select-all-presentation').removeClass('btn-danger');
                $('.select-all-presentation').addClass('btn-info');
                $('.select-all-presentation').html('<i class="fas fa-check-double"></i> Select All');
            }
        } );
    }




    function loadPresentations() {
        $.get( "<?=base_url('admin/dashboard/getPresentationList')?>", function(response) {
            response = JSON.parse(response);

            if (response.data){
                if ($.fn.DataTable.isDataTable('#presentationTable')) {
                    $('#presentationTable').DataTable().destroy();
                    selectPresentationRow();
                }

                $('#presentationTableBody').html('');

                $.each(response.data, function (i, presentation) {


                    let statusBadge = (presentation.uploadStatus) ? '<span class="badge mr-1 badge-success ><i class="fas fa-check-circle"></i> ' + presentation.uploadStatus + ' File(s) uploaded</span>' : '<span class="badge badge-warning mr-1"><i class="fas fa-exclamation-circle"></i> No Uploads</span>';
                    statusBadge += (presentation.active == 1) ? '<span class="active-status badge " style="background-color: gray; color: white" presentation-id="' + presentation.id + '"><i class="fas fa-check"></i> Active</span>' : '<span class="disabled-status badge badge-danger" presentation-id="' + presentation.id + '"><i class="fas fa-times"></i> Disabled</span>';
                    statusBadge += (presentation.undowloaded_files > 0) ? '<span  id="undownloadedFileCount_' + presentation.id + '" class="badge badge-success"><i class="fas fa-bell" style="color: red"></i>'+ presentation.undowloaded_files+' New File(s)</span>':'';

                    // let filesBtn = '<button class="files-btn btn btn-sm btn-info text-white" session-name="' + presentation.session_name + '" presentation-name="' + presentation.name + '" user-id="' + presentation.presenter_id + '" presentation-id="' + presentation.id + '" room_id="' + presentation.room_id + '" room_name="' + presentation.room_name + '" session_date="' + presentation.session_date + '"><i class="fas fa-folder-open"></i> Files</button>';

                    let detailsBtn = '<button class="details-btn btn btn-sm btn-info text-white mt-1" session-name="'+presentation.session_name+'" presentation-name="'+presentation.name+'" user-id="'+presentation.presenter_id+'" presentation-id="'+presentation.id+'"  session_id="'+presentation.session_id+'" speaker_lname="'+presentation.last_name+'" room_name="'+presentation.room_name+'" room_id="'+presentation.room_id+'" session_date="'+presentation.session_date+'" presentation_start="'+presentation.presentation_start+'" assigned-id="'+presentation.assigned_id+'"><i class="fas fa-info-circle"></i> Files</button>';

                    let logsBtn = '<button class="presentation-logs-btn btn btn-sm btn-warning text-white mt-1" session-name="' + presentation.session_name + '" presentation-name="' + presentation.name + '" user-id="' + presentation.presenter_id + '" presentation-id="' + presentation.id + '" room_name="' + presentation.room_name + '" session_date="' + presentation.session_date + '"><i class="fas fa-history"></i> Logs</button>';

                    let editBtn = '<button class="edit-presentation-btn btn btn-sm btn-primary text-white" presentation-id="' + presentation.id + '"   user-id="' + presentation.presenter_id + '"  room_id="' + presentation.room_id + '" upload-status="' + presentation.uploadStatus + '"><i class="fas fa-edit"></i> Edit</button>';
                    let disableBtn = (presentation.active == 0) ? '<button class="activate-presentation-btn btn btn-sm btn-success text-white mt-1" presentation-id="' + presentation.id + '"><i class="fas fa-check"></i> Activate</button>' : '<button class="disable-presentation-btn btn btn-sm btn-danger text-white mt-1" presentation-id="' + presentation.id + '"><i class="fas fa-times"></i> Disable</button>';

                    let presentationCheckbox = '<input type="checkbox" class="checkedPresentation" name="checkedPresentation" id="checkedPresentation_' + presentation.id + '" presentation-id="' + presentation.id + '" room-id="' + presentation.room_id + '" presenter-id="' + presentation.presenter_id + '" session-id="' + presentation.session_id + '">';
                    if (presentation.session_date !== null) {
                        session_date = presentation.session_date;
                    } else {
                        session_date = '';
                    }
                    if (presentation.start_time !== null && presentation.end_time !== null) {
                        presentation_time = convertTime(presentation.start_time) + ' - ' + convertTime(presentation.end_time);
                    } else {
                        presentation_time = '';
                    }

                    $('#presentationTableBody').append('' +
                        '<tr id="' + presentation.id + '">\n' +
                        '  <td>\n' +
                        '    ' + statusBadge + '\n' +
                        '  </td>\n' +
                        '  <td>' + presentation.id + '</td>\n' +
                        '  <td>' + presentation.assigned_id + '</td>\n' +
                        '  <td style="white-space: nowrap">' + session_date +
                        '  <td style="white-space: nowrap">' + presentation_time + '</td>\n' +
                        '  <td style="white-space: nowrap">' + convertTime(presentation.presentation_start) + '</td>\n' +
                        '  <td>' + presentation.room_name + '</td>\n' +
                        '  <td>' + presentation.session_name + '</td>\n' +
                        '  <td>' + presentation.name + '</td>\n' +
                        '  <td>' + presentation.first_name + '</td>\n' +
                        '  <td>' + presentation.last_name + '</td>\n' +
                        '  <td style="width: 200px !important; word-break:break-word">' + presentation.email + '</td>\n' +
                        '  <td>\n' +
                        '    ' + detailsBtn+'\n' +
                        '    ' + logsBtn + '\n' +
                        '  </td>\n' +
                        '  <td>\n' +
                        '   ' + editBtn + '\n' +
                        '   ' + disableBtn + '\n' +
                        '  </td>\n' +
                        '</tr>');
                });

                presentationDt = $('#presentationTable')
                    .DataTable({
                        lengthMenu: [[5, 25, 50, 250, -1], [5, 25, 50, 250, "All"]],
                        "iDisplayLength": -1,
                        "order": [[ 3, "asc" ], [ 7, "asc" ],[ 5, "asc" ]],
                        dom: 'lBfrtip',
                        buttons: [
                                    {
                                        text: '<i class="fa fa-refresh"></i> Update Presentation Status',
                                        className:'btn btn-success float-left ml-1',
                                        action: function () {
                                            loadPresentations();
                                            selected = [];
                                        }
                                    }
                                ],
                        initComplete: function () {
                            //$(this.api().table().container()).find('input').val('');
                        },
                    });

                $('#lastUpdated').text(formatDateTime(response.data[0].created_on, false));
                $('#lastUpdatedAlert').show();
            }
        })
            .fail(function(response) {
                $('#sessionsTable').DataTable();
                toastr.error("Unable to load your presentations data");
            });

        selectPresentationRow();
    }


    function formatDateTime(datetimeStr, include_year = true) {
        let lastUpdatedDate = new Date(datetimeStr);
        let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(lastUpdatedDate);
        let month = new Intl.DateTimeFormat('en', { month: 'long' }).format(lastUpdatedDate);
        let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(lastUpdatedDate);
        let time = lastUpdatedDate.toLocaleTimeString('en-US', { hour: 'numeric', hour12: true, minute: 'numeric' });

        return ((include_year)?year+' ':'')+month+', '+day+'th '+time;
    }

    function activatePresentation(presentation_id, button) {
        $.get( "<?=base_url('admin/dashboard/activatePresentation/')?>"+presentation_id, function(response) {
            response = JSON.parse(response);

            if (response.status == 'success')
            {
                $('.disabled-status[presentation-id="'+presentation_id+'"]').html('<i class="fas fa-check"></i> Active');
                $('.disabled-status[presentation-id="'+presentation_id+'"]').removeClass('badge-danger');
                $('.disabled-status[presentation-id="'+presentation_id+'"]').addClass('badge-success');
                $('.disabled-status[presentation-id="'+presentation_id+'"]').addClass('active-status');
                $('.disabled-status[presentation-id="'+presentation_id+'"]').removeClass('disabled-status');

                button.removeClass('activate-presentation-btn');
                button.addClass('disable-presentation-btn');
                button.removeClass('btn-success');
                button.addClass('btn-danger');
                button.html('<i class="fas fa-times"></i> Disable');

                toastr.success(response.msg);
            }else{
                toastr.error(response.msg);
            }

        }).fail(function() {
            toastr.error('Unable activate the presentation');
        })
    }

    function disablePresentation(presentation_id, button) {
        $.get( "<?=base_url('admin/dashboard/disablePresentation/')?>"+presentation_id, function(response) {
            response = JSON.parse(response);

            if (response.status == 'success')
            {
                $('.active-status[presentation-id="'+presentation_id+'"]').html('<i class="fas fa-times"></i> Disabled');
                $('.active-status[presentation-id="'+presentation_id+'"]').removeClass('badge-success');
                $('.active-status[presentation-id="'+presentation_id+'"]').addClass('badge-danger');
                $('.active-status[presentation-id="'+presentation_id+'"]').addClass('disabled-status');
                $('.active-status[presentation-id="'+presentation_id+'"]').removeClass('active-status');

                button.removeClass('disable-presentation-btn');
                button.addClass('activate-presentation-btn');
                button.removeClass('btn-danger');
                button.addClass('btn-success');
                button.html('<i class="fas fa-check"></i> Activate');

                toastr.success(response.msg);
            }else{
                toastr.error(response.msg);
            }

        }).fail(function() {
            toastr.error('Unable disable the presentation');
        })
    }

</script>
<script>
    function convertTime(timeString){
        if(timeString) {
            var H = +timeString.substr(0, 2);
            var h = (H % 12) || 12;
            var ampm = H < 12 ? " AM" : " PM";
            var single = H < 10 ? "0" : '';
            timeString = single + h + timeString.substr(2, 3) + ampm;
            return timeString;
        }else{
            return timeString;
        }
    }

</script>

