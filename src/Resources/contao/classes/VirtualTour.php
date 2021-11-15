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

namespace ContaoEstateManager\VirtualTour;

use Contao\FilesModel;
use Contao\FrontendTemplate;
use Contao\StringUtil;
use ContaoEstateManager\Translator;

class VirtualTour
{
    /**
     * Expands the functions within a template which can be accessed via $this->realEstate.
     */
    public function extendModulePreparation($callbackName, $objModule)
    {
        switch ($callbackName)
        {
            case 'hasVirtualTour':
            case 'getVirtualTourLink':
            case 'getVirtualTourLinks':
                $arrLinks = static::collectVirtualTourLinks($objModule);
                $blnExists = null !== $arrLinks;

                switch ($callbackName)
                {
                    case 'hasVirtualTour':
                        return $blnExists;

                    case 'getVirtualTourLink':
                        return $arrLinks[0] ?? null;

                    default:
                        return $arrLinks;
                }
        }

        return null;
    }

    /**
     * Parse real estate template and add video extension.
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function parseRealEstate(&$objTemplate, $realEstate, $context): void
    {
        if ((bool) $context->addVirtualTour)
        {
            $arrLinks = static::collectVirtualTourLinks($realEstate, 1);

            if (null === $arrLinks)
            {
                return;
            }

            // create Template
            $objVirtualTourTemplate = new FrontendTemplate($context->realEstateVirtualTourTemplate);

            // In current version is only one value supported
            $link = $arrLinks[0];

            // set template information
            $objVirtualTourTemplate->link = $link;
            $objVirtualTourTemplate->label = Translator::translateLabel('button_virtual_tour');

            $objTemplate->arrExtensions = array_merge($objTemplate->arrExtensions, [$objVirtualTourTemplate->parse()]);
        }
    }

    /**
     * Parse virtual tour gallery template and add them to slides.
     *
     * @param $objTemplate
     * @param $module
     * @param $arrSlides
     * @param $realEstate
     * @param $context
     */
    public function parseGallerySlide($objTemplate, $module, &$arrSlides, $realEstate, $context): void
    {
        if ('virtualTour' === $module)
        {
            $arrLinks = static::collectVirtualTourLinks($realEstate);

            if (null === $arrLinks)
            {
                return;
            }

            foreach ($arrLinks as $link)
            {
                // create Template
                $objVirtualTourGalleryTemplate = new FrontendTemplate($context->virtualTourGalleryTemplate);

                // set template information
                $objVirtualTourGalleryTemplate->link = $link;
                $objVirtualTourGalleryTemplate->class = 'virtual_tour';
                $objVirtualTourGalleryTemplate->label = Translator::translateLabel('button_virtual_tour');
                $objVirtualTourGalleryTemplate->addImage = false;
                $objVirtualTourGalleryTemplate->playerWidth = 100;
                $objVirtualTourGalleryTemplate->playerHeight = 100;

                // get player size by image size
                $customImageSize = false;

                if ('' !== $context->imgSize)
                {
                    $size = StringUtil::deserialize($context->imgSize);

                    if ($size[0] > 0 || $size[1] > 0 || is_numeric($size[2]))
                    {
                        $customImageSize = true;
                        $objVirtualTourGalleryTemplate->playerWidth = $size[0];
                        $objVirtualTourGalleryTemplate->playerHeight = $size[1];
                    }
                }

                // add preview image
                if ((bool) $context->addVirtualTourPreviewImage)
                {
                    if ($context->virtualTourPreviewImage)
                    {
                        // add own preview image
                        $fileId = $context->virtualTourPreviewImage;
                    }
                    else
                    {
                        // add main image from real estate
                        $fileId = $realEstate->getMainImage();
                    }

                    if ($fileId)
                    {
                        $objModel = FilesModel::findByUuid($fileId);

                        // Add an image
                        if (null !== $objModel && is_file(TL_ROOT.'/'.$objModel->path))
                        {
                            $arrImage = [];

                            // Override the default image size
                            if ($customImageSize)
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
    }

    /**
     * Add status token for virtual tour objects.
     *
     * @param $validStatusToken
     * @param $arrStatusTokens
     * @param $context
     */
    public function addStatusToken($validStatusToken, &$arrStatusTokens, $context): void
    {
        $arrLinks = static::collectVirtualTourLinks($context, 1);

        if (null !== $arrLinks && \in_array('virtualTour', $validStatusToken, true))
        {
            $arrStatusTokens[] = [
                'value' => Translator::translateValue('virtualTourObject'),
                'class' => 'virtualTour',
            ];
        }
    }

    /**
     * Return virtual tour links as array.
     *
     * Supported vendors:
     * - 3d. Sub-Domains
     * - 360. Sub-Domains
     * - 360grad. Sub-Domains
     * - Ogulo
     * - Immoviewer
     * - Matterport
     *
     * @param $realEstate
     * @param null $max
     *
     * @return array
     */
    public static function collectVirtualTourLinks($realEstate, $max = null): ?array
    {
        $arrLinks = null;

        $index = 1;

        $links = $realEstate->links;

        if ($links)
        {
            foreach ($links as $link)
            {
                if (1 === preg_match('/ogulo|3d\.|360\.|360grad\.|app\.immoviewer|my\.matterport/', $link))
                {
                    $arrLinks[] = $link;

                    if (null !== $max && $max === $index++)
                    {
                        break;
                    }
                }
            }
        }

        if ($realEstate->tour3d && null !== $max && $max <= $index)
        {
            $arrLinks[] = $realEstate->tour3d;
        }

        return $arrLinks;
    }
}
