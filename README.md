# EzAccordionBlockBundle

EzAccordionBlockBundle provide a new accordion block in the landingpage in the page edit mode.

## Prerequisites
* **eZ Platform Enterprise Edition**
* bootstrap framework   (you have to change the block view template if you are using other framework)

## Features
* Adding accordion block per drag and drop in any layout zone
* Out of the box bundle, no other settings are needed
* Responsive design for every devices

## Installation
Clone or download the bundle in your src folder

Then add it to your application:

```php
// app/AppKernel.php

    public function registerBundles()
    {   
        $bundles = array(
        // ...
        new EzAccordionBlockBundle\EzAccordionBlockBundle(),
        // ...
    );
}
```

Create a new "accordion" ContentType within the "Content" group. ! do not change the ContentType name. 
```
php app/console ezpublish:cookbook:create_content_type accordion Content
```

Create assets
```
php app/console assets:install
```

Clear cache (production add : --env=prod)
```
php app/console cache:clear
```

## Usage
1. Create a Folder in the content tree
2. Add some "accordion" Objects 
3. In the LandingPage add a new accordion block
4. Select the Folder created in 1 

## Screenshots
Inside the doc folder


