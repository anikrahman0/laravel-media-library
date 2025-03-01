<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style>
span.file-icon p {
    font-size: 20px !important;
    color: #CCC !important;
}
.image-gallery .nav-tabs {
    border: 0;
}

.image-gallery .nav-tabs .nav-item {
    border: 1px solid #dee2e6 !important;
}

#selected-images i {
  background: #fff;
  position: absolute;
  right: 1px;
  border-radius: 50%;
  top: -4px;
}
.sl-img {
  position: relative;
  margin-right:3px;
}

#selected-images img {
    border: 1px solid #009734;
}

.image-gallery .nav-tabs .nav-link {
    color: #48aa4b;
}

.image-gallery .nav-tabs .nav-link:focus,
.image-gallery .nav-tabs .nav-link:hover {
    border-color: #48aa4b;
    isolation: isolate;
    border-radius: 0;
}

.image-gallery .nav-tabs .nav-item.show .nav-link,
.image-gallery .nav-tabs .nav-link.active {
    color: #fcfdff;
    background-color: #48aa4b;
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
}
.image-gallery .upload-btn {
    background-color: #48aa4b;
    border-color: #48aa4b;
    margin-top: 24px;
    padding: 8px;
    font-size: 18px;
    font-weight: 500;
    color: #fff;
    outline: 0;
    border: 0;
    margin-top: 15px;
    transition: .3s aall;
    width: 100%;
}
.img-info {
  font-size: 13px;
  font-weight: 600;
  color: #4c4545;
  word-wrap: break-word;
  overflow-wrap: break-word;
  word-break: break-all;
}
.selected-section {
	border-top: 1px solid #dee2e6;
	box-shadow: 0px 0px 3px 1px #0000001e;
	padding: 15px;
	background: #f5f5f5;
}
.img-preview-section {
	border-bottom: 1px solid #ccc;
  margin-bottom: 15px;
  padding-bottom: 20px;
}
.selected-img-label {
  color: #33852f;
  font-weight: 600;
  padding-top: 4px;
  font-size: 14px;
}
#selected-images img {
	border: 1px solid #009734;
}

.edit-section {
    background: #48aa4b3b;
    color: #48aa4b;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
}
.edit-section.active {
    background: #48aa4b;
    color: #ffffff;
}
.remove-icon {
    color: #ef8787;
    font-size: 17px;
    background: #fff;
    border-radius: 50%;
}
.img-section{
  position: relative;
}
.remove-added-img,.delete-bg-img {
	position: absolute;
	right: -8px;
	top: -10px;
}
.image-row {
  cursor: move;
}
.content-details-gal .image-row {
  cursor: default;
}
i.fas.fa-trash-alt.text-danger.remove-img:hover {
  cursor: pointer;
}
.btn-change {
  color: #48aa4b;
  background-color: none;
  border: 1px solid #48aa4b;
  font-weight: 500;
}
.btn-change:hover {
  color: #fff;
  background-color: #48aa4b;
  font-weight: 600;
  border: 1px solid #48aa4b;
  transition: opacity 0.3s ease-in-out;
}
.btn-tag{
  background-color: #1c3271;
  border: 1px solid #1c3271;
  color: #fff;
}
.btn-tag:hover{
  color: #fff;
}
/* Placeholder image container */
.placeholder {
    position: relative;
    width: 100%;
    height: 100%;
}

/* Shimmer animation */
.shimmer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, #f6f7f8 4%, #edeef1 25%, #f6f7f8 36%);
    background-size: 1000px 100%;
    animation: shimmer 1.5s infinite linear;
}

.sortable1, .sortable2, .sortable3 {
  list-style-type: none;
  margin: 0;
  background: #eee;
  padding: 5px;
}

.bg-custom {
  background: #ffffff;
  color: #48aa4b;
}

.image-wrapper{
    position: relative;
}
.selected .check {
	position: absolute;
	top: 0;
	right: 0;
	background-color: #48aa4b;
	height: 20px;
	width: 20px;
	line-height: 1;
	text-align: center;
	box-shadow: 0px 0px 1px 2px #48aa4b;
	border: 1px solid #fff;
  cursor: pointer;
}
.check i{
    font-size: 14px;
    color: #fff;
}
.selected {
	box-shadow: 0px 0px 1px 3px #48aa4b;
	border: 1px solid #fff;
}
.showing {
    display: inline;
}

.hide {
    display: none;
    visibility: hidden;
}

.check:hover .showing {
    display: none;
}

.check:hover .hide {
    display: inline;
    visibility: visible;
}

.scrollable {
    overflow-y: auto;
    max-height: 300px; /* Adjust this value to match the maxHeight in JavaScript */
}
#position-right,.scrollable {
    overflow-y: auto;
    max-height: 400px; /* Adjust this value to match the maxHeight in JavaScript */
}
.img-caption-section {
  background: #f3f3f3;
  padding: 10px 18px;
  border-radius: 3px;
  border: 1px solid #ced4da;
}
.SearchType {
    border: 1px solid #ced4da;
    color: gray;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    outline: 0;
    font-size: 15px;
    background: #f1f1f1;
    padding-left: 6px;
    padding-right: 6px;
}
.img-details {
    font-size: 13px;
    color: #48aa4b;
}
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}
</style>