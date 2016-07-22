<?php

/**
 * @version    CVS: 1.0.4
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Lettura controller class.
 *
 * @since  1.6
 */
class TgripartiControllerLetturaForm extends JControllerForm
{
	/**
	 * Method to check out an item for editing and redirect to the edit form.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	public function edit($key = NULL, $urlVar = NULL)
	{
		$app = JFactory::getApplication();

		// Get the previous edit id (if any) and the current edit id.
		$previousId = (int) $app->getUserState('com_tgriparti.edit.lettura.id');
		$editId     = $app->input->getInt('id', 0);
		$nominativoId     = $app->input->getInt('nominativo', 0);
		$ricevutaId     = $app->input->getInt('ricevuta', 0);

		// Set the user id for the user to edit in the session.
		$app->setUserState('com_tgriparti.edit.lettura.id', $editId);

		// modifica per gestire la finestra modale
		if ($app->input->getWord('return')) {
	    $app->setUserState('com_tgriparti.edit.letturaform.personalvars.return', $app->input->getVar('return'));
	  }

		// Get the model.
		$model = $this->getModel('LetturaForm', 'TgripartiModel');

		// Check out the item
		if ($editId)
		{
			$model->checkout($editId);
		}

		// Check in the previous user.
		if ($previousId)
		{
			$model->checkin($previousId);
		}

		if ($app->input->getVar('tmpl', null, 'string')) {
			// Redirect to the edit screen.
			$this->setRedirect(JRoute::_("index.php?option=com_tgriparti&view=letturaform&layout=edit&tmpl=component&nominativo=$nominativoId&ricevuta=$ricevutaId", false));
		} else {
			// Redirect to the edit screen.
			$this->setRedirect(JRoute::_('index.php?option=com_tgriparti&view=letturaform&layout=edit', false));		}

	}

	/**
	 * Method to save a user's profile data.
	 *
	 * @return void
	 *
	 * @throws Exception
	 * @since  1.6
	 */
	public function save($key = NULL, $urlVar = NULL)
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('LetturaForm', 'TgripartiModel');

		// Get the user data.
		$data = JFactory::getApplication()->input->get('jform', array(), 'array');

		// Validate the posted data.
		$form = $model->getForm();

		if (!$form)
		{
			throw new Exception($model->getError(), 500);
		}

		// Validate the posted data.
		$data = $model->validate($form, $data);

		// Check for errors.
		if ($data === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			$input = $app->input;
			$jform = $input->get('jform', array(), 'ARRAY');

			// Save the data in the session.
			$app->setUserState('com_tgriparti.edit.lettura.data', $jform);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_tgriparti.edit.lettura.id');
			$this->setRedirect(JRoute::_('index.php?option=com_tgriparti&view=letturaform&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->save($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_tgriparti.edit.lettura.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_tgriparti.edit.lettura.id');
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_tgriparti&view=letturaform&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_tgriparti.edit.lettura.id', null);

		// Gestione della finestra modale
		if($return=$app->input->get('return')){
    	$app->setUserState('com_tgriparti.edit.letturaform.personalvars', null);
    	echo '<script type="text/javascript"> parent.location.href="' . base64_decode($return) . '";</script>';
    	exit();
	 	}

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_TGRIPARTI_ITEM_SAVED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_tgriparti&view=letture' : $item->link);
		$this->setRedirect(JRoute::_($url, false));



		// Flush the data from the session.
		$app->setUserState('com_tgriparti.edit.lettura.data', null);
	}

	/**
	 * Method to abort current operation
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function cancel($key = NULL)
	{
		$app = JFactory::getApplication();

		// Get the current edit id.
		$editId = (int) $app->getUserState('com_tgriparti.edit.lettura.id');

		// Get the model.
		$model = $this->getModel('LetturaForm', 'TgripartiModel');

		// Check in the item
		if ($editId)
		{
			$model->checkin($editId);
		}

		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_tgriparti&view=letture' : $item->link);
		$this->setRedirect(JRoute::_($url, false));
	}

	/**
	 * Method to remove data
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function remove()
	{
		// Initialise variables.
		$app   = JFactory::getApplication();
		$model = $this->getModel('LetturaForm', 'TgripartiModel');

		// Get the user data.
		$data       = array();
		$data['id'] = $app->input->getInt('id');

		// Check for errors.
		if (empty($data['id']))
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_tgriparti.edit.lettura.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_tgriparti.edit.lettura.id');
			$this->setRedirect(JRoute::_('index.php?option=com_tgriparti&view=lettura&layout=edit&id=' . $id, false));
		}

		// Attempt to save the data.
		$return = $model->delete($data);

		// Check for errors.
		if ($return === false)
		{
			// Save the data in the session.
			$app->setUserState('com_tgriparti.edit.lettura.data', $data);

			// Redirect back to the edit screen.
			$id = (int) $app->getUserState('com_tgriparti.edit.lettura.id');
			$this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_tgriparti&view=lettura&layout=edit&id=' . $id, false));
		}

		// Check in the profile.
		if ($return)
		{
			$model->checkin($return);
		}

		// Clear the profile id from the session.
		$app->setUserState('com_tgriparti.edit.lettura.id', null);

		// Redirect to the list screen.
		$this->setMessage(JText::_('COM_TGRIPARTI_ITEM_DELETED_SUCCESSFULLY'));
		$menu = JFactory::getApplication()->getMenu();
		$item = $menu->getActive();
		$url  = (empty($item->link) ? 'index.php?option=com_tgriparti&view=letture' : $item->link);
		$this->setRedirect(JRoute::_($url, false));

		// Flush the data from the session.
		$app->setUserState('com_tgriparti.edit.lettura.data', null);
	}
}
