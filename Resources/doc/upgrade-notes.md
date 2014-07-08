# Upgrade notes
----------------------------------------------------

This file lists B/C breaking PRs in reverse chronological order. Each PR contains 
description explaining nature of changes and upgrade notes to help you upgrade your 
project.

## Commit [xxx][xxx]

[xxx]: https://github.com/symfony2admingenerator/FormExtensions/commit/xxx

#### Description:

The Twig extension for form stylesheet and javascript blocks was moved to a [seperate bundle][form-bundle]. The dependency was added to composer.json, so it should auto-download upon update, however you need to register it in `AppKernel.php`:

```php
<?php
// AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Admingenerator\FormBundle\AdmingeneratorFormBundle(),
        new Avocode\FormExtensionsBundle\AvocodeFormExtensionsBundle(),
    );
}
?>
```

However, the block names have changed, and in your base template you must rename them, as in:

For Admingenerator users:

```html+django
{% extends 'AdmingeneratorGeneratorBundle::base_admin.html.twig' %}

{% block stylesheets %}
    {{ parent() }}

    {% include 'AvocodeFormExtensionsBundle::stylesheets.html.twig' %}
{% endblock %}

{% block javascripts %}
    {{ parent() }}

    {% include 'AvocodeFormExtensionsBundle::javascripts.html.twig' %}
{% endblock %}
```

For others:

```html+django
{% block stylesheets %}
    {% include 'AvocodeFormExtensionsBundle::stylesheets.html.twig' %}
    
    {% if form is defined %}
        {{ form_css(form) }}
    {% endif %}
{% endblock %}

{% block javascripts %}
    {% include 'AvocodeFormExtensionsBundle::javascripts.html.twig' %}
    
    {% if form is defined %}
        {{ form_js(form) }}
    {% endif %}
{% endblock %}
```

The FormExtensions have been moved under `symfony2admingenerator` github organization. As such, all form types will be prefixed with `s2a_`, however to keep B/C breaks to a minimum, there are aliases created for old types (with `afe_` prefix).

> Note: the `afe_` prefix is deprecated as of now, and will be removed on stable `1.0` version. Use `s2a_` prefix instead.

[form-bundle]: https://github.com/symfony2admingenerator/FormBundle

#### BC Break:

The twig extension has been moved to a seperate bundle. You need to register `new Admingenerator\FormBundle\AdmingeneratorFormBundle()` in your `AppKernel.php`.

The twig extension block names have changed, you need to update your templates:

* `afe_form_stylesheet` was renamed to `form_css`
* `afe_form_javascript` was renamed to `form_js`

Form type names changed: `afe_` prefix was deprecated, you should use `s2a_` instead.

## Commit [#be706a6][cobe706a6] Remove annotations autoloading

[cobe706a6]: https://github.com/symfony2admingenerator/FormExtensions/commit/be706a6

#### Description:

This changed data type returned by `afe_daterange_picker`. Before this commit, it returned a string if you don't use
the model DateRange. Now, if you still don't use the DateRange model, it returns an associative array:

```php
    array('from' => from_value_string, 'to' => to_value_string)
```

#### BC Break:

If you previously use `afe_daterange_picker` and set a default value through a string, you have to change
it by an array.
