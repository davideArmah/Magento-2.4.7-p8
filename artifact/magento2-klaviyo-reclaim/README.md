
# magento2-klaviyo-reclaim
Hyvä Themes Compatibility module for Klaviyo_Reclaim
 
## Installation

### Via packagist.com

Hyvä Compatibility modules that are tagged as stable can be installed using composer via packagist.com:

1. Install via composer
    ```
    composer require hyva-themes/magento2-klaviyo-reclaim
    ```
2. Enable module
    ```
    bin/magento setup:upgrade
    ```


### Via gitlab

For development of or to contribute to a compatibility module, it needs to be installed using composer via gitlab.  
This installation method is not suited for deployments, because gitlab requires SSH key authorization.

1. Install via composer
    ```
    composer config repositories.hyva-themes/magento2-klaviyo-reclaim git git@gitlab.hyva.io:hyva-themes/hyva-compat/magento2-klaviyo-reclaim.git
    composer require hyva-themes/magento2-klaviyo-reclaim
    ```
2. Enable module
    ```
    bin/magento setup:upgrade
    ```
   