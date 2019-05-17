# Goaland Alpia PIM Import extension #
This extension imports products from Alpia PIM 3.2 or greater in Magento 2.2 to 2.3.1.

## Getting started
### Prerequisites
This extension is for Magento version 2.2 to 2.3.1:
 - [Enterprise](https://magento.com/products/enterprise-edition)
 - [Community Edition](https://magento.com/products/community-edition)

### Installing
Clone the following Git repository in a local folder. In a command line:

```bash
 $ git clone git@https://github.com/Goaland/magento_alpia-pim_import
```

You can also download the Zip archive and unzip it to a local directory.

Copy the downloaded files in the following folder (If necessary create the "Goalandfrance" directory - with a "G" in capital):

```
[your_magento_root]/app/code/Goalandfrance
```

After the copy, you must have the following directory path structure:

```
[your_magento_root]/app/code/Goalandfrance/AlpiaImport/...
```

Enable the module in Magento (If you need help, please refer to this Magento 2.3 guide: [Enable or disable a module](https://devdocs.magento.com/guides/v2.3/install-gde/install/cli/install-cli-subcommands-enable.html)).  
In a command line, run the following commands:

```bash
$ php bin/magento module:enable Goalandfrance_AlpiaImport
$ php bin/magento setup:upgrade
$ php bin/magento setup:static-content:deploy
```

### Configurations
After installation, go to Magento2 admin. A new "Alpia PIM" menu is available, click on the "Configuration" submenu and fill in all the fields:
 - API URL
 - Rest Application key
 - Rest User key
 - Connector mapping

## Using the CLI
The following CLI command triggers a request to import products of Alpia PIM:

```bash
$ php bin/magento goalandfrance-alpiaimport:import
```

## License
MIT

## Authors
- dev@goaland.com

## Contact
You can contact us by mail: [contact us](mailto://hello@goaland.com)
