<?php

/**
 * @version    CVS: 1.0.9
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 *
 * @since  1.6
 */
class TgripartiViewRicevuta extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $form;

	protected $params;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$app  = JFactory::getApplication();
		$user = JFactory::getUser();

		$this->state  = $this->get('State');
		$this->item   = $this->get('Data');
		$this->params = $app->getParams('com_tgriparti');
		$condominioId     = $app->input->getInt('condominioId', 0);


		//istanza della classe modello nominativi
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_tgriparti/models');
		$modelNominativi = JModelLegacy::getInstance( 'nominativi', 'tgripartiModel' );
		$modelNominativi->setState("filter.condominio",$condominioId);
		$this->nominativi = $modelNominativi->getItems();

		// lettura precedente
		// query sql per prendere il penultimo
		//		select * from o9xqg_tgriparti_ricevuta where condominio=1 order by data DESC limit 1,1
		$db = JFactory::getDbo();
		$queryRicevuta = $db->getQuery(true);
		$queryRicevuta
			->select('*')
			->from($db->quoteName('#__tgriparti_ricevuta'))
			->where($db->quoteName('condominio') . ' = ' . $condominioId)
			->order('data DESC '.' limit 1,1');

		$db->setQuery($queryRicevuta);
		//JFactory::getApplication()->enqueueMessage("$queryRicevuta");
		$resultRicevuta = $db->loadObject();
		//throw new Exception($queryRicevuta);
		if ($resultRicevuta) {
			$idRipartizionePrecedente = $resultRicevuta->id;
			//JFactory::getApplication()->enqueueMessage("Ricevuta precedente $idRipartizionePrecedente");
		} else {
			JFactory::getApplication()->enqueueMessage("Nessuna Ricevuta precedente...");
		}


		$textValue = array();
		foreach ($this->nominativi as $nominativo)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query
				->select('`lettura`,id')
				->from($db->quoteName('#__tgriparti_lettura'))
				->where($db->quoteName('nominativo') . ' = ' . $nominativo->id)
				->where($db->quoteName('ripartizione') . ' = ' . $this->item->id);
			$db->setQuery($query);
			$result = $db->loadObject();
			//throw new Exception($query);
			if ($result) {
				$nominativo->letturaAttuale  = $result->lettura;
				$nominativo->letturaAttualeID= $result->id;
			}

			$queryLetturaPrecedente = $db->getQuery(true);
			$queryLetturaPrecedente
				->select('`lettura`,id')
				->from($db->quoteName('#__tgriparti_lettura'))
				->where($db->quoteName('nominativo') . ' = ' . $nominativo->id)
				->where($db->quoteName('ripartizione') . ' = ' . $idRipartizionePrecedente);
			$db->setQuery($queryLetturaPrecedente);
			$resultLetturaPrecedente = $db->loadObject();
			//throw new Exception($query);
			if ($resultLetturaPrecedente) {
				$nominativo->letturaPrecedente  = $resultLetturaPrecedente->lettura;
				$nominativo->letturaPrecedenteID= $resultLetturaPrecedente->id;
			}

			$nominativo->consumo = $nominativo->letturaAttuale - $nominativo->letturaPrecedente;
			$nominativo->consumoTotale = $nominativo->consumo;

			$e11=$nominativo->consumoTotale;
			$f11=$e11;
			if ($f11>=15){
				$g11 = 15;
			} else {
				$g11 = $e11;
			}
			$nominativo->tariffaAgevolata=round($g11*1.240477,2) ;

			$i11=0;
			if ($f11>23) {
				$i11=8;
			} else {
				$i11=$f11-$g11;
			}
			$nominativo->tariffaBase=round($i11*1.905744,2);

			$h11=0;
			if ($e11>23){
				$h11=8;
			} else {
				$h11=$e11-$f11;
			}

			if($e11<=33){
				$j11=$e11-$f11-$h11;
			} else {
				$j11=10;
			}
			$nominativo->primasoglia=2.471495*$j11;
		}

		// lettura precedente
		// query sql per prendere il penultimo
//		select * from o9xqg_tgriparti_ricevuta where condominio=1 order by data DESC limit 1,1


		if (!empty($this->item))
		{
			$this->form = $this->get('Form');
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}



		if ($this->_layout == 'edit')
		{
			$authorised = $user->authorise('core.create', 'com_tgriparti');

			if ($authorised !== true)
			{
				throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function _prepareDocument()
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// We need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_TGRIPARTI_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->get('sitename');
		}
		elseif ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
