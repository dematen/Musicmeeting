<?php
/**
 * @version 1.9.5
 * @package JEM
 * @copyright (C) 2013-2013 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the JEM View
 */
class JEMViewMyattendances extends JViewLegacy
{
	/**
	 * Creates the Myattendances View
	 */
	function display($tpl = null)
	{
		$app = JFactory::getApplication();

		//initialize variables
		$document 		= JFactory::getDocument();
		$jemsettings 	= JEMHelper::config();
		$settings 		= JEMHelper::globalattribs();
		$menu 			= $app->getMenu();
		$item 			= $menu->getActive();
		$params 		= $app->getParams();
		$uri 			= JFactory::getURI();
		$user			= JFactory::getUser();
		$pathway 		= $app->getPathWay();
		$db  			= JFactory::getDBO();

		//redirect if not logged in
		if (!$user->get('id')) {
			$app->enqueueMessage(JText::_('COM_JEM_NEED_LOGGED_IN'), 'error');
			return false;
		}

		// Load css
		JHtml::_('stylesheet', 'com_jem/jem.css', array(), true);
		$document->addCustomTag('<!--[if IE]><style type="text/css">.floattext{zoom:1;}, * html #jem dd { height: 1%; }</style><![endif]-->');


		$attending 	= $this->get('Attending');
		$attending_pagination 	= $this->get('AttendingPagination');

		//are attendences available?
		if (!$attending) {
			$noattending = 1;
		} else {
			$noattending = 0;
		}
		// get variables
		$filter_order		= $app->getUserStateFromRequest('com_jem.myattendances.filter_order', 'filter_order', 	'a.dates', 'cmd');
		$filter_order_Dir	= $app->getUserStateFromRequest('com_jem.myattendances.filter_order_Dir', 'filter_order_Dir',	'', 'word');
// 		$filter_state 		= $app->getUserStateFromRequest('com_jem.myattendances.filter_state', 'filter_state', 	'*', 'word');
		$filter 			= $app->getUserStateFromRequest('com_jem.myattendances.filter', 'filter', '', 'int');
		$search 			= $app->getUserStateFromRequest('com_jem.myattendances.filter_search', 'filter_search', '', 'string');
		$search 			= $db->escape(trim(JString::strtolower($search)));

		$task 				= JRequest::getWord('task');

		//search filter
		$filters = array();

		if ($jemsettings->showtitle == 1) {
			$filters[] = JHtml::_('select.option', '1', JText::_('COM_JEM_TITLE'));
		}
		if ($jemsettings->showlocate == 1) {
			$filters[] = JHtml::_('select.option', '2', JText::_('COM_JEM_VENUE'));
		}
		if ($jemsettings->showcity == 1) {
			$filters[] = JHtml::_('select.option', '3', JText::_('COM_JEM_CITY'));
		}
		if ($jemsettings->showcat == 1) {
			$filters[] = JHtml::_('select.option', '4', JText::_('COM_JEM_CATEGORY'));
		}
		if ($jemsettings->showstate == 1) {
			$filters[] = JHtml::_('select.option', '5', JText::_('COM_JEM_STATE'));
		}
		$lists['filter'] = JHtml::_('select.genericlist', $filters, 'filter', 'size="1" class="inputbox"', 'value', 'text', $filter);

		// search filter
		$lists['search']= $search;

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		//params
		$params->def('page_title', $item->title);

		//pathway
		if($item) $pathway->setItemName(1, $item->title);

		//Set Page title
		$pagetitle = $params->get('page_title', JText::_('COM_JEM_MY_ATTENDING'));
		$document->setTitle($pagetitle);
		$document->setMetaData('title', $pagetitle);

		$this->action					= $uri->toString();
		$this->attending				= $attending;
		$this->task						= $task;
		$this->params					= $params;
		$this->attending_pagination 	= $attending_pagination;
		$this->jemsettings				= $jemsettings;
		$this->settings					= $settings;
		$this->pagetitle				= $pagetitle;
		$this->lists 					= $lists;
		$this->noattending				= $noattending;

		parent::display($tpl);
	}
}
?>