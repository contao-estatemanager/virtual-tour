<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/virtual-tour
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = ['ContaoEstateManager\VirtualTour', 'AddonManager'];

use ContaoEstateManager\VirtualTour\AddonManager;

if (AddonManager::valid())
{
    // Add expose module
    $GLOBALS['FE_EXPOSE_MOD']['media']['virtualTour'] = 'ContaoEstateManager\VirtualTour\ExposeModuleVirtualTour';

    // Hooks
    $GLOBALS['TL_HOOKS']['parseRealEstate'][] = ['ContaoEstateManager\VirtualTour\VirtualTour', 'parseRealEstate'];
    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = ['ContaoEstateManager\VirtualTour\VirtualTour', 'addStatusToken'];
    $GLOBALS['TL_HOOKS']['parseSlideExposeGallery'][] = ['ContaoEstateManager\VirtualTour\VirtualTour', 'parseGallerySlide'];

    $GLOBALS['TL_HOOKS']['cemModulePreparation'][] = ['ContaoEstateManager\VirtualTour\VirtualTour', 'extendModulePreparation'];
}
