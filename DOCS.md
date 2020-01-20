# Cage Documentation

## Requirements

#### Craft CMS

Cage requires Craft CMS 3.0 or greater.

#### PHP

Cage requires PHP 7.0 or greater.

## Installation

You can install Cage via the Craft Plugin Store, or through Composer.

#### Craft Plugin Store

To install **Cage**, navigate to the *Plugin Store* section of your Craft control panel, search for `Cage`, and click the *Install* button.

#### Composer

You can also add the package to your project using Composer.

Open your terminal and go to your Craft project:

    cd /path/to/project
 
Then tell Composer to load the plugin:

    composer require skayocrafts/cage

Then tell Craft to install the plugin:

    ./craft install/plugin cage

## Usage

To require a user to verify their age, use the `{% requireAge %}` twig tag.  
For example to require the user to be 18 years or older to visit your site, add an

```twig
{% requireAge 18 %}
```

at the top of your twig template.
  
> If you don't specify an age, like `18` in this case, the plugin will use the default age, specified in the plugin settings:
>
> ```twig
> {# This will fallback to the default age: #}
> 
> {% requireAge %} 
> ```

The reason I've decided to use this method, and not like a list of protected url paths or something is, that this way, you can exactly control on which sites there will be age verification.  
For example if your site uses one layout template file, then specifying the required age there, requires age verification across the whole website.  
But if you just have a single page, like a gallery, that needs age verification, you can just add the `requireAge` tag in the related twig template (`gallery.twig`), and no other site will be affected by it.  
Also this way, you can have different age requirements across the site.

## Configuration

The configuration of Cage is pretty complex, because you can do **a lot** of customisation.
Not only, you have the general settings, like the age verification method (which there are plenty of), but you also have the ability to change the text content and the whole appearance of the age verification page.  
You can play around a lot with different styles and layouts, just find out what suits you the best!

You can find the plugin settings in the Control Panel, at *Settings* → *Cage*.

#### Config File

If you want to use a config file, instead of directly changing the settings in the control panel, copy the `src/config.php` file to `/path/to/project/config` as `cage.php` and make your changes there to override the default settings.  

Once copied to `/path/to/project/config/cage.php`, this file will be multi-environment aware as well, so you can have different settings groups for each environment, just as you do for `general.php`.

