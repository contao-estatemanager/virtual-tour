<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Add a new selector field
$GLOBALS['TL_DCA']['tl_expose_module']['palettes']['__selector__'][] = 'addVirtualTour';

// Add field to subpalettes
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['subpalettes'], 0, array
(
    'addVirtualTour' => 'virtualTourPosition'
));

// Add field
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['palettes'], -1, array
(
    'virtualTour'  => '{title_legend},name,headline,type;{settings_legend},text,hideOnEmpty;{template_legend:hide},customTpl,virtualTourTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID'
));

// Add fields
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['fields'], -1, array(
    'addVirtualTour'  => array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_expose_module']['addVirtualTour'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12', 'submitOnChange'=>true),
        'sql'                       => "char(1) NOT NULL default '0'",
    ),
    'virtualTourPosition' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourPosition'],
        'exclude'                 => true,
        'inputType'               => 'select',
        'options'                 => array('first_pos', 'second_pos', 'last_pos'),
        'eval'                    => array('tl_class'=>'w50'),
        'reference'               => &$GLOBALS['TL_LANG']['FMD'],
        'sql'                     => "varchar(16) NOT NULL default ''"
    ),
    'virtualTourTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourTemplate'],
        'default'                 => 'expose_mod_virtual_tour',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_expose_module_immo_manager_virtual_tour', 'getVirtualTourTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
    'virtualTourGalleryTemplate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_expose_module']['virtualTourGalleryTemplate'],
        'default'                 => 'expose_mod_virtual_tour_gallery_default',
        'exclude'                 => true,
        'inputType'               => 'select',
        'options_callback'        => array('tl_expose_module_immo_manager_virtual_tour', 'getVirtualTourGalleryTemplates'),
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(64) NOT NULL default ''"
    ),
));

// Extend immo manager statusTokens field options
array_insert($GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'], -1, array(
    'virtualTour'
));

// Extend the gallery palettes
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('virtual_tour_legend', 'image_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE)
    ->addField(array('addVirtualTour'), 'virtual_tour_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->addField(array('virtualTourGalleryTemplate'), 'template_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('gallery', 'tl_expose_module')
;

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_expose_module_immo_manager_virtual_tour extends \Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Return all virtual tour templates as array
     *
     * @return array
     */
    public function getVirtualTourTemplates()
    {
        return $this->getTemplateGroup('expose_mod_virtual_tour_');
    }

    /**
     * Return all virtual tour templates as array
     *
     * @return array
     */
    public function getVirtualTourGalleryTemplates()
    {
        return $this->getTemplateGroup('expose_mod_virtual_tour_gallery_');
    }
}