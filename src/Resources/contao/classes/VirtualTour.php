<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 * @author    Daniele Sciannimanica <daniele@oveleon.de>
 */

namespace Oveleon\ContaoImmoManagerVirtualTourBundle;

use Oveleon\ContaoImmoManagerBundle\Translator;

class VirtualTour
{
    /**
     * Parse real estate template and add video extension
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function parseRealEstate(&$objTemplate, $realEstate, $context)
    {
        if (!!$context->addVirtualTour)
        {
            $arrLinks = static::collectVirtualTourLinks($realEstate->links, 1);

            if(!count($arrLinks))
            {
                return;
            }

            // create Template
            $objVirtualTourTemplate = new \FrontendTemplate($context->realEstateVirtualTourTemplate);

            // In current version is only one value supported
            $link = $arrLinks[0];

            // set template information
            $objVirtualTourTemplate->link = $link;
            $objVirtualTourTemplate->label = Translator::translateLabel('button_virtual_tour');

            $objTemplate->arrExtensions = array_merge($objTemplate->arrExtensions, [$objVirtualTourTemplate->parse()]);
        }
    }

    /**
     * Parse virtual tour gallery template and add them to slides
     *
     * @param $objTemplate
     * @param $arrSlides
     * @param $realEstate
     * @param $context
     */
    public function parseGallerySlides($objTemplate, &$arrSlides, $realEstate, $context)
    {
        if (!!$context->addVirtualTour)
        {
            $arrLinks = static::collectVirtualTourLinks($realEstate->links, 1);

            if(!count($arrLinks))
            {
                return;
            }

            // create Template
            $objVirtualTourGalleryTemplate = new \FrontendTemplate($context->virtualTourGalleryTemplate);

            // In current version is only one value supported
            $link = $arrLinks[0];

            // set template information
            $objVirtualTourGalleryTemplate->link = $link;
            $objVirtualTourGalleryTemplate->label = Translator::translateLabel('button_virtual_tour');

            $index = 0;

            switch($context->virtualTourPosition)
            {
                case 'second_pos':
                    $index = 1;
                    break;

                case 'last_pos':
                    $index = count($arrSlides);
                    break;
            }

            \array_insert($arrSlides, $index, array(
                $objVirtualTourGalleryTemplate->parse()
            ));
        }
    }

    /**
     * Add status token for virtual tour objects
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function addStatusToken(&$objTemplate, $realEstate, $context)
    {
        $tokens = \StringUtil::deserialize($context->statusTokens);

        if(!$tokens){
            return;
        }

        $arrLinks = static::collectVirtualTourLinks($realEstate->links, 1);

        if (in_array('virtualTour', $tokens) && count($arrLinks))
        {
            $objTemplate->arrStatusTokens = array_merge(
                $objTemplate->arrStatusTokens,
                array
                (
                    array(
                        'value' => Translator::translateValue('virtualTourObject'),
                        'class' => 'virtualTour'
                    )
                )
            );
        }
    }

    /**
     * Return virtual tour links as array
     *
     * Supported vendors:
     * - 3d. Sub-Domains
     * - Ogulo
     *
     * @param $links
     * @param null $max
     *
     * @return array
     */
    public static function collectVirtualTourLinks($links, $max=null)
    {
        $arrLinks = array();

        $index = 1;

        if(!$links)
        {
            return $arrLinks;
        }

        foreach ($links as $link)
        {
            if(preg_match('/ogulo|3d\./', $link) === 1)
            {
                $arrLinks[] = $link;

                if ($max !== null && $max === $index++){
                    break;
                }
            }
        }

        return $arrLinks;
    }
}