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
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['tour3d'] = array
    (

        'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['tour3d'],
        'inputType'                 => 'text',
        'eval'                      => array('maxlength'=>255, 'tl_class'=>'w50'),
        'sql'                       => "varchar(255) NOT NULL default ''"
    );

    // Extend the default palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addField(array('tour3d'), 'real_estate_media_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_real_estate')
    ;
}
