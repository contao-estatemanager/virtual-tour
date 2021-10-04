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

use Contao\Config;
use Contao\Environment;
use ContaoEstateManager\EstateManager;

class AddonManager
{
    /**
     * Bundle name.
     *
     * @var string
     */
    public static $bundle = 'EstateManagerVirtualTour';

    /**
     * Package.
     *
     * @var string
     */
    public static $package = 'contao-estatemanager/virtual-tour';

    /**
     * Addon config key.
     *
     * @var string
     */
    public static $key = 'addon_virtual_tour_license';

    /**
     * Is initialized.
     *
     * @var bool
     */
    public static $initialized = false;

    /**
     * Is valid.
     *
     * @var bool
     */
    public static $valid = false;

    /**
     * Licenses.
     *
     * @var array
     */
    private static $licenses = [
        '552bea35f6d57989f833dcc7e3666472',
        '1a933ba050b929c5699599c47133b5a5',
        'a3bc97e67ab62107a2900f9e3d1ae0e5',
        '13bbd62e705cd400873c1030375c3021',
        '36cb4e1f49907a3fbb1fa13d88522b74',
        '2938d9fd25385a16cde434b36413e78d',
        'ce42991c99e4fcc66c0ca7a5e4f70950',
        '1e3f5098ec6482a183d59864bd3e8bfe',
        'd00b6a6329634296a3da13c85e7bc8f9',
        '6ea383b297ec9e9b341f5f621aaf890c',
        'b3bbcd51805b05f1621c55d8ebba3496',
        '2dac075b0696171823f867ff4b4016f3',
        '47b33bd5ec3da4369ec051dee64aeed9',
        'f6945e8a819e82dc3abeea43e494802c',
        'bba423674b215aacaaf8f66425af0c41',
        'd005a8eb2d64aa9a46d6404204f6d61e',
        'f848e37f68007159821a46e6b9c8f7b5',
        '6002d8d98cc4803962679878c127739a',
        '42043b140697b479bda637ddd2371384',
        'cd796393f913cc74651345a9c8c1d47b',
        '280d51e33895b5bdf59d8dc8c5c4ce99',
        '38e11372b4110c4ae6f8b9743e4d6dcf',
        'c7b6aa59b6780945ce877657d71ceb78',
        'd420ea35760f2fa1fb48e0d6dbb8869a',
        '5a42865689f9bbfe664b3c574e0d552b',
        '30daa218a0258bdc37759f74c105bf79',
        '0ba0f09b979169d4af6945b558a083ef',
        '6e702c1e8a213065622d9ef70b609023',
        '190e7f890b7389a8647ec5801e6eefaa',
        'e02f07a5b0a569c1ba1817f2875478b2',
        'dc9a864c85d5e570def5fb5773a4674c',
        'f263ae33e64a1ec3d9ddc064d6e1e5d8',
        'f154a580da41e5d917098236eabf5ccd',
        'd5184924d592a6272a114459820e9714',
        '30b978469151cf734e8f9fe7e81bd4c7',
        '5e8c7fb2deeef8c201b66f13221247e1',
        'c43c6bcea17a5f9591bbdfd888bd7c77',
        '40c58c45b124be6b044f6d4636761353',
        'fcd996a123d2f78d786f7022b3af58e8',
        '35923a821fbaaf3732d6c875de061a11',
        'faebb3dadb5e05ad619ddbbba3fca326',
        'a5e89e4779cb8d64e45dd37d2d718a6e',
        'ec0e2cd368d69686196b22aa69c4aeb7',
        '59e9fcf9a38fa0debbd9729134ccf5f8',
        '536e25d84da9e93c6be5b275c750db33',
        'e2ec1933fbbecc28213b053c74566d2d',
        '4632cab919e641e746398e888854e574',
        '16e7b337f4bddbc4dd6450a021c6c5d5',
        '8a0ee6ec2b4bf5d2ee360337c097b284',
        'ef57f5f62abc5b61c97d0f279e4e6671',
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }

    public static function valid()
    {
        if (false !== strpos(Environment::get('requestUri'), '/contao/install'))
        {
            return true;
        }

        if (false === static::$initialized)
        {
            static::$valid = EstateManager::checkLicenses(Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }
}
