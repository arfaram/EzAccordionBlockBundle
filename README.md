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
* Clone or download the bundle in your src folder
* Then add it to your application:

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

## Screenshots
Inside the doc folder


