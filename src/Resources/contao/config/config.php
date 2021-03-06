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
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\VirtualTour', 'AddonManager');

if(ContaoEstateManager\VirtualTour\AddonManager::valid()) {
    // Add expose module
    $GLOBALS['FE_EXPOSE_MOD']['media']['virtualTour'] = 'ContaoEstateManager\VirtualTour\ExposeModuleVirtualTour';

    // Hooks
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('ContaoEstateManager\VirtualTour\VirtualTour', 'parseRealEstate');
    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = array('ContaoEstateManager\VirtualTour\VirtualTour', 'addStatusToken');
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = array('ContaoEstateManager\VirtualTour\VirtualTour', 'parseGallerySlide');
}
