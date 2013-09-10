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
 * Script file of Browsehappy Plugin.
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Browsehappy
 * @author      Bruno Batista <bruno@atomtech.com.br>
 * @since       3.1
 */
class PlgSystemBrowsehappyInstallerScript
{
	/**
	 * Called after any type of action.
	 *
	 * @param   string            $route    Which action is happening (install|uninstall|discover_install).
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   3.1
	 */
	public function postflight($route, JAdapterInstance $adapter)
	{
		// Initialiase variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base update statement.
		$query->update($db->quoteName('#__extensions'))
			->set($db->quoteName('enabled') . ' = ' . $db->quote('1'))
			->where($db->quoteName('name') . ' = ' . $db->quote($adapter->get('name')));

		// Set the query and execute the update.
		$db->setQuery($query);

		try
		{
			$db->execute();
		}
		catch (RuntimeException $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage());

			return false;
		}
	}
}
