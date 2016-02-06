CoolBuilder
=======================

Introduction
------------
This builder will helps with creating the structure, Classes and PHPUnit: for modules, forms and table gateways directly with their  default setup. Where needed this system will generate the base for an managing the content panel and create the related table gateway to store the information.

Customization
------------
If you prefer a different setup then the default supplied in this repository you can just replace or add another folder inside the folder 'data/templates'.

Setup
------------
In the folder 'config/autoload' you will find a file named 'local.php.dist'. Make a copy of the file in the exact same location and name it 'local.php'. Modify this file to your local environment settings.

```
return array(
	'projects_dir' => '/path/to/overwrite'
);
```

That's it for now, enjoy!
