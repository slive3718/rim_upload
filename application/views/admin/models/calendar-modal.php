<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.5.0/main.global.min.js'></script>
<style>
    #eventTable {
        color: #534949;
    }
    #eventTable .td-title{
        white-space: nowrap;
    }
</style>
<!-- Calendar Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="height: 900px">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalTitle">Calendar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="">
                <div id="calendar" style="height:900px !important;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Calendar Event Modal -->
<div class="modal fade" id="calendarEventModal" tabindex="-1" role="dialog" aria-labelledby="calendarEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarEventModalTitle">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="">
                <table id="eventTable" class="table table-striped">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(function(){
        let base_url = "<?=base_url()?>";
        var calendarEl = $('#calendar')[0];
        calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            initialView: 'timeGridWeek',
            initialDate: Date.now(),

            events: base_url+'admin/dashboard/getCalendarEvents',
            eventClick: function(event){
                var eventObj = event.event;
                // console.log(eventObj.id)
                let eventModal =$('#calendarEventModal');
                let eventModalBody =$('#calendarEventModal .modal-body table');
                $.post(base_url+'admin/dashboard/getCalendarEvents', function(response){
                    if(response){
                        $.post(base_url+'admin/dashboard/getPresentationById',
                            {
                        'presentation_id':eventObj.id
                            },function(response) {
                                response = JSON.parse(response);
                                if (response.data) {

                                    eventModalBody.html('')
                                    $.each(response.data, function (i, val) {
                                        eventModalBody.append('<tr>' +
                                            '<td> Assigned ID : <span class="badge badge-success"></td><td>' + val.assigned_id + '</span></td>' +
                                            '<tr><td class="td-title"> Room : </td><td>' + val.room_name+ '</td></tr>' +
                                            '<tr><td class="td-title"> Session : </td><td>' + val.session_full_name+ '</td></tr>' +
                                            '<tr><td class="td-title"> Session Time : </td><td>' + val.start_time+' - '+ val.end_time+'</td></tr>' +
                                            '<tr><td class="td-title"> Presentation Title : </td><td>' + val.name+ '</td></tr>' +
                                            '<tr><td class="td-title"> Presentation Start : </td><td>' + val.presentation_start+ '</td></tr>' +
                                            '<tr><td class="td-title"> Presenter : </td><td>' + val.presenter_name+ '</td></tr>' +
                                            '</tr>')
                                    })

                                }
                            }
                        )
                    }
                    eventModal.modal('show')
                })

            }
        });
        $('#calendar .fc-scrollgrid').css('height', '400px')
        calendar.setOption('height', 700);
        $('.calendar-btn').on('click', function(e){
            e.preventDefault();
            $('#calendarModal').modal('show');
            calendar.render();
        })

    })
</script>