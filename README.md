PhpIdsBundle
============

This is an experimental Bundle whitch supports [PHPIDS] in your Symfony2-Project.


Installation
============

1.  Register bundle in AppKernel.php

        # app/AppKernel.php

        $bundles = array(
            // ...
            new FS\Log4PhpBundle\FSPhpIdsBundle(),
            // ...
        );

2.  Add Bundle to autoload

        # app/autoload.php

        $loader->registerNamespaces(array(
            // ...
            'FS' => __DIR__.'/../vendor/bundles',
            // ...
        ));

3. [Download] the ZIP and unzip it to vendor

4. Add PHPIDS to autoload

        # app/autoload.php

        $loader->registerPrefixes(array(
            // ...
            'IDS_'            => __DIR__.'/../vendor/phpids/lib',
            // ...
        ));

Configuration
=============

Mainly it is a port of the `IDS/Configuration/Configuration.ini.php` to YAML.

Details coming soon.


Usage
=====
         $report = $this->get('phpids')->run();
         if ($report->getImpact() > 20) {
             // do something 
         }
         
Adding GET-Request data to the monitor:

         $ids = $this->get('phpids');
         $ids->addRequest(FS\PhpIdsBundle\PhpIds::REQUEST_GET);

[PHPIDS]: https://phpids.org/
[Download]: https://phpids.org/files/phpids-0.7.zip
