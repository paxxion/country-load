# country-load
A friendly country/region selector for Craft CMS 5

## What it is
Having the country/area dropdowns is one of those things that you need in just about every site. Natively, Craft has its own database but only few countries have their regions. So, we've wrapped the [Symfony Intl](https://symfony.com/doc/current/components/intl.html) component and [L91/ISO 3166-2](https://github.com/alexander-schranz/iso-3166-2) library in a simple plugin, with its own Alpine-powered widget. 

## Disclaimer

This plugin uses open-source PHP libraries to list countries and regions. The data comes from public sources we don’t control, so it might not always be perfect or up to date. Use it “as is” — we can’t take responsibility for any errors or issues that come from the data.

## How to use

`craft.countryLoad.countries(lang)`

This gives you an array of countries and country codes. By default it will use currentSite.language but you can pass an optional parameter.

The result array is always split into `base` and `promoted` countries. This makes it much easier to handle on the frontend but if you don’t like it you can just merge the two arrays.

Important: _base_ results are in alphabetical order, _promoted_ results respect the order in which they’ve entered. 

Promoted but “unallowed” countries will be ignored.

`craft.countryLoad.regions(countryCode)`

This gives you an array of regions for the provided countryCode (case-insensitive).

On top of that Country Load gives you some nice extras:

**Limit which countries are displayed**

Do you only sell to EU? You don’t need to show 200+ countries. Select the countries you want to show in the plugin settings.

**Push specific countries to the top**

Make your primary markets easier to find.

**Ready-made widget**

We’ve included a simple country/area widget, powered by Alpine.js:

`craft.countryLoad.dropdown(options)`

## widget options

```
classes: {
	wrapper: ‘’
	countryWrapper: ‘’
	regionWrapper: ‘’
	label: ‘’
	select: ‘’
	error: ‘’
}
```

CountryLoad does NOT come with styles. If you need them, you can have them.

```
required: {
	country: true,
	region: true
}
```

Pretty straightforward. Please note that if you set required.country to false, required.region will be ignored.

```
labels: {
	chooseCountry: ‘Choose your country’,
	chooseRegion: ‘Choose your region’
}
```

Labels for the dropdowns’ empty states. 

```
names: {
	country: ‘country’,
	region: ‘region’
}
```

Fields names are also customizable.

## FAQ

**Region X of country Z is not listed!**

Unfortunately, we cannot help you with that. Please refer to the included libraries mentioned above to submit your request.

**I don’t like your widget!**

No problem, you have all you need to build one yourself.

**Why is Palestine included?**

Why not?
