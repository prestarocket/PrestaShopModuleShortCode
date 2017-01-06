<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_ShortCode extends Module
{
    public function __construct()
    {
        $this->name = 'ps_shortcode';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Alex Sampaio';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->trans('Shortcode filter', array(), 'Modules.Shortcode.Admin');
        $this->description = $this->trans('Filter shortcode from HTML content.', array(), 'Modules.Shortcode.Admin');
        $this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('filteredHtmlContent') &&
            $this->registerHook('filteredProductContent') &&
            $this->registerHook('filteredCategoryContent') &&
            $this->registerHook('filteredManufacturerContent') &&
            $this->registerHook('filteredSupplierContent') &&
            $this->registerHook('filteredCmsContent') &&
            $this->registerHook('filteredCmsCategoryContent')
        ;
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Filter for htmlContentHook
     *
     * @param $params
     * @return mixed
     */
    public function hookFilteredHtmlContent($params)
    {
        if (!empty($params['type']) && !empty($params['htmlFields'])) {
            foreach ($params['htmlFields'] as $field) {
                switch ($params['type']) {
                    case 'product':
                        $params = $this->hookFilteredProductContent($params, $field);
                        break;

                    case 'category':
                        $params = $this->hookFilteredCategoryContent($params, $field);
                        break;

                    case 'manufacturer':
                        $params = $this->hookFilteredManufacturerContent($params, $field);
                        break;

                    case 'supplier':
                        $params = $this->hookFilteredSupplierContent($params, $field);
                        break;

                    case 'cms':
                        $params = $this->hookFilteredCmsContent($params, $field);
                        break;

                    case 'cms_category':
                        $params = $this->hookFilteredCmsCategoryContent($params, $field);
                        break;

                    default:
                        break;
                }
            }
        }

        return $params;
    }

    /**
     * Filter for productHook.
     *
     * @param $params
     * @param bool $field
     * @return mixed
     */
    public function hookFilteredProductContent($params, $field = false)
    {
        if (!empty($field) && isset($params['object'][$field])) {
            $params['object'][$field] = $this->filterShortCode($params['object'][$field]);
        } else {
            $params['object']['description'] = $this->filterShortCode($params['object']['description']);
            $params['object']['description_short'] = $this->filterShortCode($params['object']['description_short']);
        }

        return $params;
    }

    /**
     * Filter for categoryHook.
     *
     * @param $params
     * @param bool $field
     * @return mixed
     */
    public function hookFilteredCategoryContent($params, $field = false)
    {
        if (!empty($field) && isset($params['object'][$field])) {
            $params['object'][$field] = $this->filterShortCode($params['object'][$field]);
        } else {
            $params['object']['description'] = $this->filterShortCode($params['object']['description']);
        }

        return $params;
    }

    /**
     * Filter for manufacturerHook.
     *
     * @param $params
     * @param bool $field
     * @return mixed
     */
    public function hookFilteredManufacturerContent($params, $field = false)
    {
        if (!empty($field) && isset($params['object'][$field])) {
            $params['object'][$field] = $this->filterShortCode($params['object'][$field]);
        } else {
            $params['object']['description'] = $this->filterShortCode($params['object']['description']);

            if (isset($params['object']['text'])) {
                $params['object']['text'] = $this->filterShortCode($params['object']['text']);
            }
        }

        return $params;
    }

    /**
     * Filter for supplierHook.
     *
     * @param $params
     * @param bool $field
     * @return mixed
     */
    public function hookFilteredSupplierContent($params, $field = false)
    {
        if (!empty($field) && isset($params['object'][$field])) {
            $params['object'][$field] = $this->filterShortCode($params['object'][$field]);
        } else {
            $params['object']['description'] = $this->filterShortCode($params['object']['description']);

            if (isset($params['object']['text'])) {
                $params['object']['text'] = $this->filterShortCode($params['object']['text']);
            }
        }

        return $params;
    }

    /**
     * Filter for cmsHook.
     *
     * @param $params
     * @param bool $field
     * @return mixed
     */
    public function hookFilteredCmsContent($params, $field = false)
    {
        if (!empty($field) && isset($params['object'][$field])) {
            $params['object'][$field] = $this->filterShortCode($params['object'][$field]);
        } else {
            $params['object']['content'] = $this->filterShortCode($params['object']['content']);
        }

        return $params;
    }

    /**
     * Filter for cmsCategoryHook.
     *
     * @param $params
     * @param bool $field
     * @return mixed
     */
    public function hookFilteredCmsCategoryContent($params, $field = false)
    {
        if (!empty($field) && isset($params['object'][$field])) {
            $params['object'][$field] = $this->filterShortCode($params['object'][$field]);
        } else {
            $params['object']['cms_category']['description'] = $this->filterShortCode($params['object']['cms_category']['description']);
        }

        return $params;
    }

    /**
     * Filter ShortCode engine.
     *
     * @param $string
     *
     * @return mixed
     */
    private function filterShortCode($string)
    {
        $colors = array('red', 'blue', 'green', 'black');

        foreach ($colors as $color) {
            $string = str_replace('--['.$color.']', '<span style="color: '.$color.';">', $string);
            $string = str_replace('[/'.$color.']--', '</span>', $string);
        }

        return $string;
    }
}
