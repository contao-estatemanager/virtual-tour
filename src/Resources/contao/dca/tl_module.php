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

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\VirtualTour\AddonManager;

if (AddonManager::valid())
{
    // Add fields
    $GLOBALS['TL_DCA']['tl_module']['fields']['addVirtualTour'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['addVirtualTour'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['realEstateVirtualTourTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['realEstateVirtualTourTemplate'],
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('real_estate_itemext_virtual_tour_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'][] = 'virtualTour';

    // Extend the default palettes
    PaletteManipulator::create()
        ->addField(['addVirtualTour'], 'item_extension_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['realEstateVirtualTourTemplate'], 'template_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('realEstateList', 'tl_module')
        ->applyToPalette('realEstateResultList', 'tl_module')
    ;
}
