<?php ?>
<!-- Modal -->
<div class="modal fade" id="createPresentationModal" tabindex="-1" role="dialog" aria-labelledby="createPresentationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPresentationModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="formPresentation" action="" method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Assigned ID</span>
                    </div>
                    <input name="assigned_id" id="assigned_id" type="text" class="form-control" aria-label="Assigned ID" >
                </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Session Date Filter</span>
                        </div>
                        <select name="session_date" class="form-control required-field" id="session_date"  >
                            <option value=""> Select Date </option>
                        </select>
                    </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session Name</span>
                    </div>
                    <select name="session_name" class="form-control required-field" id="session_name"  >

                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Session Full Name</span>
                    </div>
                    <input name="session_full_name" id="session_full_name" type="text" class="form-control" aria-label="Session Name" readonly style="background-color: unset">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Presentation Title</span>
                    </div>
                    <input name="presentation_title" id="presentation_title" type="text" class="form-control required-field" aria-label="Session Name" >
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Presenter</span>
                    </div>
                    <select name="presenter_id" class="form-control required-field" id="presenters_list"  >

                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Room Name</span>
                    </div>
                        <input name="room_name" id="room_name" type="text" class="form-control required-field" aria-label="Room Name" >
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Presentation Start Time</span>
                    </div>
                    <input name="presentation_start" id="presentation_start" type="time" class="form-control required-field" aria-label="Session Start Time" timeformat="24h" >
                </div>
                    <button type="submit" class="btn btn-primary" id="savePresentationBtn">Save changes</button>
                    <button type="reset" class="btn btn-primary" id="resetBtn">Clear</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<script>
    let base_url = "<?=base_url()?>";
    $(function(){

        $('.create-presentation-btn').on('click', function(){
            $('#createPresentationModalTitle').html('Create Presentation');
            $('#formPresentation').attr('action','<?=base_url()?>admin/dashboard/save_presentation');
            $('#session_date').val('');
            get_presentersList();
            get_sessionList();
        })


        $('#formPresentation').submit(function(event){
            event.preventDefault();

            var actionUrl = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: $(this).serialize(), // serializes the form's elements.
                success: function(data)
                {
                  data = JSON.parse(data);
                  if (data.status == 'success'){
                      Swal.fire(
                          data.status,
                          data.msg,
                          'success'
                      )
                      $('#session_name').val('');
                      $('#session_full_name').val('');
                      $('#presentation_title').val('');
                      $('#presentation_title').val('');
                      $('#room_name').val('');
                      $('#presentation_date').val('');
                      $('#presentation_start').val('');
                      $('#session_start').val('');
                      $('#session_end').val('');
                      $('#assigned_id').val('');
                  }else{
                      Swal.fire(
                          data.status,
                          data.msg,
                          'error'
                      )
                  }
                    loadPresentations();

                }

            });
        })
        getSessionDateFilter();
        $('#session_date').on('change', function(){
            if($(this).val() !== ''){
                that = $(this).val();
              $('.session-name-option').each(function(){
                  if($(this).attr('session-date') === that){
                      $(this).css('display', 'block')
                  }else{
                      $(this).css('display', 'none')
                  }
              })
            }else{
                $('.session-name-option').each(function(){
                    $(this).css('display', 'block')
                });
            }
        })
    })

    function getSessionDateFilter(){
        $.post(base_url+'/admin/dashboard/get_sessionListDate',
            function(date){
                $.each(date, function(index, date){
                    $('#session_date').append('<option id="session-date_'+date+'" value="'+date+'" >'+date+'</option>');
                })
            },'json')
    }


    function get_presentersList(){
        $('#presenters_list').html('<option value=""> Select Presenter </option>');
        $.post(base_url+'/admin/dashboard/get_presenter',
            function(presenters){
                // console.log(presenters);

                $.each(presenters, function(index, presenter){
                    $('#presenters_list').append('<option id="presenter_'+presenter.presenter_id+'" value="'+presenter.presenter_id+'"> '+presenter.last_name+', '+presenter.first_name+'</option>');
                })
            },'json')
    }

    function get_sessionList(){

        $.post(base_url+'/admin/dashboard/get_sessionList',
            function(sessions){
                $('#session_full_name').val('');
                $('#session_name').html('').append('<option value=""> Select Session </option>');
                $.each(sessions, function(index, session){
                    $('#session_name').append('<option class="session-name-option" id="session_'+session.id+'" value="'+session.id+'" session-full-name="'+session.full_name+'" session-date="'+session.session_date+'">'+session.name+'</option>');
                })
            },'json')


        $('#session_name').on('change', function(){
            let session_id = $(this).val();

            if(session_id !== ''){
                $.post(base_url+'/admin/dashboard/get_sessionFullName/'+session_id,
                    function(response){
                        if(response !=='empty'){
                            $('#session_full_name').val(response)
                        }else{
                            $('#session_full_name').val('')
                        }
                    },'json')
            }else{
                $('#session_full_name').val('');
            }
        })
    }


    function edit_presentation(presentation_id, upload_status) {

        $('#createPresentationModalTitle').html('Update Presentation');

        $('#formPresentation').attr('action','<?=base_url()?>admin/dashboard/update_presentation/'+presentation_id);
        get_presentersList();
        get_sessionList();
        $('#createPresentationModal').modal('show');
        $.post(base_url + '/admin/dashboard/getPresentationById',
            {
                'presentation_id': presentation_id
            },
            function (presentation) {
            presentation = JSON.parse(presentation);
            $.each(presentation['data'], function(i, data){

                $('#presenters_list #presenter_'+data.presenter_id+'').attr('selected', 'selected');
                $('#session_name').val(data.session_id);
                $('#session_full_name').val(data.session_full_name);
                $('#presentation_title').val(data.name);
                $('#room_name').val(data.room_name);
                $('#presentation_date').val(data.presentation_date);
                $('#presentation_start').val(data.presentation_start);
                $('#session_start').val(data.start_time);
                $('#session_end').val(data.end_time);
                $('#assigned_id').val(data.assigned_id);
            })
        })
    }



</script>