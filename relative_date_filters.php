<?php

require_once 'relative_date_filters.civix.php';
use CRM_RelativeDateFilters_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function relative_date_filters_civicrm_config(&$config) {
  _relative_date_filters_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function relative_date_filters_civicrm_xmlMenu(&$files) {
  _relative_date_filters_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function relative_date_filters_civicrm_install() {
  _relative_date_filters_civix_civicrm_install();

  $installer=_relative_date_filters_civix_upgrader();
  $installer->installExtension();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function relative_date_filters_civicrm_postInstall() {
  _relative_date_filters_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function relative_date_filters_civicrm_uninstall() {
  _relative_date_filters_civix_civicrm_uninstall();

  $installer=_relative_date_filters_civix_upgrader();
  $installer->uninstallExtension();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function relative_date_filters_civicrm_enable() {
  _relative_date_filters_civix_civicrm_enable();

  $installer=_relative_date_filters_civix_upgrader();
  $installer->updateCore();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function relative_date_filters_civicrm_disable() {
  _relative_date_filters_civix_civicrm_disable();

  $installer=_relative_date_filters_civix_upgrader();
  $installer->revertBackup();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function relative_date_filters_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _relative_date_filters_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function relative_date_filters_civicrm_managed(&$entities) {
  _relative_date_filters_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function relative_date_filters_civicrm_caseTypes(&$caseTypes) {
  _relative_date_filters_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function relative_date_filters_civicrm_angularModules(&$angularModules) {
  _relative_date_filters_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function relative_date_filters_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _relative_date_filters_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function relative_date_filters_civicrm_entityTypes(&$entityTypes) {
  _relative_date_filters_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function relative_date_filters_civicrm_themes(&$themes) {
  _relative_date_filters_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function relative_date_filters_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function relative_date_filters_civicrm_navigationMenu(&$menu) {
  _relative_date_filters_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _relative_date_filters_civix_navigationMenu($menu);
} // */
