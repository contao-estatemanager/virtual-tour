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

use ContaoEstateManager\Translator;

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
    public function parseGallerySlide($objTemplate, $module, &$arrSlides, $realEstate, $context)
    {
        if ($module === 'virtualTour')
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
            $objVirtualTourGalleryTemplate->class = 'virtual_tour';
            $objVirtualTourGalleryTemplate->label = Translator::translateLabel('button_virtual_tour');
            $objVirtualTourGalleryTemplate->addImage = false;
            $objVirtualTourGalleryTemplate->playerWidth = 100;
            $objVirtualTourGalleryTemplate->playerHeight = 100;

            // get player size by image size
            $customImageSize = false;

            if ($context->imgSize != '')
            {
                $size = \StringUtil::deserialize($context->imgSize);

                if ($size[0] > 0 || $size[1] > 0 || is_numeric($size[2]))
                {
                    $customImageSize = true;
                    $objVirtualTourGalleryTemplate->playerWidth = $size[0];
                    $objVirtualTourGalleryTemplate->playerHeight = $size[1];
                }
            }

            // add preview image
            if(!!$context->addVirtualTourPreviewImage)
            {
                if($context->virtualTourPreviewImage)
                {
                    // add own preview image
                    $fileId = $context->virtualTourPreviewImage;
                }
                else
                {
                    // add main image from real estate
                    $fileId = $realEstate->getMainImage();
                }

                if($fileId)
                {
                    $objModel = \FilesModel::findByUuid($fileId);

                    // Add an image
                    if ($objModel !== null && is_file(TL_ROOT . '/' . $objModel->path))
                    {
                        $arrImage = array();

                        // Override the default image size
                        if($customImageSize)
                        {
                            $arrImage['size'] = $context->imgSize;
                        }

                        $arrImage['singleSRC'] = $objModel->path;
                        $context->addImageToTemplate($objVirtualTourGalleryTemplate, $arrImage, null, null, $objModel);

                        $objVirtualTourGalleryTemplate->addImage = true;
                    }
                }
            }

            // add slide
            $arrSlides[] = $objVirtualTourGalleryTemplate->parse();
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