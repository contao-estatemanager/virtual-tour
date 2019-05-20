<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerVirtualTourBundle;

use Oveleon\ContaoImmoManagerBundle\ImmoManager;

class AddonManager
{
    /**
     * Addon name
     * @var string
     */
    public static $name = 'Virtual Tour';

    /**
     * Addon config key
     * @var string
     */
    public static $key  = 'addon_virtual_tour_license';

    /**
     * Is initialized
     * @var boolean
     */
    public static $initialized  = false;

    /**
     * Is valid
     * @var boolean
     */
    public static $valid  = false;

    /**
     * Licenses
     * @var array
     */
    private static $licenses = [
        '996a6c55f82a8e20a6e336e728713295',
        '99699cbd6917185655675fc8082f8d72',
        '15c63680a4868ec889549119798143a4',
        '11fc2194b5e9032883e6c80b272f4f3c',
        '7d0a2cd0a80f6c1347b101483660624e',
        'e9b3beab03483931c1e15e26330671d6',
        '0cbc8dcb8bd9ccc489da24e90ad0d439',
        'd802daae26d1b2faf52b69ccedc1eba2',
        'd40082d76954ccb0a06b075996daf1b7',
        'b82911ae7a5ad784444017b422a5c5bc',
        '0c07dac626a410eaec9aabaf6d589fe4',
        '4257f980b0628e2522ee75b811f8d1f1',
        '288d8ef8c9418c85339712114246a7e8',
        'ec550b801f043e5c0344d819e290b1b0',
        '22311bf426a23153aaa28b7efe881c44',
        'ad0c93686d0d9fd753bd102ffb3d7518',
        '3e6c5a6a1c3e532c5c5c3661ee9b07a7',
        'e8d1414929d40aa90b0f9284f58fe65d',
        '975fc43b43598601c3a10b961a157b0e',
        '54617ad425542d16c6241c86dc1d10bf',
        '59f229db2a8d287b858f1da25265a9d0',
        '56b840cb9ea0e4a22aabe82a665697bb',
        '6c7f15c7eba68d006ba653d344645908',
        '73205cdad694e2425e57ab31671a628d',
        'afb730d598e2ee30e20694b5d9a1d6ee',
        'a62e3a219103758964cf65a45c477ba7',
        'b487faa01f99a881a74919a6fd1e956e',
        '646fd9b60956348ad2d09e7241a23d2f',
        '1c789bf4b04f4735316418bd7cddc77e',
        'dd166302d030a5ab151f510f32ee48d6',
        'a65fe83feb9b4ecab932711897114f10',
        '71b340f4aef73de3e75000de5674dc5d',
        '4fcfbf42606fa1111f16a93d81d070a0',
        '27858d2d0af2eca80c84cb7390415278',
        'bb9fe594d09d91748b880f8563c0d499',
        '2cbfac1cfc522e5c9883cb570649ed89',
        'b5eea816d283c2a2b4b5f6bf1e143219',
        'f4209434ecd925d47ff2b74afc9f94e2',
        '36578cd121314f4bcbe4c5977aa5979f',
        'abdccbc01479e1d0248b57bf30aeba23',
        'cabeb3cdc8be4973d88edf97a6854ed8',
        'b7ae8c2fa84738431c8e6496f5c45bf1',
        '7490579f4cab78c41a40beb00e59872d',
        'aaf516e7fb229bfd4e1b7a2aa92c300d',
        'ffbc9fff2ca62d083d273bae8a837c40',
        '824837532c47aa37fb06628bda082ed9',
        'e0679b5203041f8b0a53b9803870ff5a',
        '3368049613f5a66cf22f1d697b1b73f2',
        '9d9347a3102dc7c535ed2192b281c4ac',
        '9473cbf383e273d22a2d022f40775d56'
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }

    public static function valid()
    {
        if(\Environment::get('requestUri') === '/contao/install')
        {
            return true;
        }

        if (static::$initialized === false)
        {
            static::$valid = ImmoManager::checkLicenses(\Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }

}