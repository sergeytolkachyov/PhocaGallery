<?php
/*
 * @package Joomla
 * @copyright Copyright (C) Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @component Phoca Gallery
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die;

$task		= 'phocagalleryc';

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$r 			=  new PhocaGalleryRenderAdminView();
$app		= JFactory::getApplication();
$option 	= $app->input->get('option');
$OPT		= strtoupper($option);
?>
<script type="text/javascript">
Joomla.submitbutton = function(task) {
	if (task == 'phocagalleryc.cancel' || document.formvalidator.isValid(document.getElementById('adminForm'))) {
		if (task == 'phocagalleryc.loadextimgp') {
			document.getElementById('loading-ext-imgp').style.display='block';
		}
		if (task == 'phocagalleryc.loadextimgf') {
			document.getElementById('loading-ext-imgf').style.display='block';
		}
		if (task == 'phocagalleryc.uploadextimgf') {
			document.getElementById('uploading-ext-imgf').style.display='block';
		}
		<?php echo $this->form->getField('description')->save(); ?>
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
	else {
		alert('<?php echo JText::_('JGLOBAL_VALIDATION_FORM_FAILED', true);?>');
	}
}
</script><?php
echo $r->startForm($option, $task, $this->item->id, 'adminForm', 'adminForm');
// First Column
echo '<div class="span10 form-horizontal">';
$tabs = array (
'general' 		=> JText::_($OPT.'_GENERAL_OPTIONS'),
'publishing' 	=> JText::_($OPT.'_PUBLISHING_OPTIONS'),
'metadata'		=> JText::_($OPT.'_METADATA_OPTIONS'),
'picasa'		=> JText::_($OPT.'_PICASA_SETTINGS')/*,
'facebook'		=> JText::_($OPT.'_FB_SETTINGS')*/);
echo $r->navigation($tabs);

echo '<div class="tab-content">'. "\n";

echo '<div class="tab-pane active" id="general">'."\n";
$formArray = array ('title', 'alias', 'parent_id', 'image_id', 'ordering', 'access', 'accessuserid', 'uploaduserid', 'deleteuserid', 'owner_id', 'userfolder', 'latitude', 'longitude', 'zoom', 'geotitle');
echo $r->group($this->form, $formArray);
$formArray = array('description');
echo $r->group($this->form, $formArray, 1);
echo '</div>'. "\n";

echo '<div class="tab-pane" id="publishing">'."\n";
foreach($this->form->getFieldset('publish') as $field) {
	echo '<div class="control-group">';
	if (!$field->hidden) {
		echo '<div class="control-label">'.$field->label.'</div>';
	}
	echo '<div class="controls">';
	echo $field->input;
	echo '</div></div>';
}
echo '</div>';

echo '<div class="tab-pane" id="metadata">'. "\n";
echo $this->loadTemplate('metadata');
echo '</div>'. "\n";

if ($this->tmpl['enablepicasaloading'] == 1) {
	echo '<div class="tab-pane" id="picasa">'. "\n";
	$formArray = array ('extu', 'exta', 'extauth');
	echo $r->group($this->form, $formArray);
	echo '</div>';
}
///
/*
echo '<div class="tab-pane" id="facebook">'. "\n";
// Extid is hidden - only for info if this is an external image (the filename field will be not required)
$formArray = array ('extfbuid', 'extfbcatid');
echo $r->group($this->form, $formArray);
echo '</div>';
*/
echo '</div>';//end tab content
echo '</div>';//end span10
// Second Column
echo '<div class="span2"></div>';//end span2
echo $r->formInputs();
echo $r->endForm();
?>
<div id="loading-ext-imgp"><div class="loading"><div><center><?php echo JHTML::_('image', 'media/com_phocagallery/images/administrator/icon-loading.gif', JText::_('COM_PHOCAGALLERY_LOADING') ) . '</center></div><div>&nbsp;</div><div><center>'. JText::_('COM_PHOCAGALLERY_PICASA_LOADING_DATA'); ?></center></div></div></div>
<div id="loading-ext-imgf"><div class="loading"><div><center><?php echo JHTML::_('image', 'media/com_phocagallery/images/administrator/icon-loading.gif', JText::_('COM_PHOCAGALLERY_LOADING') ) . '</center></div><div>&nbsp;</div><div><center>'. JText::_('COM_PHOCAGALLERY_FACEBOOK_LOADING_DATA'); ?></center></div></div></div>
<div id="uploading-ext-imgf"><div class="loading"><div><center><?php echo JHTML::_('image', 'media/com_phocagallery/images/administrator/icon-loading.gif', JText::_('COM_PHOCAGALLERY_UPLOADING') ) . '</center></div><div>&nbsp;</div><div><center>'. JText::_('COM_PHOCAGALLERY_FB_UPLOADING_DATA'); ?></center></div></div></div>
