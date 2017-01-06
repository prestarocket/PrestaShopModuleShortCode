# PrestaShopModuleShortCode
Shortcode module example for PrestaShop


## Install
- Clone this repository into your modules folder like `prestashop/modules/ps_shortcode`
- Install this module

This module shows multiple examples for filters hooks: 
- filterHtmlContent, used for all object fields (TYPE_HTML =6 - ObjectPresenter)
- filteredProductContent, used in ProductController before rendering the product page
- filteredCategoryContent, used in CategoryController before rendering the category page
- filteredManufacturerContent, used in ManufacturerController before rendering the manufacturer page
- filteredSupplierContent, used in SupplierController before rendering the supplier page
- filteredCmsContent, used in CmsController before rendering the cms page
- filteredCmsCategoryContent, used in CmsController before rendering the cms category page

## Example
You can add this to your product description (or category, cms, manufacturer, etc): 

```
--[blue]A blue color.[/blue]--
--[red]A red color.[/red]--
--[green]A green color.[/green]--
--[black]A black color.[/black]--
```

It should be converted on your front office product (or category, cms, manufacturer, etc) page.
