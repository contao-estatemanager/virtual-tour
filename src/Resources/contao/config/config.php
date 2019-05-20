<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// IMMOMANAGER
$GLOBALS['TL_IMMOMANAGER_ADDONS'][] = array('Oveleon\\ContaoImmoManagerVirtualTourBundle', 'AddonManager');

if(Oveleon\ContaoImmoManagerVirtualTourBundle\AddonManager::valid()) {
    // Add expose module
    array_insert($GLOBALS['FE_EXPOSE_MOD']['media'], -1, array
    (
        'virtualTour' => '\\Oveleon\\ContaoImmoManagerVirtualTourBundle\\ExposeModuleVirtualTour',
    ));

    // HOOKS
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('Oveleon\\ContaoImmoManagerVirtualTourBundle\\VirtualTour', 'parseRealEstate');
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('Oveleon\\ContaoImmoManagerVirtualTourBundle\\VirtualTour', 'addStatusToken');
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = array('Oveleon\\ContaoImmoManagerVirtualTourBundle\\VirtualTour', 'parseGallerySlide');
    $GLOBALS['TL_HOOKS']['compileExposeStatusToken'][] = array('Oveleon\\ContaoImmoManagerVirtualTourBundle\\VirtualTour', 'addStatusToken');
}