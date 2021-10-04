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

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\VirtualTour\AddonManager;

if (AddonManager::valid())
{
    // Add field
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['tour3d'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_real_estate']['tour3d'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql' => "varchar(255) NOT NULL default ''",
    ];

    // Extend the default palettes
    PaletteManipulator::create()
        ->addField(['tour3d'], 'real_estate_media_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_real_estate')
    ;
}
