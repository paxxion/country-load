<?php

namespace paxxion\craftcountryload\services;

use Craft;
use yii\base\Component;
use paxxion\craftcountryload\Plugin;
use Symfony\Component\Intl\Countries;
use \L91\ISO_3166_2\Subdivision;
use Illuminate\Support\Collection;

/**
 * Geo Service service
 */
class GeoService extends Component
{
    private const EU_COUNTRIES = [
        'AT', // Austria
        'BE', // Belgio
        'BG', // Bulgaria
        'CY', // Cipro
        'CZ', // Repubblica Ceca
        'DE', // Germania
        'DK', // Danimarca
        'EE', // Estonia
        'ES', // Spagna
        'FI', // Finlandia
        'FR', // Francia
        'GR', // Grecia
        'HR', // Croazia
        'HU', // Ungheria
        'IE', // Irlanda
        'IT', // Italia
        'LT', // Lituania
        'LU', // Lussemburgo
        'LV', // Lettonia
        'MT', // Malta
        'NL', // Paesi Bassi
        'PL', // Polonia
        'PT', // Portogallo
        'RO', // Romania
        'SE', // Svezia
        'SI', // Slovenia
        'SK', // Slovacchia
    ];

    public static function countries($lang) {
        if(!$lang) {
            $lang = Craft::$app->language;
        }

        \Locale::setDefault($lang);

        $countries = Countries::getNames();

        $countries['PL'] = 'Palestine';

        $allowed = Plugin::getInstance()->settings->allowedCountries;
        $allowed = self::resolveCountryArray($allowed);

        if(!empty($allowed)) {
            $countries = array_intersect_key($countries, array_flip($allowed));    
        }

        // promuovo

        $promoted = Plugin::getInstance()->settings->promotedCountries;
        $promoted = self::resolveCountryArray($promoted);
        $promotedCountries = null;

        if (!empty($promoted)) {
            $promoted = array_unique($promoted);
            $promotedCountries = [];
            foreach ($promoted as $code) {
                if (isset($countries[$code])) {
                    $promotedCountries[$code] = $countries[$code];
                }
            }
        }

        return [
            'promoted' => $promotedCountries,
            'base' => $countries
        ];
    }

    public static function getEuCountries() {
        return self::EU_COUNTRIES;
    }

    public static function regions($countryCode) {        
        if (!$countryCode) {
            return null;
        }

        $subdivisionRepo = Craft::$app->getAddresses()->getSubdivisionRepository();
        
        $states = Subdivision::getSubdivisions($countryCode);

        if(strtolower($countryCode) == 'pl') {
            return [
                'GZ' => 'Gaza',
                'WB' => 'West Bank'
            ];
        }

        return !empty($states)
            ? $states
            : null;
    }

    public static function italyProvinces($region) {
        if (!$region) {
            return null;
        }

        $filePath = dirname(__DIR__) . '/data/italy.json';
        $json = file_get_contents($filePath);
        $json = json_decode($json, true);

        Craft::dd($json[$region]);
    }
   

    public static function isEuCountry($countryCode) {
        if (!$countryCode) {
            return false;
        }

        return in_array($countryCode, self::EU_COUNTRIES);
    }

    private static function resolveCountryArray($src) {
        $src = strtoupper($src);
        $src = array_filter(explode(',', $src));
        
        if(in_array('EU', $src)) {
            $src = array_merge($src, self::EU_COUNTRIES);
        }

        return $src;
    }
}
