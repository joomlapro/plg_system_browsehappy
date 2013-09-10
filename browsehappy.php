<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.Browsehappy
 *
 * @author      Bruno Batista <bruno@atomtech.com.br>
 * @copyright   Copyright (C) 2013 AtomTech IT Services. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Joomla Browsehappy plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Browsehappy
 * @author      Bruno Batista <bruno@atomtech.com.br>
 * @since       3.1
 */
class PlgSystemBrowsehappy extends JPlugin
{
	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The object to observe.
	 * @param   array   $config    An array that holds the plugin configuration.
	 *
	 * @access  protected
	 * @since   3.1
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);

		$this->loadLanguage();
	}

	/**
	 * After the framework has dispatched the application.
	 *
	 * @return  void
	 *
	 * @since   3.1
	 */
	public function onAfterDispatch()
	{
		// Check that we are in the site application.
		if (JFactory::getApplication()->isAdmin())
		{
			return true;
		}

		// Get the document object.
		$doc = JFactory::getDocument();

		// Get the browser object instance.
		$browser = JBrowser::getInstance();

		// Add JavaScript Frameworks.
		JHtml::_('jquery.framework');

		if ($browser->getBrowser() == 'msie' && intval($browser->getMajor()) < $this->params->get('minimal', 7))
		{
			// Load Stylesheet.
			JHtml::stylesheet('plg_system_browsehappy/template.css', false, true, false);

			// Build the message.
			$message = '<p class="browsehappy">' . JText::_('PLG_SYSTEM_BROWSEHAPPY_MESSAGE') . '</p>';

			// Build the script.
			$script = array();
			$script[] = 'jQuery(document).ready(function() {';
			$script[] = '  jQuery(\'body\').prepend(\'' . $message . '\');';
			$script[] = '});';

			// Add the script to the document head.
			$doc->addScriptDeclaration(implode("\n", $script));
		}

		return true;
	}
}
