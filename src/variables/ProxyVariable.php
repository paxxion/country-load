<?php
namespace paxxion\craftcountryload\variables;

use Craft;
use Twig\Markup;
use craft\elements\Entry;
use craft\elements\User;
use paxxion\craftcountryload\Plugin;
use paxxion\craftcountryload\services\GeoService;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;

class ProxyVariable
{
    public function countries($lang = false) {
        return GeoService::countries($lang);
    }

    public function regions($countryCode = false, $lang = false) {
        return GeoService::regions($countryCode, $lang);
    }
    
    public function italyProvinces($region = false) {
        return GeoService::italyProvinces($region);
    }

    public function allRegions($lang = false) {
        $countries = $this->countries($lang);
        $out = [];
        foreach($countries['base'] as $code => $name) {
            $out[$code] = $this->regions($code);
        }
        foreach($countries['promoted'] as $code => $name) {
            $out[$code] = $this->regions($code);
        }
        return $out;
    }

    public function dropdown($options = null) {
        
        $defaults = [
            'ajax' => true,
            'classes' => [
                'wrapper' => '',
                'countryWrapper' => '',
                'regionWrapper' => '',
                'provinceWrapper' => '',
                'label' => '',
                'select' => '',
                'error' => '',
            ],
            'required' => [
                'country' => true,
                'region' => true,
                'province' => true,
            ],
            'labels' => [
                'country' => 'Country',
                'region' => 'Region',
                'province' => 'Province',
                'chooseCountry' => 'Choose your country',
                'chooseRegion' => 'Choose your region',
                'chooseProvince' => 'Choose your province',
            ],
            'names' => [
                'country' => 'country',
                'region' => 'region',
                'province' => 'province',
            ],
            'enableItalyProvinces' => false,
            'language' => false
        ];

        $options = array_replace_recursive($defaults, (array) $options);

        $view = Craft::$app->getView();
        $html = $view->renderTemplate('country-load/_dropdown.twig', ['options' => $options], $view::TEMPLATE_MODE_CP);
        return new Markup($html, Craft::$app->charset);
    }

    
}


// TODO
// lingua dropdown
// province