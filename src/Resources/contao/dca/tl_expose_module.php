<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/virtual-tour
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */
if(ContaoEstateManager\VirtualTour\AddonManager::valid()){
    // Add a new selector field
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['__selector__'][] = 'addVirtualTourPreviewImage';

    // Add palette
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['virtualTour'] = '{title_legend},name,headline,type;{settings_legend},text,hideOnEmpty;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

    // Add field to subpalettes
    $GLOBALS['TL_DCA']['tl_expose_module']['subpalettes']['addVirtualTourPreviewImage'] = 'virtualTourPreviewImage';

    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['addVirtualTourPreviewImage'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['addVirtualTourPreviewImage'],
        'exclude'                   => true,
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['virtualTourPreviewImage'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourPreviewImage'],
        'exclude'                   => true,
        'inputType'                 => 'fileTree',
        'eval'                      => array('fieldType'=>'radio', 'filesOnly'=>true, 'tl_class'=>'clr'),
        'sql'                       => "binary(16) NULL"
    );

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['virtualTourGalleryTemplate'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourGalleryTemplate'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => function (){
            return Contao\Controller::getTemplateGroup('expose_mod_virtual_tour_gallery_');
        },
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    );

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'][] = 'virtualTour';

    // Extend estate manager expose module gallery options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['galleryModules']['options'][] = 'virtualTour';

    // Extend the gallery palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('virtual_tour_legend', 'image_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
        ->addField(array('addVirtualTourPreviewImage'), 'virtual_tour_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('virtualTourGalleryTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('gallery', 'tl_expose_module')
    ;
}
