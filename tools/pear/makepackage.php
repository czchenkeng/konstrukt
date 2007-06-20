<?php
/**
 * package.xml generation script
 *
 * Create a package:
 *
 * <code>
 * $ php makepackage.php make
 * $ pear package package.xml
 * </code>
 *
 * Install a package from an url:
 *
 * <code>
 * $ pear install ./konstrukt-[version].tgz
 * </code>
 *
 * Upgrade a package from an url:
 *
 * <code>
 * $ pear upgrade ./konstrukt-[version].tgz
 * </code>
 *
 * @package konstrukt
 * @author  Lars Olesen <lars@legestue.net>
 */

require_once 'PEAR/PackageFileManager2.php';

$version   = '0.3.0';
$stability = 'beta';
$notes     = '* initial release as a PEAR package.';

PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(
  array(
    'baseinstalldir'    => '/',
    'filelistgenerator' => 'file',
    'packagedirectory'  => dirname(__FILE__) . '/../../',
    'packagefile'       => 'package.xml',
    'ignore'            => array(
      'makepackage.php',
      '*.tgz',
      'tools/'
    ),
    'dir_roles' => array(
      'tests' => 'test',
      'examples' => 'doc',
      'blank_project' => 'doc',
      'docs' => 'doc',
      'lib' => 'php'
    ),
    'exceptions'        => array(
    ),
    'simpleoutput'      => true,
  )
);

$pfm->setPackage('konstrukt');
$pfm->setSummary('A REST-ful framework of controllers for PHP5.');
$pfm->setDescription('
Key Aspects

    * Controllers are resources
    * URI-to-controller-mapping gives your application a logical structure
    * Routing based on logic rather than rules
    * Nested controllers supports composite view rendering
    * Formcontroller provides filtering and validation

Design Goals

    * Embrace HTTP rather than hide it
    * Enable the programmer, rather than automating
    * Favour aggregation over code-generation or config-files
    * Encourage encapsulation, and deter use of global scope
    * Limit focus to the controller layer
');
$pfm->setUri('http://localhost/');
$pfm->setLicense('LGPL License', 'http://www.gnu.org/licenses/lgpl.html');
$pfm->addMaintainer('lead', 'swaxi', 'Troels Knak-Nielsen', 'troels@konstrukt.dk');
$pfm->addMaintainer('helper', 'lsolesen', 'Lars Olesen', 'lsolesen@users.sourceforge.net');

$pfm->setPackageType('php');

$pfm->setAPIVersion($version);
$pfm->setReleaseVersion($version);
$pfm->setAPIStability($stability);
$pfm->setReleaseStability($stability);
$pfm->setNotes($notes);
$pfm->addRelease();

$pfm->clearDeps();
$pfm->setPhpDep('5.1.3');
$pfm->setPearinstallerDep('1.5.0');

$lib_files = array(
  'http/authenticate.php',
  'http/redirect.php',
  'http/request.php',
  'http/response.php',
  'http/session.php',
  'anonymous.php',
  'classloader.php',
  'component.php',
  'controller.php',
  'datalist.php',
  'debugger.php',
  'dispatcher.php',
  'document.php',
  'field.php',
  'fieldcollection.php',
  'formbehaviour.php',
  'icontext.php',
  'memory.php',
  'registry.php',
  'staticadapter.php',
  'validator.php'
);

foreach ($lib_files as $file) {
    $pfm->addInstallAs('lib/k/' . $file, 'k/' . $file);
}

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
  if ($pfm->writePackageFile()) {
    exit('package file written');
  }
} else {
  $pfm->debugPackageFile();
}
?>