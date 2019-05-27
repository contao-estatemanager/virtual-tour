<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/virtual-tour
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\\VirtualTour', 'AddonManager');

if(ContaoEstateManager\VirtualTour\AddonManager::valid()) {
    // Add expose module
    array_insert($GLOBALS['FE_EXPOSE_MOD']['media'], -1, array
    (
        'virtualTour' => '\\ContaoEstateManager\\VirtualTour\\ExposeModuleVirtualTour',
    ));

    // HOOKS
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('ContaoEstateManager\\VirtualTour\\VirtualTour', 'parseRealEstate');
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('ContaoEstateManager\\VirtualTour\\VirtualTour', 'addStatusToken');
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = array('ContaoEstateManager\\VirtualTour\\VirtualTour', 'parseGallerySlide');
    $GLOBALS['TL_HOOKS']['compileExposeStatusToken'][] = array('ContaoEstateManager\\VirtualTour\\VirtualTour', 'addStatusToken');
}