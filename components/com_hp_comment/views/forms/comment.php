<?php
//var_dump($listComments);

// $itemId & $itemType was get in JEUtile::showForm

?>

<div class="clr"></div>

<div class="comments">
	
	<div class="list-comments">
		
		<div class="comment-content">
			<?php
			if (!empty($listComments)):
			?>
			<h1>Thông tin bình luận</h1>
			<?php endif; ?>
			<?php foreach ($listComments as $comment): ?>
			<div class="avatar fltlft">
				<img src="<?php // echo NtripFrontHelper::getAvatar($comment->created_by); ?>" />
			</div>
			<div class="comment-content-container fltlft">
				<div class="comment-user-info">
					<div class="fltlft bold"><?php echo $comment->username ? $comment->username : $comment->guest_fullname; ?> </div>
					<div class="fltlft">&nbsp;(<?php echo date('H:i d/m/Y', strtotime($comment->created)); ?>)</div>
					<div class="clr"></div>
				</div>
				
				<p><?php echo $comment->content; ?></p>
				
				<div class="clr"></div>
				
				
				<?php
				$subComments = $comment->subComments ? $comment->subComments : array();
				if (!empty($subComments)):
					foreach ($subComments as $sub):
				?>
				<div class="list-other-comments">
					<div class="comment-user-info fltlft display-none">
						Quản lý <?php echo $sub->item_title; ?>
					</div>
					<div class="clr"></div>
					<div class="fltlft">
						<div class="comment-user-info">
							<div class="fltlft bold"><?php echo $sub->username; ?> </div>
							<div class="fltlft">&nbsp;(<?php echo date('H:i d/m/Y', strtotime($sub->created)); ?>)</div>
							<div class="clr"></div>
						</div>
						
						<div class="sub-comment-content fltlft">
								<?php echo $sub->content; ?>
						</div>
						
						<div class="clr"></div>
					</div>
					
					<div class="clr"></div>
				</div>
				<?php
					endforeach;
				endif;
				?>
					
			</div>
			<div class="clr"></div>
			<?php endforeach; ?>
		</div>
		
		<div class="clr"></div>
	</div>
	
	<?php /* if (JFactory::getUser()->id): */ ?>
	<form action="<?php echo JRoute::_('index.php'); ?>" id="hp-frm-comment">
	
		<input type="hidden" id="item_id" value="<?php echo $itemId; ?>" />
		<input type="hidden" id="item_type" value="<?php echo $itemType; ?>" />
		
		<div class="post-comment" style="margin: 10px 0;">
			<?php /*if ($isItemOwner): ?>
			Gửi bình luận:
			<select name="hp_comment_parent_id" id="comment-parent-id">
				<option value="">Bình luận mới</option>
				<?php
				foreach ($listComments as $comment):
					$author = $comment->username ? $comment->username : 'Anonymous';
				?>
				<option value="<?php echo $comment->id; ?>"><?php echo JHtml::_('string.truncate', $comment->content, 50) . '('.$author.')'; ?></option>
				<?php endforeach; ?>
			</select>
			<?php endif; */ ?>
			<h1>Gửi bình luận của bạn</h1>
			
			<ul class="guest-info">
				<?php if (JFactory::getUser()->guest): ?>
				<li>
					<label><span>*</span> Họ tên:</label>
					<input type="text" name="guest_fullname" id="guest_fullname" class="required" />
				</li>
				<li>
					<label><span>*</span> Email:</label>
					<input type="text" name="guest_email" id="guest_email" class="required email" />
				</li>
				<?php /*?>
				<li>
					<label>Website:</label>
					<input type="text" name="guest_website" id="guest_website" />
				</li>
				*/ ?>
				<li>
					<label><span>*</span> Mã xác nhận:</label>
					<input type="text" name="captcha_code" id="captcha_code" />
				</li>
				<li>
					<label>&nbsp;</label>
					<small>Nhập dãy ký tự bên dưới vào ô Mã xác nhận</small>
				</li>
				<li>
					<label>&nbsp;</label>
					
					<img id="img_captcha" src="<?php echo JRoute::_(JURI::base(true) . '/index.php?option=com_hp_comment&task=captcha&rand=' . rand(0, 10000)); ?>" />
					<a href="#" class="refresh-captcha">Đổi mã xác nhận</a>
				</li>
				<?php endif; ?>
				<li style="position: relative;">
					<label style="position: relative; top: -90px;"><span>*</span> Nội dung</label>
					
					<textarea style="resize: none; height: 100px; width: 400px; margin: 10px 0 0;" id="hp-textarea-comment"></textarea>
					
				</li>
				<li>
					<div class="error comment-msg" id="comment-msg" style="margin-left: 103px; padding: 5px 0; clear: both;"></div>
				</li>
				<li>
					<label>&nbsp;</label>
					<button class="xicons button" id="hp-btn-post-comment" type="button">
						Bình luận
					</button>
				</li>
			</ul>
			
			<div class="clr"></div>
		</div>
					
		
		<?php echo JHtml::_('form.token'); ?>
	</form>
	<?php /* else: ?>
	<div class="user-comment-not-login">Vui lòng đăng nhập để gửi bình luận của bạn.</div>
	<?php endif; */ ?>

	<div class="clr"></div>
</div>