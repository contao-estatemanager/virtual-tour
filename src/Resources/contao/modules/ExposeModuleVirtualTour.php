<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/virtual-tour
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\VirtualTour;

use ContaoEstateManager\ExposeModule;
use ContaoEstateManager\Translator;

/**
 * Expose module "virtual tour".
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class ExposeModuleVirtualTour extends ExposeModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'expose_mod_virtualTour';

    /**
     * Do not display the module if there are no real etates
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['virtual_tour'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=expose_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $strBuffer = parent::generate();
        return $this->isEmpty && !!$this->hideOnEmpty ? '' : $strBuffer;
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $arrLinks = VirtualTour::collectVirtualTourLinks($this->realEstate, 1);

        if(!count($arrLinks))
        {
            $this->isEmpty = true;
        }

        // In current version is only one value supported
        $link = $arrLinks[0];

        // set template information
        $this->Template->link = $link;
        $this->Template->label = Translator::translateExpose('button_virtual_tour');
    }
}
