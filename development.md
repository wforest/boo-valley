# Starter Theme Development Instructions

The starter theme was created by **WebMan Design**. Please read the instructions below for theme development process.


## Additional scripts

This starter theme requires installation of these additional scripts:

* [**WebMan WordPress Theme Framework**](https://github.com/webmandesign/webman-theme-framework) - copy the `library` folder into the theme's root folder.
* [**Theme Update Notifier**](https://github.com/webmandesign/webman-theme-framework) - copy the `update-notifier` folder into the `includes` folder.
* [**WordPress CSS starter**](https://github.com/webmandesign/wp-css-starter) - copy the `starter` SASS folder into the `assets/scss` folder.
* **OPTIONAL:**
  [**Post Formats**](https://github.com/webmandesign/wp-post-formats) - copy the `class-post-formats.php` file into the `includes/post-formats` folder.


## Replacements

When developing a new theme, you need to batch replace a predefined set of string variables. Each variable is enclosed in `{%= %}` brackets (i.e. `{%= variable_name %}`).

### Example replacements:

| Prefix variable   | Value |
|-------------------|-------|
| `theme_name`      | Theme Name |
| `theme_slug`      | themeslug |
| `version_since`   | 1.0.0 (http://semver.org/ recommended) |
| `version`         | 1.0.0 (http://semver.org/ recommended) |
| `prefix_constant` | THEMESLUG |
| `prefix_var`      | themeslug |
| `prefix_class`    | Themeslug |
| `prefix_fn`       | themeslug |
| `prefix_js`       | themeslug |
| `prefix_hook_fn`  | themeslug |
| `prefix_hook`     | themeslug |
| `text_domain`     | themeslug |

### Project replacements:

> Developers, fill this section with the actual values used for replacements for future reference.

| Prefix variable   | Value |
|-------------------|-------|
| `theme_name`      | Boo Valley |
| `theme_slug`      | boo-valley |
| `version_since`   | 1.0.0 |
| `version`         | 1.0.0 |
| `prefix_constant` | BOO_VALLEY |
| `prefix_var`      | boo_valley |
| `prefix_class`    | Boo_Valley |
| `prefix_fn`       | boo_valley |
| `prefix_js`       | booValley |
| `prefix_hook_fn`  | boo_valley |
| `prefix_hook`     | boo_valley |
| `text_domain`     | boo-valley |


## Documentation

The theme documentation template can be found in `documentation` subfolder. Documentation uses the `theme_name`, `theme_slug`, `version_since` and `version` from above to be replaced.


## Upgrades

In case you upgrade the library (`library/*.*`) and/or other universal pluggable/external scripts, such as CSS starter (`assets/scss/starter`), you will need to batch replace certain string variables (see above).

Reference of what variables need to be replaced can be found in the scripts themselves.


## Debugging

For SASS debugging define a `BOO_VALLEY_DEBUG_SASS` constant and set it to `true`.

Or simply use `webman-sass-debug.php` plugin for that.

This will force loading `fallback.css` instead of the customizer-generated stylesheet.


*(C) Sulli Digital, [https://www.webmandesign.eu]*
