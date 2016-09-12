<?php

/**
 * @version    CVS: 1.5
 * @package    com_tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.it>
 * @copyright  2016 Todaro Giovanni
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

 			//JFactory::getApplication()->enqueueMessage("nome... " . $nominativo->nome,"error");
 			$c=$nominativo->letturaAttuale;
 			$d=$nominativo->letturaPrecedente;
 			$e=$c-$d;
 			$f=0;
 			if($e>=15){
 				$f=15;
 			} else {
 				$f=$e;
 			}
 			//JFactory::getApplication()->enqueueMessage("f... $f","error" );
 			$nominativo->tariffaAgevolata=round($f*1.240477,2) ;

 			$h=0;
 			if($e>23){
 				$h=8;
 			} else {
 				$h=$e-$f;
 			}
 			//JFactory::getApplication()->enqueueMessage("h... $h","error" );
 			$nominativo->tariffaBase=round($h*1.905744,2);

 			// Prima soglia
 			$j=0;
 			if($e<33){
 				$j=$e-$f-$h;
 			} else {
 				$j=10;
 			}
 			//JFactory::getApplication()->enqueueMessage("j... $j","error" );
 			$nominativo->primasoglia=round($j*2.471495,2);

 			// Seconda soglia
 			$l=0;
 			if($e<43){
 				$l=$e-$f-$h-$j;
 			} else {
 				$l=10;
 			}
 			//JFactory::getApplication()->enqueueMessage("l... $l","error" );
 			$nominativo->secondasoglia=round($l*3.03105,2);

 			// Terza soglia
 			$n=0;
 			if($e>43){
 				$n=$e-$f-$h-$j-$l;
 			} else {
 				$n=0;
 			}
 			//JFactory::getApplication()->enqueueMessage("n... $n","error" );
 			$nominativo->terzasoglia=round($n*3.590603,2);

 			// Totale Acqua
 			$p=0;
 			$p=$nominativo->tariffaAgevolata+$nominativo->tariffaBase+$nominativo->primasoglia+$nominativo->secondasoglia+$nominativo->terzasoglia;
 			$nominativo->totaleAcqua=$p;


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
