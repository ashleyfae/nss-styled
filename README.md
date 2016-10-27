# Styled Naked Social Share Buttons

This plugin is an add-on for [Naked Social Share](https://github.com/nosegraze/naked-social-share). This plugin adds some extra styling and features:

* Coloured backgrounds for social share sites (based on their branding).
* A "total shares" section at the end that shows the total number of shares.

I recommend enabling no more than 3 social sites to avoid layout issues. If you use more than that, they may not all fit neatly on one line.

## Filters

To hide the total shares area if there are 0 shares:

```php
add_filter( 'nss-styled/hide-all-if-no-shares', '__return_true' );
```