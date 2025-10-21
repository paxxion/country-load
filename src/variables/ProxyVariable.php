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

    public function allRegions() {
        $countries = $this->countries('fr');
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
                'label' => '',
                'select' => '',
                'error' => '',
            ],
            'required' => [
                'country' => true,
                'region' => true,
            ],
            'labels' => [
                'country' => 'Country',
                'region' => 'Region',
                'chooseCountry' => 'Choose your country',
                'chooseRegion' => 'Choose region',
            ],
            'names' => [
                'country' => 'country',
                'region' => 'region',
            ]
        ];

        $options = array_replace_recursive($defaults, (array) $options);

        $view = Craft::$app->getView();
        $html = $view->renderTemplate('country-load/_dropdown.twig', ['options' => $options], $view::TEMPLATE_MODE_CP);
        return new Markup($html, Craft::$app->charset);
    }

    
}
