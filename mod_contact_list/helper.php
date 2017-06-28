<?php
/**
 * @package     dev-siberia.ru
 * @subpackage  mod_contact_list
 *
 * @copyright   Copyright (C) 2017 All rights reserved.
 * @license     Commercial License
 */

defined('_JEXEC') or die;

JLoader::register('ContactHelperRoute', JPATH_SITE . '/components/com_contact/helpers/route.php');
JModelLegacy::addIncludePath(__DIR__ . '/models','ContactModel'); 

/**
 * Helper for mod_contacts_list
 *
 * @since  1.6
 */
abstract class ModContactListHelper
{
	/**
	 * Get a list of the contacts from the contacts model
	 *
	 * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
	 *
	 * @return  mixed
	 *
	 * @since 1.6
	 */
	public static function getList(&$params)
	{
		// Get an instance of the generic contacts model
		$model= JModelLegacy::getInstance('Contacts', 'ContactModel',array('ignore_request' => true));
		
		// Set application parameters in model
		$app = JFactory::getApplication();		
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
		
		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $params->get('count',5));
		$model->setState('filter.published', 1);
		
		// Access filter
		$access = !JComponentHelper::getParams('com_contact')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));		
		$model->setState('filter.access', $access);
		
		$model->setState('list.select', 'a.id, a.name, a.catid, con_position' . ', a.address, a.suburb, a.postcode, a.state, a.telephone' .', a.published, a.access, a.ordering, a.language'.', a.publish_up, a.publish_down');		
		
		$categoryId = $params->get('catid', array());	
		
		// Category filter
		$model->setState('filter.category_id', $categoryId);
		
		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());		
		
		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1' :
				$model->setState('filter.featured', 'only');
				break;
			case '0' :
				$model->setState('filter.featured', 'hide');
				break;
			default :
				$model->setState('filter.featured', 'show');
				break;
		}
		
		// Set ordering
		$ordering = $params->get('ordering', 'a.publish_up');
		$model->setState('list.ordering', $ordering);

		if (trim($ordering) === 'rand()')
		{
			$model->setState('list.ordering', JFactory::getDbo()->getQuery(true)->Rand());
		}
		else
		{
			$direction = $params->get('direction', 1) ? 'DESC' : 'ASC';
			$model->setState('list.direction', $direction);
			$model->setState('list.ordering', $ordering);
		}
		
		// Check if we should trigger additional plugin events
		$triggerEvents = $params->get('triggerevents', 1);
		
		// Retrieve Contacts
		$items = $model->getItems();
		
		return $items;
	}
	
	public static function fetchHead($params){
		$document	= JFactory::getDocument();
		$header = $document->getHeadData();
		$mainframe = JFactory::getApplication();
		$template = $mainframe->getTemplate();

		if(file_exists(JPATH_BASE.'/templates/'.$template.'/html/mod_contact_list/css/contact_list.css'))
		{
			$document->addStyleSheet(JURI::root().'templates/'.$template.'/html/mod_contact_list/css/contact_list.css');
		}
		else{
			$document->addStyleSheet(JURI::root().'modules/mod_contact_list/tmpl/css/contact_list.css');
		}

		/* $loadJquery = true;
		switch($params->get('loadJquery',"auto")){
			case "0":
				$loadJquery = false;
				break;
			case "1":
				$loadJquery = true;
				break;
			case "auto":

				foreach($header['scripts'] as $scriptName => $scriptData)
				{
					if(substr_count($scriptName,'/jquery'))
					{
						$loadJquery = false;
						break;
					}
				}
			break;
		}
		
		if($loadJquery)
		{
			$document->addScript(JURI::root().'modules/mod_contacts_list/tmpl/js/jquery.min.js');
		}
		$document->addScript(JURI::root().'modules/mod_contacts_list/tmpl/js/slides.js');
		$document->addScript(JURI::root().'modules/mod_contacts_list/tmpl/js/default.js');
		$document->addScript(JURI::root().'modules/mod_contacts_list/tmpl/js/jquery.easing.1.3.js'); */
	}
}
