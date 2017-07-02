<?php
/**
 * @package     dev-siberia.ru
 * @subpackage  mod_contact_list
 *
 * @copyright   Copyright (C) 2017 dev-siberia. All rights reserved.
 * @license     License GNU General Public License version 3
 */

defined('_JEXEC') or die;

// Include the news functions only once
JLoader::register('ModContactListHelper', __DIR__ . '/helper.php');

// add addStyleSheet
ModContactListHelper::fetchHead( $params );

$list            = ModContactListHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

// Instantiate global document object
$doc = JFactory::getDocument();

require JModuleHelper::getLayoutPath('mod_contact_list');