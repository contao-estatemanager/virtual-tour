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
use ContaoEstateManager\VirtualTour\VirtualTour;

if (AddonManager::valid())
{
    // Add expose module
    $GLOBALS['CEM_FE_EXPOSE_MOD']['media']['virtualTour'] = 'ContaoEstateManager\VirtualTour\ExposeModuleVirtualTour';

    // Hooks
    $GLOBALS['CEM_HOOKS']['parseRealEstate'][] = [VirtualTour::class, 'parseRealEstate'];
    $GLOBALS['CEM_HOOKS']['getStatusTokens'][] = [VirtualTour::class, 'addStatusToken'];
    $GLOBALS['CEM_HOOKS']['parseSlideExposeGallery'][] = [VirtualTour::class, 'parseGallerySlide'];
    $GLOBALS['CEM_HOOKS']['extendTemplateModule'][] = [VirtualTour::class, 'extendModulePreparation'];
}
