<?php
defined('_JEXEC') or die;

$jqueryUploadFilePath = JURI::root() . 'media/hp/jquery-ui-upload/';
?>

<!-- jQuery UI styles -->
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/base/jquery-ui.css" id="theme">
<!-- CSS to style the file input field as button and adjust the jQuery UI progress bars -->
<link rel="stylesheet" href="<?php echo $jqueryUploadFilePath; ?>css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo $jqueryUploadFilePath; ?>css/jquery.fileupload-ui-noscript.css"></noscript>

<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<style type="text/css">
    .ui-widget { font-size: 11px; }
    .template-upload td, .txt, .template-download td { font-size: 11px; font-family: sans-serif; }
    .txt { width: 50px; border: 1px solid #CCC; }
    .files .progress { height: 10px; width: 150px; }
</style>

<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="/" method="POST" enctype="multipart/form-data">
	<!-- Redirect browsers with JavaScript disabled to the origin page -->
	<noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
	<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	<div class="row fileupload-buttonbar">
		<div class="span7">
			<!-- The fileinput-button span is used to style the file input field as button -->
			<span class="btn btn-success fileinput-button">
				<i class="icon-plus icon-white"></i>
				<span>Add files...</span>
				<input type="file" name="files[]" multiple>
			</span>
			<button type="submit" class="btn btn-primary start">
				<i class="icon-upload icon-white"></i>
				<span>Start upload</span>
			</button>
			<button type="reset" class="btn btn-warning cancel">
				<i class="icon-ban-circle icon-white"></i>
				<span>Cancel upload</span>
			</button>
			<button type="button" class="close-add" id="btn-close-add">Close</button>
		</div>
	</div>
	<!-- The loading indicator is shown during file processing -->
	<div class="fileupload-loading"></div>
	<br>
	<!-- The table listing the files available for upload/download -->
	<table role="presentation" class="table table-striped" width="100%">
	    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
	</table>
</form>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name" valign="top">
	    <span>{%=file.name%}</span>
	</td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td style="width: 150px;">
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>Cancel</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete" style="display: none;">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
            </button>
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script src="<?php echo JURI::root(); ?>media/hp/tmpl.min.js"></script>
<script src="<?php echo JURI::root(); ?>media/hp/load-image.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::root(); ?>media/hp/canvas-to-blob.min.js"></script>
<script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/jquery.fileupload-fp.js"></script>
<script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/jquery.fileupload-jui.js"></script>
<script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/main.js"></script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script type="text/javascript" src="<?php echo $jqueryUploadFilePath; ?>js/cors/jquery.xdr-transport.js"></script><![endif]-->

<script type="text/javascript">
	// Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        xhrFields: {withCredentials: false},
        url: '<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=uploadfile.handle', false); ?>'
    });
    
    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
	var inputs = data.context.find(':input');
//	if (inputs.filter('[required][value=""]').first().focus().length) {
//	    return false;
//	}
	data.formData = inputs.serializeArray();
    });
    
    jQuery().ready(function($){
	$('button.close').button({ icons: { primary: "ui-icon-close" } });
	$('button.close-add').button({ icons: { primary: "ui-icon-copy" } });
    })
    
$('#btn-close-add').click(function(){
    var url = '<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=uploadfile.close', false); ?>';
    $.get(url, {}, function(data){
		
		if (data.length > 0)
			window.parent.tmpUpload(data);
		
		closeBox();
    });
    
});

$('#btn-close').click(function(){
    closeBox();
});

function closeBox()
{
    window.parent.SqueezeBox.close();
}
</script>