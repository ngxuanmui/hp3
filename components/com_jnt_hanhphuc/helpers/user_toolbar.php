<?php

class HP_User_Toolbar
{
	public static function buttonEdit($controller = '')
	{
		$html = array();
		
		$html[] = '<div class="user-toolbar">';
		$html[] = '<button id="btn-apply" class="button" rel="'.$controller.'.apply">Cập nhật</button>';
		$html[] = '<button id="btn-save" class="button" rel="'.$controller.'.save">Lưu thông tin</button>';
		
		$id = JRequest::getInt('id');
		
		$txtButton = ($id) ? 'Quay về Danh sách' : 'Hủy bỏ';
		
		$html[] = '<button id="btn-cancel" class="button cancel" rel="'.$controller.'.cancel">'.$txtButton.'</button>';
		
		$html[] = '</div>';
		
		$button = implode("\n", $html);
		
		return $button;
	}
	
	public static function buttonList($controller = '')
	{
		$html = array();
		
		$html[] = '<div class="user-toolbar">';
		$html[] = '<button id="btn-add" class="button cancel" type="submit" style="margin-right: 10px;" rel="'.$controller.'.add">Thêm mới</button>';		
		$html[] = '</div>';
		
		return implode("\n", $html);
	}
}