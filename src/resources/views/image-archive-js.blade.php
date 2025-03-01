<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script>
    $(document).ready(function() {
        var imgUploadType;
        var noOfField;
        var imgDivID;
        var imgDivClass;
        var captionID;
        var currentURL;
        var timeoutId;
        var ajaxRequest = false;

        // Define debounce function with a delay of 500 milliseconds
        var debouncedSearch = _.debounce(function() {
            var inputValue = $('#SearchImage').val().trim();
            var SearchType = $('#SearchType').val();
            var errorDiv = $('#errorDiv');
            var imgSearchResultDiv = $('#img-search-result');
            var loadingIcon = $('#loadingIcon');

            if (inputValue === '') {
                errorDiv.text('Please enter image name, caption in the search field.');
                imgSearchResultDiv.find('.image-wrapper').each(function() {
                    if (!$(this).hasClass('selected') && !$(this).hasClass('newly-uploaded')) {
                        $(this).parent().remove();
                    }
                });
                return false;
            } else {
                errorDiv.text('');
            }

            loadingIcon.show();

            if (!ajaxRequest) {
                ajaxRequest = true;
                $.ajax({
                    url: '/image/archive/search',
                    method: 'GET',
                    data: {
                        query: inputValue,
                        SearchType: SearchType
                    },
                    success: function(response) {
                        loadingIcon.hide();
                        imgSearchResultDiv.find('.image-wrapper').each(function() {
                            if (!$(this).hasClass('selected') && !$(this).hasClass(
                                    'newly-uploaded')) {
                                $(this).parent().remove();
                            }
                        });
                        imgSearchResultDiv.append(response);
                        ajaxRequest = false;
                    },
                    error: function(xhr, status, error) {
                        loadingIcon.hide();
                        // Parse the JSON response to get the error message
                        var response = xhr.responseJSON;
                        if (response && response.errors && response.errors.query) {
                            var errorMessage = response.errors.query[0];
                            errorDiv.text(errorMessage);
                        } else {
                            // If the error format is not as expected, show a generic error message
                            errorDiv.text('Error fetching images. Please try again later.');
                        }
                        imgSearchResultDiv.empty();
                        ajaxRequest = false;
                    }
                });
            }
        }, 500); // Adjust the delay as needed

        $('.search-img').on('input', debouncedSearch);

        $('#SearchType').on('change', function() {
            var inputValue = $('#SearchImage').val().trim();
            var SearchType = $(this).val();
            var errorDiv = $('#errorDiv');
            var imgSearchResultDiv = $('#img-search-result');
            var loadingIcon = $('#loadingIcon');

            if (inputValue === '') {
                errorDiv.text('Please enter image name, caption in the search field.');
                // imgSearchResultDiv.empty();
                // $('.image-wrapper').not('.selected').parent().remove();
                // $('.image-wrapper').not('.newly-uploaded').parent().remove();
                imgSearchResultDiv.find('.image-wrapper').each(function() {
                    if (!$(this).hasClass('selected') && !$(this).hasClass('newly-uploaded')) {
                        $(this).parent().remove();
                    }
                });
                return false;
            } else {
                errorDiv.text('');
            }

            loadingIcon.show(); // Show loading icon while fetching images

            // Clear previous timeout
            // clearTimeout(timeoutId);

            // Set a new timeout to execute the AJAX request after a delay (e.g., 500 milliseconds)
            // timeoutId = setTimeout(function() {
            // AJAX request to fetch images based on the input value
            if (!ajaxRequest) {
                ajaxRequest = true;
                $.ajax({
                    url: '/image/archive/search', // Replace with your actual API endpoint
                    method: 'GET',
                    data: {
                        query: inputValue,
                        SearchType: SearchType
                    },
                    success: function(response) {
                        // Hide loading icon on successful response
                        loadingIcon.hide();

                        // Handle successful response
                        // imgSearchResultDiv.empty(); // Clear previous search results
                        // imgSearchResultDiv.children(':not(.newly-uploaded.selected)').empty();
                        imgSearchResultDiv.find('.image-wrapper').each(function() {
                            if (!$(this).hasClass('selected') && !$(this).hasClass(
                                    'newly-uploaded')) {
                                $(this).parent().remove();
                            }
                        });
                        imgSearchResultDiv.append(response);
                        ajaxRequest = false;
                    },
                    error: function(xhr, status, error) {
                        // Hide loading icon on error
                        loadingIcon.hide();

                        // Handle error response
                        errorDiv.text('Error fetching images. Please try again later.');
                        imgSearchResultDiv.empty(); // Clear previous search results
                        ajaxRequest = false;
                    }
                });
            }
        });

        $("#SearchImage").keydown(function(event) {
            if (event.keyCode === 13) { // 13 is the keycode for Enter key
                event.preventDefault(); // Prevent the default action of the Enter key
            }
        });

        $(document).on('click', '.imageButton', function(e) {
            e.preventDefault();
            var errDiv = $('#errDiv');
            imgUploadType = $(this).data('img-upload-type');
            imgDivID = $(this).data('img-div');
            imgDivClass = $(this).data('img-class');
            capDivID = $(this).data('cap-div');
            noOfField = $(this).data('field-create');
            currentURL = window.location.href;
            
            if (imgUploadType === 1 || imgUploadType === 3) {
                // For single image upload
                $('#ImageArchivePath').removeAttr('multiple');
                $('#ImageArchivePath').attr('name', 'ImageArchivePath');
                $('.use-image').text('Use the image');
                dropifyReset()
                errDiv.text('');
                console.log("Single image selected");
            } else if (imgUploadType === 2) {
                // For multiple image upload
                $('#ImageArchivePath').prop('multiple', true);
                $('#ImageArchivePath').attr('name', 'ImageArchivePath[]');
                $('.use-image').text('Create Gallery');
                dropifyReset()
                errDiv.text('');
                console.log("Multiple images selected");
            }
            else {
                // console.log("Unknown image upload type");
            }
        });

        $(document).on('click', '.img-selection', function(e) {
            var updateID = $(this).data('img-id');
            var getDataByClass = $('.img_' + updateID)
            var imgFullPath = getDataByClass.find('img').attr('src');
            var imagename = getDataByClass.data('img');
            var imageSmName = getDataByClass.data('img-sm');
            var imageThumbName = getDataByClass.data('img-thumb');
            var caption = getDataByClass.attr('data-img-caption');
            console.log('imageThumbName: '+imageThumbName);
            if (imgUploadType === 1 || imgUploadType === 3) {
                $('.image-wrapper').removeClass('selected')
                $('#selected-images').html('')
                $(this).parent().addClass('selected')
                $('#selected-images').prepend('<img data-img-caption="' + caption +
                    '" data-img-name="' + imagename + '"  data-img-sm-name="' + imageSmName + '"  data-img-thumb-name="' + imageThumbName + '" width="80" class="img-fluid me-2 mb-2 selected_id_' + updateID + '" src="' + imgFullPath + '" alt="">')

            } else if (imgUploadType === 2) {
                if ($(this).parent().hasClass('selected')) {
                    $(this).parent().removeClass('selected');
                    $('.selected_id_' + updateID).parent().remove();
                } else {
                    $(this).parent().addClass('selected');
                    $('#selected-images').prepend('<div class="sl-img"><img data-img-caption="' + caption +
                        '" data-img-name="' +
                        imagename + '" width="80" class="img-fluid me-2 mb-2 selected_id_' +
                        updateID +
                        '" src="' + imgFullPath + '" alt=""><i data-remove-id="'+updateID+'" class="fas fa-times-circle text-danger remove-selected-img"></i></div>');
                }
            }
            // Check the count of elements with the class 'selected'
            var selectedCount = $('.image-wrapper.selected').length;

            if (selectedCount === 0) {
                $('.selected-section').addClass('d-none');
            } else {
                $('.selected-section').removeClass('d-none');
            }
        });
        $(document).on('click', '.edit-section', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var updateID = $(this).data('edit-id');
            var getDataByClass = $('.img_' + updateID)
            var imgFullPath = getDataByClass.find('img').attr('src');
            var imagename = getDataByClass.data('img');
            var caption = getDataByClass.attr('data-img-caption');
            $('.img-caption-update').attr('data-img-cap-id', updateID)
            $('.img-caption-update').attr('src', imgFullPath)
            $('.img-info').text(imagename)
            if (caption) {
                $('#HeadCaption').val(caption)
            } else {
                $('#HeadCaption').val('')
            }
            $('.edit-section').removeClass('active');
            $(this).addClass('active');

            $('.img-preview-section').removeClass('col-sm-12').addClass('col-sm-7');
            $('.attachment-sidebar').removeClass('d-none');

            // var selectedCount = $('.image-wrapper.selected').length;
            // console.log(selectedCount);
            // if (selectedCount === 0 ) {
            // 	$('.img-preview-section').removeClass('col-sm-7').addClass('col-sm-12');
            // 	$('.attachment-sidebar').addClass('d-none');
            // }else{
            // 	$('.img-preview-section').removeClass('col-sm-12').addClass('col-sm-7');
            // 	$('.attachment-sidebar').removeClass('d-none');
            // }
        });
        $(document).on('click', '.use-image', function(e) {
            if (imgUploadType === 1) {
                var src = $('#selected-images').find('img:first').attr('src');
                var imagePath = $('#selected-images').find('img:first').attr('data-img-name');
                var imageSmPath = $('#selected-images').find('img:first').attr('data-img-sm-name');
                var imageThumbPath = $('#selected-images').find('img:first').attr('data-img-thumb-name');
                // var parts = imagePath.split('/');
                // imagePath = parts[parts.length - 1];
                var caption = $('#selected-images').find('img:first').attr('data-img-caption');
                console.log(imagePath);
                $('#' + imgDivID).find('img').attr('src', src);
                $('#' + imgDivID).find('.imagePath').val(imagePath);// also used for  social path
                $('#' + imgDivID).find('.imageSmPath').val(imageSmPath);
                $('#' + imgDivID).find('.imageThumbPath').val(imageThumbPath);
                $('#'+imgDivID).find('.img-section .delete-bg-img').remove();
                $('#' + imgDivID).find('.img-section').append('<a href="#" data-img-div="'+imgDivID+'" class="remove-added-img"> <i class="fas fa-times-circle remove-icon"></i> </a>');
                if (capDivID) {
                    $('#' + capDivID).val(caption);
                }
                resetModal();
                $('#imageArchiveModal').modal('hide');

            } else if (imgUploadType === 2) {
                var appendField;
                $('#selected-images').find('img').each(function() {
                    var src = $(this).attr('src');
                    // var parts = src.split('/');
                    // imagePath = parts[parts.length - 1];
                    imagePath = $(this).attr('data-img-name');
                    var caption = $(this).attr('data-img-caption');

                    var fieldCaption =
                        `<div class="col-xl-12 mt-4">
                        <div class="inser-form-wrapper">
                            <div class="mb-3 row ">
                                <label for="Caption" class="col-sm-2 col-form-label">Caption:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="Caption[]" class="form-control caption @error('Caption') is-invalid @enderror post-wrapper" value="` +
                                    caption + `" maxlength="10000">
                                    @error('Caption')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>`;

                    var fieldLink = `<div class="col-xl-12">
                        <div class="inser-form-wrapper">
                            <div class="mb-3 row ">
                                <label for="" class="col-sm-2 col-form-label">Link:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="Link[]" class="form-control @error('Link') is-invalid @enderror post-wrapper" value="" maxlength="255">
                                    @error('Link')
                                        <span class="text-danger" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>`;
                    var appendField;
                    var uniqueRow = Date.now() + '_' + Math.floor(Math.random() * 1000);
                    if (noOfField == 2) {
                        appendField = fieldCaption;
                    } else if (noOfField == 3) {
                        appendField = fieldCaption + fieldLink;
                    }
                    var form = '';
                    form = `<div class="image-row row-unique-`+uniqueRow+` rounded p-4 bg-custom mb-4">
                    <input type="hidden" class="position" name="Position[]" value="">
					<input type="hidden" class="img-update-path" name="ImagePath[]" value="` + imagePath + `">
					<div class="row rounded">
						<div class="col-xl-12">
							<div class="float-end mt-2">
								<i class="fas fa-trash-alt text-danger remove-img"></i>
							</div>
						</div>` +
                        appendField +
                        `<div class="col-xl-12">
							<div class="inser-form-wrapper">
								<div class="mb-3 row ">
									<div class="col-xl-2 col-lg-2">
										<label for=""  class=" col-form-label">Image</label><br>
										<small class="text-danger"><b>640px * 360px</b></small>
									</div>
									<div class="col-xl-8 col-lg-10">
										<img src="` + src + `" alt="" class="img-fluid w-25 mb-2">
                                        <br>
                                        <button data-img-class="row-unique-`+uniqueRow+`" data-img-upload-type="3" data-bs-toggle="modal" data-bs-target="#imageArchiveModal" type="button" class="btn btn-sm btn-change imageButton"><i class="fas fa-edit"></i>Change Image</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>`
                    $('#' + imgDivID).append(form)
                    resetModal();
                    $('#imageArchiveModal').modal('hide');
                });
            }else if (imgUploadType === 3) {
                var src = $('#selected-images').find('img:first').attr('src');
                var imagePath = $('#selected-images').find('img:first').attr('data-img-name');
                // var parts = imagePath.split('/');
                // imagePath = parts[parts.length - 1];
                var caption = $('#selected-images').find('img:first').attr('data-img-caption');
                console.log(imagePath);
                $('.' + imgDivClass).find('img').attr('src', src);
                $('.' + imgDivClass).find('.img-update-path').val(imagePath);
                var capClass=  $('.' + imgDivClass).find('.caption').val();
                console.log('Caption 1: '+capClass +' '+'Caption2 :'+caption);
                if (!capClass) {
                    $('.' + imgDivClass).find('.caption').val(caption);
                }
                resetModal();
                $('#imageArchiveModal').modal('hide');

            }
        });

        $(document).on('click', '#imgUpload', function() {
            var dropifyInput = $('.dropify-wrapper .dropify-preview').find('.dropify-render img');
            var errDiv = $('#errDiv');
            var btnDisable = $('.img-archive-btn');
            var imgArchiveTab = $('.img-archive-tab');
            var selectedSection = $('.selected-section');
            var dropifyDisable = $('.dropify-wrapper');
            var selectedClass = 'selected';
            var selectedCount = $('.image-wrapper.selected').length;
            var loadingIconUpload = $('#loadingIconUpload');

            if ( (imgUploadType === 1 || imgUploadType === 3 ) && selectedCount > 0) {
                selectedClass = '';
            }

            if (dropifyInput.length > 0) {
                loadingIconUpload.html('<i class="fas fa-spinner fa-spin me-2"></i>Uploading images...');
                btnDisable.attr('disabled', 'disabled')
                dropifyDisable.css('pointer-events', 'none');
                errDiv.text('');
                var files = $('#ImageArchivePath')[0].files;
                var formData = new FormData();
                // Append each file to the FormData object
                for (var i = 0; i < files.length; i++) {
                    formData.append('ImageArchivePath[]', files[i]);
                }

                $.ajax({
                    url:'/archive/image/upload/',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response);
                        $('#errDiv').empty(); // Clear previous error messages
                        btnDisable.removeAttr('disabled')
                        loadingIconUpload.html('');
                        dropifyDisable.css('pointer-events', 'auto');
                        dropifyReset()
                        imgArchiveTab.click();
                        // $('.attachment-sidebar').removeClass('d-none')
                        var insertedImages = response.images;
                        // var lastInsertedId = null;
                        // var lastInsertedImagePath = null;
                        var imagename = null;
                        $.each(insertedImages, function(insertedId, imgData) {
                            var insertedId = insertedId;
                            var imgFullPath = imgData.imgFullPath;
                            var imagename = imgData.imagename;
                            var imageSmName = imgData.imageSmName;
                            var imageThumbName = imgData.imageThumbName;
                            console.log('imageThumbName: '+imageThumbName);
                            var html = `<div class="col-md-4 mb-4 mt-2">
                                <div class="image-wrapper newly-uploaded ` + selectedClass + `">
                                    <div data-img-caption="" data-img-id="` + insertedId + `" data-img="` + imagename + `" data-img-sm="` + imageSmName + `" data-img-thumb="`+imageThumbName+`"  class="img-selection img_` + insertedId + `">
                                            <div class="placeholder"> <img data-src="` + imgFullPath + `" class="img-fluid lazyload" src="` + imgFullPath + `" alt="">
                                                <div class="edit-section" data-edit-id="` + insertedId + `">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="">Edit</span>
                                                </div>
                                            </div>
                                            <div class="check">
                                                <i class="fas fa-check showing"></i>
                                                <i class="fas fa-minus hide"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>`;
                            var selectedImages ='<div class="sl-img"><img width="80" data-img-caption="" data-img-name="' + imagename + '"  data-img-sm-name="' + imageSmName + '" data-img-thumb-name="' + imageThumbName + '" class="img-fluid me-2 mb-2 selected_id_' + insertedId + '" src="' + imgFullPath + '" alt=""><i data-remove-id="'+insertedId+'" class="fas fa-times-circle text-danger remove-selected-img"></i></div>'
                            $("#img-search-result").prepend(html);
                            if ((imgUploadType === 1 || imgUploadType === 3) && selectedCount == 0) {
                                $('#selected-images').prepend(selectedImages);
                            } else if (imgUploadType === 2) {
                                $('#selected-images').prepend(selectedImages);
                            }
                            selectedSection.removeClass('d-none');
                            // lastInsertedId = insertedId;
                            // lastInsertedImagePath = imgFullPath;
                            // lastImageName = imagename;
                        });
                        // if (lastInsertedId !== null && lastInsertedImagePath !== null) {
                        // 	// console.log(lastInsertedImagePath +' '+lastInsertedId);
                        // 	// Update another section with the last inserted image data
                        // 	$('.img-caption-update').attr('src', lastInsertedImagePath);
                        // 	$('.img-caption-update').attr('data-img-cap-id', lastInsertedId);
                        // 	$('.img-info').text(lastImageName);
                        // }
                        // $('#HeadCaption').val('')
                    },
                    error: function(xhr, status, error) {
                        var errors = JSON.parse(xhr.responseText);
                        // Check if the status is 'errors'
                        if (errors.status === 'errors') {
                            var errorMessage = '';

                            // Loop through validation errors and concatenate them
                            $.each(errors.errors, function(key, value) {
                                errorMessage += value[0] +
                                    '<br>'; // Assuming you want to display only the first error message
                            });

                            // Display error message in your Blade view
                            $('#errDiv').html(errorMessage);
                            btnDisable.removeAttr('disabled')
                            dropifyDisable.css('pointer-events', 'auto');
                        }
                        // Handle error messages
                    }
                });
            } else {
                errDiv.text('Please select image');
                // Perform alternate actions if needed
            }
        });

        $(document).on('click', '.modal-close-btn', function() {
            resetModal();
        });
        $(document).on('click', '.update-img-archive', function(e) {
            e.preventDefault();
            var errCapDiv = $('#errCapDiv');
            var caption = $('#HeadCaption').val()
            var archiveID = $('.img-caption-update').attr('data-img-cap-id');
            if (caption) {
                var formData = new FormData();
                formData.append('HeadCaption', caption);
                formData.append('archiveID', archiveID);
                $.ajax({
                    url: "/archive/image/update",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response);
                        $('.img_' + archiveID).attr('data-img-caption', caption)
                        $('.selected_id_' + archiveID).attr('data-img-caption', caption)
                        errCapDiv.empty();
                        $('#successCap').html(
                                '<i class="fas fa-check-circle me-2"></i> Image Updated Successfully'
                            )
                            .fadeIn().delay(3000).fadeOut('fast');
                    },
                    error: function(xhr, status, error) {
                        var errors = JSON.parse(xhr.responseText);
                        if (errors.status === 'errors') {
                            var errorMessage = '';
                            // Loop through validation errors and concatenate them
                            $.each(errors.errors, function(key, value) {
                                errorMessage += value[0];
                            });
                            errCapDiv.text(errorMessage);
                        }
                    }
                });
            }
        });
        $(document).on('click','.remove-selected-img', function(e){
            var removeID = $(this).attr('data-remove-id')
            $('.img_'+removeID).parent().removeClass('selected')
            $(this).parent().remove()
            var selectedCount = $('.image-wrapper.selected').length;

            if (selectedCount === 0) {
                $('.selected-section').addClass('d-none');
            } else {
                $('.selected-section').removeClass('d-none');
            }
        });

        function dropifyReset() {
            $('.dropify-preview').css('display', 'none');
            $('.dropify-wrapper').removeClass('has-preview');
            $('.dropify-render').empty();
        }

        function resetModal() {
            $('#img-search-result').html('');
            $('#selected-images').html('');
            $('.selected-section').addClass('d-none');
            $('.attachment-sidebar').addClass('d-none');
            $('#SearchImage').val('');
            $('#errorDiv').text('');
            $('#errDiv').text('');
            $('.img-caption-update').attr('src', '');
            $('.img-caption-update').attr('data-img-cap-id', '');
            $('.img-preview-section').removeClass('col-sm-7').addClass('col-sm-12')
            $('.img-info').text('')
            dropifyReset();
        }
        $("#image-section").sortable({
		   update: function(event, ui) {
			   updatePositions();
		   }
	    });
   
	   function updatePositions() {
		   $("#image-section .image-row").each(function(index) {
			   $(this).find('.position').val(index + 1);
		   });
	    }
        // function applyShimmerEffect(container) {
        //     container.find('.img-fluid.lazyload').each(function() {
        //         var $img = $(this);
        //         var $placeholder = $img.closest('.image-wrapper').find('.placeholder');

        //         // Show shimmer effect
        //         $placeholder.append('<div class="shimmer"></div>');

        //         // Load image
        //         var tempImg = new Image();
        //         tempImg.onload = function() {
        //             // Remove shimmer effect once image is loaded
        //             $placeholder.find('.shimmer').remove();
        //             // Show image with fade-in effect
        //             $img.hide().fadeIn();
        //         };
        //         tempImg.src = $img.attr('data-src');
        //     });
        // }
    });
</script>
<script>
	$(document).on('click', '.remove-added-img', function(event) {
		event.preventDefault();
		var div_section = $(this).attr('data-img-div');
		$('#'+div_section).find('.img-section img').attr('src', "{{ asset('noobtrader/laravelmedialibrary/dummy.jpg') }}");
		$('#'+div_section).find('.remove-added-img').remove();
	});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
<script>
     $('.dropify').dropify();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>