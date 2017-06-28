<?php
/**
 * @package     dev-siberia.ru
 * @subpackage  mod_contact_list
 *
 * @copyright   Copyright (C) 2017 dev-siberia. All rights reserved.
 * @license     License GNU General Public License version 3
 */

defined('_JEXEC') or die;

$item_heading = $params->get('item_heading', 'h4');
?>

<div class="contact-item">

	<!-- должность -->
	<?php if ($params->get('item_position')) : ?>
		<div class="contact-position">
			<?php echo $item->con_position; ?>
		</div>
	<?php endif; ?>
	
	<!-- Имя -->
	<?php if ($params->get('item_title')) : ?>
		<div class="contact-fio">
		
			<<?php echo $item_heading; ?> class="contact-title<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($params->get('link_titles')) : ?>
				<a href="#">
					<?php echo $item->name; ?>
				</a>
			<?php else : ?>
				<?php echo $item->name; ?>
			<?php endif; ?>
			</<?php echo $item_heading; ?>>
		
		</div>
	<?php endif; ?>	
	
	<div class="contact-number">
		<span><?php echo $item->telephone; ?></span>
	</div>
</div>