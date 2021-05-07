<?php
/**
 * NOTICE OF LICENSE
 *
 * @author    acoalex, UAB acoalex.com <webmaster@acoalex.com>
 * @copyright Copyright (c) permanent, acoalex, UAB
 * @license   MIT
 * @see       /LICENSE
 *
 *  International Registered Trademark & Property of acoalex, UAB
 */

/**
 * Class AdminSkeletonInfoController - used for information display for module
 */
class AdminSkeletonInfoController extends \acoalex\Skeleton\Controller\AdminController
{
    private $templateFile;
    public $name;

    public function initContent()
    {
        $form = $this->renderForm();
        $this->templateFile = $this->module->template_dir . 'config.tpl';

        $this->context->smarty->assign('form_tpl', $form);
        $this->setTemplate($this->templateFile);
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->trans('Settings', array(), 'Admin.Global'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'lang' => true,
                        'label' => $this->trans('Chat title', array(), 'Modules.Skeleton.Admin'),
                        'name' => $this->module->name . '_title',
                        'desc' => $this->trans('Introduzca el titulo del widget del chat.', array(), 'Modules.Skeleton.Admin'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->trans('Avatar image', array(), 'Modules.Skeleton.Admin'),
                        'name' => $this->module->name . '_avatar',
                        'desc' => $this->trans('Upload an image for your avatar bot. The recommended dimensions are 64 x 64.', array(), 'Modules.Skeleton.Admin'),
                        'lang' => false,
                    ),
                ),
                'submit' => array(
                    'title' => $this->trans('Save', array(), 'Admin.Actions'),
                ),
            ),
        );

        $lang = new Language((int) Configuration::get('PS_LANG_DEFAULT'));

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->default_form_language = $lang->id;
        $helper->module = $this;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitStoreConf';
        //$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false) . '&configure=' . $this->module->name . '&tab_module=' . $this->module->tab . '&module_name=' . $this->module->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'uri' => $this->module->getPathUri(),
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        $languages = Language::getLanguages(false);
        $fields = array();

        foreach ($languages as $lang) {
            $fields[$this->module->name . '_title'][$lang['id_lang']] = Tools::getValue($this->module->name . '_title_' . $lang['id_lang'], Configuration::get($this->module->name . '_title', $lang['id_lang']));
        }

        $fields[$this->module->name . '_avatar'] = Tools::getValue($this->module->name . '_avatar', Configuration::get($this->module->name . '_avatar'));

        return $fields;
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitStoreConf')) {
            $languages = Language::getLanguages(false);
            $values = array();

            foreach ($this->module::CONFIG_VARS_KEYS as $key) {
                if ($key == 'avatar') {
                    continue;
                }
                foreach ($languages as $lang) {
                    $values[$this->module->name . '_' . $key][$lang['id_lang']] = Tools::getValue($this->module->name . '_' . $key . '_' . $lang['id_lang']);
                }
            }

            foreach ($this->module::CONFIG_VARS_KEYS as $key) {
                if ($key == 'avatar') {
                    continue;
                }
                Configuration::updateValue($this->module->name . '_' . $key, $values[$this->module->name . '_' . $key]);
            }

            if (isset($_FILES[$this->module->name . '_avatar']['tmp_name'])
                && !empty($_FILES[$this->module->name . '_avatar']['tmp_name'])) {
                if ($error = ImageManager::validateUpload($_FILES[$this->module->name . '_avatar'], 4000000)) {
                    return $error;
                } else {
                    $ext = substr($_FILES[$this->module->name . '_avatar']['name'], strrpos($_FILES[$this->module->name . '_avatar_' . $lang['id_lang']]['name'], '.') + 1);
                    $file_name = md5($_FILES[$this->module->name . '_avatar']['name']) . '.' . $ext;

                    if (!move_uploaded_file($_FILES[$this->module->name . '_avatar']['tmp_name'], dirname(__FILE__) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $file_name)) {
                        return $this->displayError($this->trans('An error occurred while attempting to upload the file.', array(), 'Admin.Notifications.Error'));
                    } else {
                        if (Configuration::hasContext($this->module->name . '_avatar', null, Shop::getContext())
                            && Configuration::get($this->module->name . '_avatar', null) != $file_name) {
                            @unlink(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . Configuration::get($this->module->name . '_avatar', null));
                        }

                        $values[$this->module->name . '_avatar'] = $file_name;
                        Configuration::updateValue($this->module->name . '_avatar', $values[$this->module->name . '_avatar']);
                    }
                }
            }

            parent::postProcess();
        }

        return '';
    }
}
