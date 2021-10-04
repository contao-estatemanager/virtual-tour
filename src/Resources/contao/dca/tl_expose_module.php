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
    // Add a new selector field
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['__selector__'][] = 'addVirtualTourPreviewImage';

    // Add palette
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['virtualTour'] = '{title_legend},name,headline,type;{settings_legend},text,hideOnEmpty;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

    // Add field to subpalettes
    $GLOBALS['TL_DCA']['tl_expose_module']['subpalettes']['addVirtualTourPreviewImage'] = 'virtualTourPreviewImage';

    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['addVirtualTourPreviewImage'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['addVirtualTourPreviewImage'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12', 'submitOnChange' => true],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['virtualTourPreviewImage'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourPreviewImage'],
        'exclude' => true,
        'inputType' => 'fileTree',
        'eval' => ['fieldType' => 'radio', 'filesOnly' => true, 'tl_class' => 'clr'],
        'sql' => 'binary(16) NULL',
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['virtualTourGalleryTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourGalleryTemplate'],
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('expose_mod_virtual_tour_gallery_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'][] = 'virtualTour';

    // Extend estate manager expose module gallery options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['galleryModules']['options'][] = 'virtualTour';

    // Extend the gallery palettes
    PaletteManipulator::create()
        ->addLegend('virtual_tour_legend', 'image_legend', PaletteManipulator::POSITION_BEFORE)
        ->addField(['addVirtualTourPreviewImage'], 'virtual_tour_legend', PaletteManipulator::POSITION_APPEND)
        ->addField(['virtualTourGalleryTemplate'], 'template_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('gallery', 'tl_expose_module')
    ;
}
