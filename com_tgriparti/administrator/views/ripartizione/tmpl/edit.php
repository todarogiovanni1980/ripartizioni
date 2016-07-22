<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Tgriparti
 * @author     Todaro Giovanni <Info@todarogiovanni.eu>
 * @copyright  2016 Todaro Giovanni - Consiglio Nazionale delle Ricerche -  Istituto per le Tecnologie Didattiche
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_tgriparti/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.nominativo').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('nominativohidden')){
			js('#jform_nominativo option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_nominativo").trigger("liszt:updated");
	js('input:hidden.ripartizione').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('ripartizionehidden')){
			js('#jform_ripartizione option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_ripartizione").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'ripartizione.cancel') {
			Joomla.submitform(task, document.getElementById('ripartizione-form'));
		}
		else {
			
			if (task != 'ripartizione.cancel' && document.formvalidator.isValid(document.id('ripartizione-form'))) {
				
				Joomla.submitform(task, document.getElementById('ripartizione-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_tgriparti&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="ripartizione-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_TGRIPARTI_TITLE_RIPARTIZIONE', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

					

					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
