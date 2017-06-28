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
<div class="contacts-list<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $item) : ?>
		<?php require JModuleHelper::getLayoutPath('mod_contact_list', '_item'); ?>		
	<?php endforeach; ?>
</div>