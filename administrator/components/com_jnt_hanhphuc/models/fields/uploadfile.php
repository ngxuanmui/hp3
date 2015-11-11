<style type="text/css">
    #sbox-btn-close { display: none; }
</style>

<script type="text/javascript">
    function tmpUpload(files)
    {
		arrFiles = JSON.decode(files);

		if (arrFiles instanceof Array && arrFiles.length > 0)
		{
			html = '<table width="100%" cellspacing="10">';

			Array.each(arrFiles, function(val){

				value = val['files'][0];

				if (value.size > 0)
				{
					hidden = '<input type="hidden" name="tmp_other_img[]" value="' + value.name + '" />';

					html += '<tr>';

					html += '<td width="80"><img src="' + value.thumbnail_url + '" style="width: 70px;" /></td>';
					html += '<td valign="top">'+value.name+'<br><input type="text" name="tmp_desc[]" size="40" placeholder="Input Description" />' + hidden + '</td>';
					html += '<td width="50"><a href="javascript:;" class="delete-file">Xóa ảnh</a></td>';

					html += '</tr>';
				}
			});

			html += '</table>';

			var obj = new Element('table', { html: html, styles: { width: '100%' }, 'class': 'tbl-tmp-upload' })

			obj.inject($('tmp-uploaded'));
		}
    }
    
    $(document.body).addEvent('click:relay(.delete-file)', function(){
		var parent = this.getParent('tr');
		parent.fade('out');
		setTimeout(function(){
			parent.dispose();
		}, 500)
		return false;
    });
</script>
<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Bannerclient Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_ntrip
 * @since		1.6
 */
class JFormFieldUploadFile extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'UploadFile';

	public function getInput() 
	{
		JHtml::_('behavior.modal');
		
		$linkUploadFile = JRoute::_('index.php?option=com_jnt_hanhphuc&view=uploadfile&tmpl=component&format=raw', false);
		
		$html = '<div class="fltlft" style="line-height: 23px;" id="uploaded">';
		
		$html .= '<a href="'.$linkUploadFile.'" class="clear modal button" rel="{handler: \'iframe\', closable: 1}" id="uploadfile">Thêm ảnh</a>';
				
		$html .= '</div><div class="clear" style="margin: 10px 0;"></div>';
		
		return $html;
	}
}
