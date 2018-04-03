<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Grid
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware
 */

namespace SilverWare\Grid;

use SilverStripe\Forms\CheckboxField;
use SilverWare\Forms\FieldSection;

/**
 * An extension of the grid class for a row.
 *
 * @package SilverWare\Grid
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware
 */
class Row extends Grid
{
    /**
     * Human-readable singular name.
     *
     * @var string
     * @config
     */
    private static $singular_name = 'Row';
    
    /**
     * Human-readable plural name.
     *
     * @var string
     * @config
     */
    private static $plural_name = 'Rows';
    
    /**
     * Description of this object.
     *
     * @var string
     * @config
     */
    private static $description = 'A row within a SilverWare template or layout section';
    
    /**
     * Icon file for this object.
     *
     * @var string
     * @config
     */
    private static $icon = 'silverware/silverware: admin/client/dist/images/icons/Row.png';
    
    /**
     * Defines the table name to use for this object.
     *
     * @var string
     * @config
     */
    private static $table_name = 'SilverWare_Row';
    
    /**
     * Defines an ancestor class to hide from the admin interface.
     *
     * @var string
     * @config
     */
    private static $hide_ancestor = Grid::class;
    
    /**
     * Defines the default child class for this object.
     *
     * @var string
     * @config
     */
    private static $default_child = Column::class;
    
    /**
     * Maps field names to field types for this object.
     *
     * @var array
     * @config
     */
    private static $db = [
        'NoGutters' => 'Boolean',
        'EdgeToEdge' => 'Boolean',
        'UseContainer' => 'Boolean'
    ];
    
    /**
     * Defines the default values for the fields of this object.
     *
     * @var array
     * @config
     */
    private static $defaults = [
        'NoGutters' => 0,
        'EdgeToEdge' => 0,
        'UseContainer' => 0
    ];
    
    /**
     * Defines the allowed children for this object.
     *
     * @var array|string
     * @config
     */
    private static $allowed_children = [
        Column::class
    ];
    
    /**
     * Answers a list of field objects for the CMS interface.
     *
     * @return FieldList
     */
    public function getCMSFields()
    {
        // Obtain Field Objects (from parent):
        
        $fields = parent::getCMSFields();
        
        // Create Options Fields:
        
        $fields->addFieldToTab(
            'Root.Options',
            FieldSection::create(
                'RowOptions',
                $this->fieldLabel('RowOptions'),
                [
                    CheckboxField::create(
                        'NoGutters',
                        $this->fieldLabel('NoGutters')
                    ),
                    CheckboxField::create(
                        'UseContainer',
                        $this->fieldLabel('UseContainer')
                    ),
                    CheckboxField::create(
                        'EdgeToEdge',
                        $this->fieldLabel('EdgeToEdge')
                    )
                ]
            )
        );
        
        // Answer Field Objects:
        
        return $fields;
    }
    
    /**
     * Answers the labels for the fields of the receiver.
     *
     * @param boolean $includerelations Include labels for relations.
     *
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        // Obtain Field Labels (from parent):
        
        $labels = parent::fieldLabels($includerelations);
        
        // Define Field Labels:
        
        $labels['NoGutters']    = _t(__CLASS__ . '.NOGUTTERS', 'No gutters');
        $labels['RowOptions']   = _t(__CLASS__ . '.ROW', 'Row');
        $labels['EdgeToEdge']   = _t(__CLASS__ . '.EDGETOEDGE', 'Edge-to-edge (remove padding)');
        $labels['UseContainer'] = _t(__CLASS__ . '.USECONTAINER', 'Use container');
        
        // Answer Field Labels:
        
        return $labels;
    }
    
    /**
     * Answers an array of container class names for the HTML template.
     *
     * @return array
     */
    public function getContainerClassNames()
    {
        $classes = [];
        
        $this->extend('updateContainerClassNames', $classes);
        
        return $classes;
    }
    
    /**
     * Answers true if the row uses an edge-to-edge container.
     *
     * @return boolean
     */
    public function isEdgeToEdge()
    {
        return (boolean) $this->EdgeToEdge;
    }
    
    /**
     * Answers true if the row does not use gutters.
     *
     * @return boolean
     */
    public function isNoGutters()
    {
        return (boolean) $this->NoGutters;
    }
    
    /**
     * Renders the component for the HTML template.
     *
     * @param string $layout Page layout passed from template.
     * @param string $title Page title passed from template.
     *
     * @return DBHTMLText|string
     */
    public function renderSelf($layout = null, $title = null)
    {
        return $this->renderTag($this->renderContainer($this->renderChildren($layout, $title)));
    }
    
    /**
     * Renders the container for the HTML template (if necessary).
     *
     * @param string $content
     *
     * @return string
     */
    public function renderContainer($content = null)
    {
        if ($this->UseContainer) {
            
            return sprintf(
                "<div class=\"%s\">\n%s</div>\n",
                $this->getContainerClass(),
                $content
            );
            
        }
        
        return $content;
    }
}
