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
    // Add fields
    $GLOBALS['TL_DCA']['tl_module']['fields']['addVirtualTour'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_module']['addVirtualTour'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12'),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    $GLOBALS['TL_DCA']['tl_module']['fields']['realEstateVirtualTourTemplate'] = array(
        'label'                   => &$GLOBALS['TL_LANG']['tl_module']['realEstateVirtualTourTemplate'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => function (){
            return Contao\Controller::getTemplateGroup('real_estate_itemext_virtual_tour_');
        },
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    );

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'][] = 'virtualTour';

    // Extend the default palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addField(array('addVirtualTour'), 'item_extension_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('realEstateVirtualTourTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('realEstateList', 'tl_module')
        ->applyToPalette('realEstateResultList', 'tl_module')
    ;
}
