<?php
/**
 * @version 1.9.5
 * @package JEM
 * @copyright (C) 2013-2013 joomlaeventmanager.net
 * @copyright (C) 2005-2009 Christoph Lukes
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * JEM Component Myevents Controller
 *
 * @package JEM
 *
 */
class JEMControllerMyevents extends JControllerLegacy
{
	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Logic to publish events
	 *
	 * @access public
	 * @return void
	 *
	 */
	function publish()
	{	
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
	
		$app = JFactory::getApplication();
		$input = $app->input;
	
		$cid = $input->get('cid', array(0), 'post', 'array');
	
		$false = array_search('0', $cid);
	
		if ($false === 0) {
			JError::raiseNotice(100, JText::_('COM_JEM_SELECT_ITEM_TO_PUBLISH'));
			$this->setRedirect(JEMHelperRoute::getMyEventsRoute());
			return;
		}
	
		$model = $this->getModel('myevents');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
	
		$total = count($cid);
		$msg 	= $total.' '.JText::_('COM_JEM_EVENT_PUBLISHED');
	
		$this->setRedirect(JEMHelperRoute::getMyEventsRoute(), $msg);
	}
	
	/**
	 * Logic for canceling an event and proceed to add a venue
	 */
	function unpublish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
	
		$app = JFactory::getApplication();
		$input = $app->input;
	
		$cid = $input->get('cid', array(0), 'post', 'array');
	
		$false = array_search('0', $cid);
	
		if ($false === 0) {
			JError::raiseNotice(100, JText::_('COM_JEM_SELECT_ITEM_TO_UNPUBLISH'));
			$this->setRedirect(JEMHelperRoute::getMyEventsRoute());
			return;
		}
	
		$model = $this->getModel('myevents');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
	
		$total = count($cid);
		$msg 	= $total.' '.JText::_('COM_JEM_EVENT_UNPUBLISHED');
	
		$this->setRedirect(JEMHelperRoute::getMyEventsRoute(), $msg);
	}
	
	/**
	 * Logic to trash events
	 *
	 * @access public
	 * @return void
	 */
	function trash()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit('Invalid Token');
	
		$app = JFactory::getApplication();
		$input = $app->input;
	
		$cid = $input->get('cid', array(0), 'post', 'array');
	
		$false = array_search('0', $cid);
	
		if ($false === 0) {
			JError::raiseNotice(100, JText::_('COM_JEM_SELECT_ITEM_TO_TRASH'));
			$this->setRedirect(JEMHelperRoute::getMyEventsRoute());
			return;
		}
	
		$model = $this->getModel('myevents');
		if(!$model->publish($cid, -2)) {
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
	
		$total = count($cid);
		$msg 	= $total.' '.JText::_('COM_JEM_EVENT_TRASHED');
	
		$this->setRedirect(JEMHelperRoute::getMyEventsRoute(), $msg);
	}
}
?>