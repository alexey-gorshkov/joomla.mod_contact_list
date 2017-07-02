<?php
/**
 * @package     dev-siberia.ru
 * @subpackage  mod_contact_list
 *
 * @copyright   Copyright (C) 2017 dev-siberia. All rights reserved.
 * @license     License GNU General Public License version 3
 */

defined('_JEXEC') or die;
?>
<svg style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	<defs>
		<symbol id="icon-circle-up" viewBox="0 0 32 32">
			<title>circle-up</title>
			<path d="M0 16c0 8.837 7.163 16 16 16s16-7.163 16-16-7.163-16-16-16-16 7.163-16 16zM29 16c0 7.18-5.82 13-13 13s-13-5.82-13-13 5.82-13 13-13 13 5.82 13 13z"></path>
			<path d="M22.086 20.914l2.829-2.829-8.914-8.914-8.914 8.914 2.828 2.828 6.086-6.086z"></path>
		</symbol>
		<symbol id="icon-circle-down" viewBox="0 0 32 32">
			<title>circle-down</title>
			<path d="M32 16c0-8.837-7.163-16-16-16s-16 7.163-16 16 7.163 16 16 16 16-7.163 16-16zM3 16c0-7.18 5.82-13 13-13s13 5.82 13 13-5.82 13-13 13-13-5.82-13-13z"></path>
			<path d="M9.914 11.086l-2.829 2.829 8.914 8.914 8.914-8.914-2.828-2.828-6.086 6.086z"></path>
		</symbol>
	</defs>
</svg>
<div class="contact-block">
	<button type="button" style="display:none;" class="btn btn-default btn-xs arrow-prev" aria-hidden="true" onClick="showPrevGroup(this);">
		<svg class="icon icon-circle-up"><use xlink:href="#icon-circle-up"></use></svg>
	</button>
	<div class="contact-list<?php echo $moduleclass_sfx; ?>">
		<?php if(count($list->items)) : ?>

		<div class="group-items group0">
			<?php foreach ($list->items as $item) : ?>
				<?php require JModuleHelper::getLayoutPath('mod_contact_list', '_item'); ?>		
			<?php endforeach; ?>
		</div>
		
		<?php endif; ?>		
	</div>
	<button type="button" class="btn btn-default btn-xs arrow-next" aria-hidden="true" onClick="showNextGroup(this);">
		<svg class="icon icon-circle-down"><use xlink:href="#icon-circle-down"></use></svg>
	</button>
	<!-- form params -->
	<form id="form-params">		
		<input type="hidden" name="title" value="<?php echo $module->title; ?>"/>
		<input type="hidden" name="page" value="0"/>		
	</form>
</div>