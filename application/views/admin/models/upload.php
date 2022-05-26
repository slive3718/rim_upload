<style>
    .dropzone {
        border: 1px solid rgba(0, 0, 0, 0.07) !important;
    }
    .uploaded-file-names{
        font-size: 13px;
    }
</style>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel" > Upload Files </h5>
            </div>
            <div class="modal-body">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Presentation Date: <span id="presentationDateLabel"></span></li>
                    </ol>
                </nav>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Room: <span id="roomLabel"></span></li>
                    </ol>
                </nav>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"><span class="category"></span>Session: <span id="sessionName"></span></li>
                    </ol>
                </nav>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Presentation: <span id="presentationName"></span></li>
                    </ol>
                </nav>

                <section id="uploadSection">
                    <div id="dropzone">
                        <!-- Form will be filled here dynamically by Dropzone -->
                    </div>
                    <small style="color: red;">You may upload the following file types: Microsoft PowerPoint (.ppt, .pptx)</small>
                </section>

                <section class="mt-3" id="existingFilesSection">
                    <div>
                        <h5 class="modal-title">Uploaded Files </h5>
                    </div>
                    <div class="text-center" id="uploadedFiles" style="border: 1px solid #9f9f9f52;">
                        <img src="<?=base_url('upload_system_files/vendor/images/ycl_anime_500kb.gif')?>">
                    </div>
                </section>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary text-white" data-dismiss="modal"><i class="far fa-check-circle"></i> Done</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.rawgit.com/enyo/dropzone/master/dist/dropzone.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.rawgit.com/enyo/dropzone/master/dist/dropzone.css" crossorigin="anonymous" />

<script>
    Dropzone.autoDiscover = false;
    let uploadDropzone;
    let uploadedFilesNo=0;
    let deletedFilesNo=0;
    let emailConfText='';

    $(document).ready(function() {

        $('#uploadModal').on('hidden.bs.modal', function ()
        {

            $('#dropzone form').remove();

            if (uploadedFilesNo > 0 || deletedFilesNo > 0)
            {
                emailConfText = '<br><br><span class="badge badge-info"><i class="fas fa-envelope-open-text"></i> A confirmation email has been sent to you!</span>';

                Swal.fire(
                    'Done!',
                    '<i class="fas fa-check-circle" style="color: green;"></i> '+uploadedFilesNo+' file(s) uploaded<br>' +
                    '<i class="fas fa-times-circle" style="color: red;"></i> '+deletedFilesNo+' file(s) deleted' +
                    emailConfText,
                    'success'
                );

                loadPresentations();

                uploadedFilesNo = 0;
                deletedFilesNo = 0;
            }
            else
            {
                emailConfText = '';
            }

        });

    });


    function showUploader(user_id, presentation_id, session_name, presentation_name, presentation_type, speaker_lname, session_id, room_id, room_name, presentation_date, presentation_start, assigned_id)
    {
        // console.log(user_id, presentation_id, session_name, presentation_name, presentation_type, speaker_lname, session_id, room_id, room_name, presentation_date, presentation_start, assigned_id)
        fillUploadedFiles(user_id, presentation_id, room_id);

        $('#uploadModal #sessionName').text(session_name);
        $('#uploadModal #presentationName').text(presentation_name);
        $('#uploadModal #presentationDateLabel').text(presentation_date);
        $('#uploadModal #roomLabel').text(room_name);


        let form = '' +
            '<form method="post" class="dropzone">' +
            ' <div class="dz-message" data-dz-message>\n' +
            '    <i class="fas fa-cloud-upload-alt fa-2x" style="color: #626161ad;"></i><br>\n' +
            '    <span>Drop files here or click to upload</span>\n' +
            ' </div>' +
            '</form>';
        $('#dropzone').append(form);

        uploadDropzone = new Dropzone("#dropzone form",
            {
                url: "<?=base_url('admin/dashboard/uploadFile')?>",
                acceptedFiles: ".ppt, .pptx",
                addRemoveLinks: false,
                maxFilesize: 2000,
                timeout: 3600000, //in Milli Seconds
                init: function() {
                    this.on('error', function(file, errorMessage) {
                        var errorDisplay = document.querySelectorAll('[data-dz-errormessage]');
                        errorDisplay[errorDisplay.length - 1].innerHTML = errorMessage;

                    });
                }
            });

        uploadDropzone.on('sending', function(file, xhr, formData){
            formData.append('user_id', user_id);
            formData.append('presentation_id', presentation_id);
            formData.append('speaker_lname', speaker_lname);
            formData.append('session_id', session_id);
            formData.append('room_id', room_id);
            formData.append('presentation_start', presentation_start);
            formData.append('assigned_id', assigned_id);
        });

        uploadDropzone.on('success', function() {
            var _this = this;

            let args = Array.prototype.slice.call(arguments);

            let response = JSON.parse(args[1]);
            let file = args[0];

            //console.log(response);

            if (response.status == 'success')
            {
                Swal.fire(
                    'Success',
                    'File Successfully Uploaded!',
                    'success'
                )
                fillUploadedFiles(user_id, presentation_id, room_id);
                _this.removeFile(file);
                uploadedFilesNo = uploadedFilesNo+1;
            }else{
                $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response.msg);
            }

            // var removeButton = Dropzone.createElement("<button data-dz-remove " +
            //     "class='del_thumbnail btn btn-default' style='cursor: pointer;'><i class='fas fa-trash-alt' style='color:red;'></i></button>");
            //
            // removeButton.addEventListener("click", function (e) {
            //     e.preventDefault();
            //     e.stopPropagation();
            //
            //     _this.removeFile(file);
            // });
            //
            // file.previewElement.appendChild(removeButton);

        });

        $('#uploadModal').modal({ //Should not auto-close
            backdrop: 'static',
            keyboard: false
        });
    }

    function fillUploadedFiles(user_id, presentation_id, room_id) {

        $('#uploadModal #uploadedFiles').html('<img src="<?=base_url('upload_system_files/vendor/images/ycl_anime_500kb.gif')?>">');
        // console.log(user_id,presentation_id,room_id);
        $.get( "<?=base_url('admin/dashboard/getUploadedFiles/')?>"+user_id+"/"+presentation_id+"/"+room_id,
            function(response) {
            response = JSON.parse(response);

            if (response.status == 'success')
            {
                console.log('success')
                $('#uploadModal #uploadedFiles').html('');
                $('#uploadModal #uploadedFiles').append('<ul class="list-group">');
                $.each(response.files, function(i, file) {

                    checkRecentUploadsStatus(file.id);

                    $('#uploadModal #uploadedFiles').append('' +
                        '<li class="list-group-item">' +
                        '<a href="https://docs.google.com/gview?url=<?=base_url()?>'+file.file_path+'&embedded=true" target="_blank"><button class="btn btn-sm btn-primary mr-3 text-white"><i class="fas fa-external-link-alt"></i> Open</button></a>' +
                        '<a class="downloadFileBtn" href="<?=base_url('admin/dashboard/openFile/')?>'+file.id+'" target="_blank" id="download_'+file.id+'" file-id="'+file.id+'"><button class="btn btn-sm btn-info mr-3"><i class="fas fa-save"></i> Download </button></a>' +
                        '<span class="uploaded-file-names badge badge-success" style="position: relative; display: inline-block"><i class="fas fa-clipboard-check"></i> '+file.name+' <span class="badge badge-info">'+Math.ceil(file.size/1000)+' kb </span>' +
                        '<i class="badge badge-warning" id="new-upload_'+file.id+'" style="display:none; width:40px; position:absolute; right:-10px; top: -10px; color:#138496; border-radius:50%"> new </i></span>' +
                        '<button class="delete-file-btn btn btn-sm btn-danger ml-3" presentation-id="'+file.presentation_id+'" user-id="'+file.presenter_id+'" file-id="'+file.id+'" file-name="'+file.name+'" room_id="'+file.room_id+'"><i class="fas fa-trash"></i> Delete</button>' +
                        '</li>');
                });
                $('#uploadModal #uploadedFiles').append('</ul>');

            }else{
                $('#uploadModal #uploadedFiles').html('');
                $('#uploadModal #uploadedFiles').append('<ul class="list-group">');
                $('#uploadModal #uploadedFiles').append('<li class="list-group-item">No files</li>');
                $('#uploadModal #uploadedFiles').append('</ul>');
            }

        }).fail(function() {
            toastr.error('Unable to load your uploaded files');
        })
    }

    $('#uploadModal #uploadedFiles').on('click', '.delete-file-btn', function () {

        let file_id = $(this).attr('file-id');
        let file_name = $(this).attr('file-name');
        let user_id = $(this).attr('user-id');
        let presentation_id = $(this).attr('presentation-id');
        let room_id = $(this).attr('room_id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You are you about to delete "+file_name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.post( "<?=base_url('admin/dashboard/deleteFile')?>",
                    {
                        user_id: user_id,
                        presentation_id: presentation_id,
                        file_id: file_id,
                        room_id: room_id
                    })
                    .done(function( data ) {

                        data = JSON.parse(data);
                        if (data.status == 'success')
                        {
                            deletedFilesNo = deletedFilesNo+1;

                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );

                            fillUploadedFiles(user_id, presentation_id, room_id);

                        }else{
                            Swal.fire(
                                'Unable to delete '+file_name,
                                data.msg,
                                'error'
                            )
                        }

                    })
                    .fail(function () {
                        Swal.fire(
                            'Unable to delete '+file_name,
                            'Network Error',
                            'error'
                        )
                    });

            }
        })
    });
    function checkRecentUploadsStatus(file_id){
        $.post('<?=base_url()?>admin/dashboard/getUndownloadedFilesByUploadId/'+file_id,
            function(response){
                response = JSON.parse(response);

                if(response.msg=== 'empty'){
                    $('#new-upload_'+response.file_id).css('display','block');

                }else{
                    $('#new-upload_'+response.file_id).css('display','none');
                }
            });
    }
</script>
