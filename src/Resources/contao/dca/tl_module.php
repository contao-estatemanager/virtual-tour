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
    // Add field
    array_insert($GLOBALS['TL_DCA']['tl_module']['fields'], -1, array(
        'addVirtualTour'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_module']['addVirtualTour'],
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        ),
        'realEstateVirtualTourTemplate' => array(
            'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateVirtualTourTemplate'],
            'default'                 => 'real_estate_itemext_virtual_tour_default',
            'exclude'                 => true,
            'inputType'               => 'select',
            'options_callback'        => array('tl_module_estate_manager', 'getRealEstateExtensionTemplates'),
            'eval'                    => array('tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        )
    ));

    // Extend estate manager statusTokens field options
    array_insert($GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'], -1, array(
        'virtualTour'
    ));

    // Extend the default palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addField(array('addVirtualTour'), 'item_extension_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('realEstateVirtualTourTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('realEstateList', 'tl_module')
        ->applyToPalette('realEstateResultList', 'tl_module')
    ;
}