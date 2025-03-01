{{-- imageArchiveModal --}}
<div class="image-gallery modal fade" id="imageArchiveModal" data-bs-backdrop="static" data-bs-keyboard="false"  aria-labelledby="imageArchiveModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg  modal-dialog-centered">
		<div class="modal-content">
		{{-- <div class="modal-header">
			<h4 class="modal-title h5" id="imageArchiveModalLabel">Image Upload</h4>
			<button type="button" class="btn-close img-archive-btn" data-bs-dismiss="modal" aria-label="Close"></button>
		</div> --}}
		<div class="modal-body">
			<div class="container">
				<div class="text-end"><button type="button" class="btn-close modal-close-btn img-archive-btn mt-2 p-0 mb-0" data-bs-dismiss="modal" aria-label="Close"></button></div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
					<button class="nav-link active img-archive-btn img-archive-tab" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa-solid fa-image"></i> Media Gallery</button>
					</li>
					<li class="nav-item" role="presentation">
					<button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa-solid fa-plus"></i> Upload to Gallery</button>
					</li>
				</ul>
				<div class="tab-content mt-4" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="row">
							<div class="col-sm-12 img-preview-section">
								<div class="input-group mb-3 d-flex">
									<select name="" id="SearchType" class="SearchType">
										<option value="1">Image Name</option>
										<option value="2">Caption</option>
									</select>
									<input type="search" name="SearchImage" maxlength="200" value="" class="form-control post-wrapper search-img" id="SearchImage" placeholder="Search for image">
									{{-- <button type="button" id="submitSearch" class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></button> --}}
								</div>
								<div id="errorDiv" class="text-danger"></div>
								<div id="img-search-result" class="row scrollable"> </div>
								<div id="loadingIcon" class="text-center" style="display: none;">
									<img src="{{ asset('noobtrader/laravelmedialibrary/loading_icon.gif') }}" alt="Loading...">
								</div>
							</div>
							<div class="col-sm-5 attachment-sidebar d-none">
								<form action="">
									<div class="img-caption-section">
										<h2 class="mb-3 mt-2 fw-bold img-details">Image Details</h2>
										<img width="300" data-img-cap-id="" class="img-fluid img-caption-update rounded" src="" alt="">
										<div class="attachment-details border-bottom d-flex align-items-center py-2">
											<p class="img-info"></p>
										</div>
										<div class="row mt-2">
											<div class="col-xl-12">
												<div class="inser-form-wrapper">
													<div class="mb-3 mt-3 row gx-0">
														<label for="HeadCaption" class="col-xl-3 col-lg-3 col-form-label text-center">Caption:</label>
														<div class="col-xl-9 col-lg-9">
															<input type="text" name="HeadCaption" class="form-control  post-wrapper" value="" maxlength="10000" id="HeadCaption">
														</div>
													</div>
													<div class="success-error">
														<small id="errCapDiv" class="text-danger"></small>
														<small id="successCap" class="text-success"></small>
													</div>
												</div>
											</div>
										</div>
										<div class="row mt-2 mb-2">
											<div class="col-xl-12 text-end">
												<button type"button" class="btn btn-sm btn-success update-img-archive">Update</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="selected-section mt-2 d-none">
							<div class="selected-img-label">Selected Image(s)</div>
							<div class="">
								<div class="d-flex flex-wrap pt-1" id="selected-images"></div>
								<div class="text-center">
									<button type="button" class="btn btn-sm btn-success mt-3 use-image">Use the image</button>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
						<form id="image-upload-form" enctype="multipart/form-data">
							<div class="input-group">
								<input 
									required 
									type="file" 
									name="ImageArchivePath[]"
									data-height="100"  
									data-min-width="320" 
									data-min-height="180" 
									data-max-width="1920" 
									data-max-height="1080" 
									data-allowed-file-extensions="jpeg jpg png gif bmp webp svg" 
									data-max-file-size="1M" 
									data-max-file-size-preview="1M"
									data-errors-position="outside" 
									class="form-control upload-file-p dropify" 
									id="ImageArchivePath">
									
								@error('ImageArchivePath')
									<span class="text-danger" role="alert">
										<small>{{ $message }}</small>
									</span>
								@enderror
							</div>
							<div class="d-flex align-items-center justify-content-center">
								<button type="button" id="imgUpload" class="upload-btn img-archive-btn"><i class="fa-solid fa-upload"></i> Upload</button>
							</div>
							<div id="loadingIconUpload" class="text-center fw-bold mt-3"></div>
							<div id="errDiv" class="text-danger mt-2"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary modal-close-btn img-archive-btn" data-bs-dismiss="modal">Close</button>
			{{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
		</div>
		</div>
	</div>
</div>