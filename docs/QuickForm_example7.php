<?php
/**
* Examples of usage for grouped elements in HTML_QuickForm
*
* @author      Bertrand Mansion <bmansion@mamasam.com>
* @version     2.5
*/
// $Id$

require_once ("HTML/QuickForm.php");
$form = new HTML_QuickForm('frmTest', 'GET');

$form->setFormTemplate('<table width="450" border="0" cellpadding="3" cellspacing="2" bgcolor="#CCCC99">
  <form{attributes}>{content}
  </form>
</table>');

// Fills with some defaults values
$defaultValues['id']        = array('lastname'=>'Mamasam', 'code'=>'1234');
$defaultValues['phoneNo']   = array('513', '123', '3456');
$defaultValues['iradYesNo'] = 'Y';
$defaultValues['ichkABC']   = array('A'=>true,'B'=>true);
$form->setDefaults($defaultValues);

// Grouped elements
$form->addHeader('Tests on grouped elements');

// Creates a group of text inputs with templates
$id['lastname'] = &HTML_QuickForm::createElement('text', 'lastname', 'Name');
$id['lastname']->setSize(30);
$id['code'] = &HTML_QuickForm::createElement('text', 'code', 'Code');
$id['code']->setSize(5);
$id['code']->setMaxLength(4);
$form->addElementGroup($id, 'ID:', 'id', ',&nbsp');

$idGrp =& $form->getElement('id');
$idGrp->setGroupTemplate('<table><tr>{content}</tr></table>');
$idGrp->setElementTemplate('<td>{element}<br /><font size="-2"><!-- BEGIN required --><font color="red">*</font><!-- END required -->{label}</font></td>');

// Creates a group of text inputs
$areaCode = &HTML_QuickForm::createElement('text', '');
$areaCode->setSize(4);
$areaCode->setMaxLength(3);
$phoneNo1 = &HTML_QuickForm::createElement('text', '');
$phoneNo1->setSize(4);
$phoneNo1->setMaxLength(3);
$phoneNo2 = &HTML_QuickForm::createElement('text', '');
$phoneNo2->setSize(5);
$phoneNo2->setMaxLength(4);
$form->addElementGroup(array($areaCode, $phoneNo1, $phoneNo2), 'Telephone:', 'phoneNo', '-');

// Creates a standard radio buttons group
$radio[] = &HTML_QuickForm::createElement('radio', null, null, 'Yes', 'Y');
$radio[] = &HTML_QuickForm::createElement('radio', null, null, 'No', 'N');
$form->addElementGroup($radio, 'Yes/No:', 'iradYesNo');

// Creates a checkboxes group using an array of separators
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'A', null, 'A');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'B', null, 'B');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'C', null, 'C');
$checkbox[] = &HTML_QuickForm::createElement('checkbox', 'D', null, 'D');
$form->addElementGroup($checkbox, 'ABCD:', 'ichkABC', array('&nbsp;', '<br />'));

// Creates a group of buttons to be displayed at the bottom of the form
$buttons[] = &HTML_QuickForm::createElement('submit', null, 'Submit');
$buttons[] = &HTML_QuickForm::createElement('reset', null, 'Reset');
$form->addElementGroup($buttons);

// Adds validation rules for groups
$form->addGroupRule('phoneNo', 'Please fill all phone fields', 'required');
$form->addGroupRule('phoneNo', 'Values must be numeric', 'numeric');

// At least one element is required
$form->addGroupRule('ichkABC', 'Please check at least one box', 'required', '', 1);

// More complex validation rules for groups
$IDRules['lastname'][0] = array('Name is letters only', 'lettersonly');
$IDRules['lastname'][1] = array('Name is required', 'required');
$IDRules['code'][0] = array('Code must be numeric', 'numeric');
$form->addGroupRule('id', $IDRules);

// Tries to validate the form
if ($form->validate()) {
    // Form is validated, then processes the data
    $form->freeze();
    $form->process();
    echo "\n<HR>\n";
}
$form->display();
/*echo '<pre>';
print_r($form->toArray());
echo '</pre>';
*/
?>