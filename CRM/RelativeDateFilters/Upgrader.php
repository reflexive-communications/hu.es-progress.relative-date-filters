<?php

use Civi\Api4\OptionGroup;
use Civi\Api4\OptionValue;

/**
 * Collection of upgrade steps.
 */
class CRM_RelativeDateFilters_Upgrader extends CRM_RelativeDateFilters_Upgrader_Base
{
  /**
   * Get Relative Date Filters option group
   *
   * @return int|null
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function getRelativeDateFiltersOptionGroup(): ?int
  {
    $result = OptionGroup::get()
      ->addSelect('id')
      ->addWhere('name', '=', 'relative_date_filters')
      ->setLimit(1)
      ->execute();

    if ($result->count() > 0) {
      return (int)$result->first()['id'];
    }

    return null;
  }

  /**
   * Get option value id
   *
   * @param int $option_group_id Option group id
   * @param string $name Option name
   *
   * @return int|null
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function getOption(int $option_group_id, string $name): ?int
  {
    $result = OptionValue::get()
      ->addSelect('id')
      ->addWhere('option_group_id', '=', $option_group_id)
      ->addWhere('name', '=', $name)
      ->setLimit(1)
      ->execute();

    if ($result->count() > 0) {
      return (int)$result->first()['id'];
    }

    return null;
  }

  /**
   * Create relative date filter
   *
   * @param int $option_group_id Option group ID
   * @param string $label Filter label
   * @param string $name Filter name
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function createFilter(int $option_group_id, string $label, string $name)
  {
    OptionValue::create()
      ->addValue('option_group_id', $option_group_id)
      ->addValue('label', $label)
      ->addValue('value', $name)
      ->addValue('name', $name)
      ->addValue('is_optgroup', false)
      ->addValue('is_reserved', false)
      ->addValue('is_active', true)
      ->execute();
  }

  /**
   * Delete relative date filter
   *
   * @param int $option_group_id Option group ID
   * @param string $name Filter name
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function deleteFilter(int $option_group_id, string $name)
  {
    OptionValue::delete()
      ->addWhere('option_group_id', '=', $option_group_id)
      ->addWhere('name', '=', $name)
      ->setLimit(1)
      ->execute();
  }

  /**
   * Add filters
   *
   * @param int $option_group_id Option group ID
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function addFilters(int $option_group_id)
  {
    // Last xx days filters
    foreach ([7, 30, 60, 90] as $days) {
      $name = "before_last_${days}.day";

      // If option already exist --> skip
      if ($this->getOption($option_group_id, $name)) {
        continue;
      }

      $this->createFilter($option_group_id, "Before the last ${days} days", $name);
    }

    // Last xx months filters
    foreach ([6, 12] as $months) {
      $name = "before_last_${months}.month";

      // If option already exist --> skip
      if ($this->getOption($option_group_id, $name)) {
        continue;
      }

      $this->createFilter($option_group_id, "Before the last ${months} months", $name);
    }
  }

  /**
   * Remove filters
   *
   * @param int $option_group_id Option group ID
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  protected function removeFilters(int $option_group_id)
  {
    // Last xx days filters
    foreach ([7, 30, 60, 90] as $days) {
      $name = "before_last_${days}.day";

      // If option not exist --> skip
      if (!$this->getOption($option_group_id, $name)) {
        continue;
      }

      $this->deleteFilter($option_group_id, $name);
    }

    // Last xx months filters
    foreach ([6, 12] as $months) {
      $name = "before_last_${months}.month";

      // If option not exist --> skip
      if (!$this->getOption($option_group_id, $name)) {
        continue;
      }

      $this->deleteFilter($option_group_id, $name);
    }
  }

  /**
   * Install
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function installExtension()
  {
    $option_group = $this->getRelativeDateFiltersOptionGroup();

    $this->addFilters($option_group);
  }

  /**
   * Uninstall
   *
   * @throws \API_Exception
   * @throws \Civi\API\Exception\UnauthorizedException
   */
  public function uninstallExtension()
  {
    $option_group = $this->getRelativeDateFiltersOptionGroup();

    $this->removeFilters($option_group);
  }

  /**
   * Copy file contents to destination
   *
   * @param string $from Source file path
   * @param string $to Destination file path
   *
   * @return bool
   */
  protected function copyFile(string $from, string $to)
  {
    // Read original
    if (!is_readable($from)) {
      return false;
    }
    $contents = file_get_contents($from);


    // Check if directory is writeable
    if (!is_writable(dirname($to))) {
      return false;
    }

    // Write original to new
    if (!file_put_contents($to, $contents)) {
      return false;
    }

    return true;
  }

  /**
   * Backup original CRM_Utils_Date class
   *
   * @return bool
   */
  protected function makeBackup()
  {
    $from = Civi::paths()->getPath("[civicrm.root]/CRM/Utils/Date.php");
    $to = CRM_RelativeDateFilters_ExtensionUtil::path('Date.php.bak');

    return $this->copyFile($from, $to);
  }

  /**
   * Copy new CRM_Utils_Date class
   *
   * @return bool
   */
  protected function copyNew()
  {
    $from = CRM_RelativeDateFilters_ExtensionUtil::path('build/CRM/Utils/Date.php');
    $to = Civi::paths()->getPath("[civicrm.root]/CRM/Utils/Date.php");

    return $this->copyFile($from, $to);
  }

  /**
   * Revert to original CRM_Utils_date class
   *
   * @return bool
   */
  protected function revert()
  {
    $from = CRM_RelativeDateFilters_ExtensionUtil::path('Date.php.bak');
    $to = Civi::paths()->getPath("[civicrm.root]/CRM/Utils/Date.php");

    return $this->copyFile($from, $to);
  }

  /**
   * Update Core class with custom
   */
  public function updateCore()
  {
    if (!is_writable(CRM_RelativeDateFilters_ExtensionUtil::path())) {
      CRM_Core_Session::setStatus(
        ts('Extension directory needs to be writable by CiviCRM to be able to create backups of files.'),
        ts('Extension folder not writable'),
        'error'
      );
    } elseif ($this->makeBackup()) {
      $this->copyNew();
    }
  }

  /**
   * Revert custom class to Core
   */
  public function revertBackup()
  {
    $this->revert();
  }
}
