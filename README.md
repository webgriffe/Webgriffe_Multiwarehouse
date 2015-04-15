Webgriffe_Multiwarehouse
========================
This Magento module was developed as proof of concept during the Mageday::2014 Workshop.

The module extends the "single warehouse" limitation of Magento through the
creation of a custom warehouse entity.

Facts
-----
- version 0.1.1
- extension key: Webgriffe_Multiwarehouse
- [extension on GitHub](https://github.com/webgriffe/Webgriffe_Multiwarehouse)

Release Notes
-------------
- 0.1.4 - Fixes some issues
- 0.1.3 - Fixes some issues
- 0.1.2 - Fixes some issues
- 0.1.1 - Proof of concept

Description
-----------


Compatibility
-------------
- Magento >= 1.8
- Not tested with previous versions; if you do and it works, please let us know in order to update the compatibility declaration. Thank you in advance.

Installation
------------
This extension can be installed through Modman.

For further information about Modman see https://github.com/colinmollenhour/modman/wiki/Tutorial

Uninstallation
--------------
This extension alters your DB schema by creating the following additional tables:

* <prefix>wg_warehouse
* <prefix>wg_warehouse_product

To uninstall this extension, manually drop the above tables and remove the
following from your Magento installation directory:

* app/code/community/Webgriffe/Multiwarehouse folder
* app/etc/modules/Webgriffe_Multiwarehouse.xml file
* app/design/adminhtml/default/default/layout/webgriffe/multiwarehouse/layout.xml file
* app/design/adminhtml/default/default/template/webgriffe/multiwarehouse/qty.phtml
* app/design/adminhtml/default/default/template/webgriffe/multiwarehouse/order.phtml
* skin/adminhtml/default/default/images/webgriffe/multiwarehouse/warehouse_icon.png
* skin/adminhtml/default/default/webgriffe_multiwarehouse.css
* var/log/wgmulti.log file (if any)

Contribution
------------
Any contribution is highly appreciated. The best way to contribute code is to [open a pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developers
----------
Alessandro Ronchi

- [http://www.alessandroronchi.com](http://www.alessandroronchi.com)
- [@aleron75](https://twitter.com/aleron75)
- [https://github.com/aleron75](https://github.com/aleron75)
- [+AlessandroRonchi](https://plus.google.com/+AlessandroRonchi)

Roberto Gambuzzi

- [http://www.gambuzzi.it](http://www.gambuzzi.it)
- [@gbinside](https://twitter.com/gbinside)
- [https://github.com/gbinside](https://github.com/gbinside)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2014+ Webgriffe
