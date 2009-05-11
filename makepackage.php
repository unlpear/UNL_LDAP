<?php
/**
 * This file generates the package.xml file for the UNL_Services_Peoplefinder package.
 * 
 * PHP version 5
 * 
 * @category  Default 
 * @package   UNL_LDAP
 * @author    Brett Bieber <brett.bieber@gmail.com>
 * @copyright 2009 Regents of the University of Nebraska
 * @license   http://www1.unl.edu/wdn/wiki/Software_License BSD License
 * @link      http://pear.unl.edu/package/UNL_LDAP
 */

/**
 * Include pear package file manager files.
 */
require_once 'PEAR/PackageFileManager2.php';
require_once 'PEAR/PackageFileManager/File.php';
require_once 'PEAR/Config.php';
require_once 'PEAR/Frontend.php';

/**
 * @var PEAR_PackageFileManager
 */
PEAR::setErrorHandling(PEAR_ERROR_DIE);
chdir(dirname(__FILE__));
$pfm = PEAR_PackageFileManager2::importOptions('package.xml', array(
//$pfm = new PEAR_PackageFileManager2();
//$pfm->setOptions(array(
    'packagedirectory' => dirname(__FILE__),
    'baseinstalldir' => '/',
    'filelistgenerator' => 'svn',
    'ignore' => array('package.xml','.project','*.tgz','makepackage.php','config.inc.php','.buildpath'),
    'simpleoutput' => true,
    'exceptions' => array('config.sample.php'=>'data')
));
$pfm->setPackage('UNL_LDAP');
$pfm->setPackageType('php'); // this is a PEAR-style php script package
$pfm->setSummary('LDAP directory services for UNL');
$pfm->setDescription('This package simplifies connecting to UNL\'s LDAP directory for searching for data.');
$pfm->setChannel('pear.unl.edu');
$pfm->setAPIStability('beta');
$pfm->setReleaseStability('beta');
$pfm->setAPIVersion('0.4.0');
$pfm->setReleaseVersion('0.4.0');
$pfm->setNotes('
Feature release:
Add backup LDAP server.
Increase PHP dependency to 5.1.6
');

//$pfm->addMaintainer('lead', 'saltybeagle', 'Brett Bieber', 'brett.bieber@gmail.com');


$pfm->setLicense('BSD', 'http://www1.unl.edu/wdn/wiki/Software_License');
$pfm->clearDeps();
$pfm->setPhpDep('5.1.6');
$pfm->setPearinstallerDep('1.5.4');

$pfm->resetUsesRole();

$pfm->generateContents();
if (isset($_SERVER['argv']) && $_SERVER['argv'][1] == 'make') {
    $pfm->writePackageFile();
} else {
    $pfm->debugPackageFile();
}
