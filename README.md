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
		
		You have to setup the include_path set_include_path(get_include_path().':'.__DIR__.'/../vendor/phpids/lib');

Configuration
=============

Mainly it is a port of the `IDS/Configuration/Configuration.ini.php` to YAML.

        # app/config/config.yml

        fs_php_ids:
          general:
            inputs: [ post ]
            filter_type: xml
            use_base_path: true
            use_default_filter: false
            tmp_path: tmp
            scan_keys: true
            html: [ ]
            json: [ ]
            exceptions: [ ]
            min_php_version: 5.1.6
          caching:
            method: file


If `use_default_filter` is `false` you must specify a filter-file. If it is `true` PHPIDS uses the `default_filter.xml`.

To specify input request-types you can add `post`,`get`,`cookie`,`all` to the `inputs` array. In this case `all` means the `$_REQUEST` super-global.

The `base_path` option has the default-value `%kernel.root_dir%/../vendor/phpids/lib/IDS/`. 

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
