<?php

/**
 * This file is part of SilverWare.
 *
 * PHP version >=5.6.0
 *
 * For full copyright and license information, please view the
 * LICENSE.md file that was distributed with this source code.
 *
 * @package SilverWare\Model
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware
 */

namespace SilverWare\Model;

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;
use SilverStripe\View\SSViewer;
use Page;
use PageController;

/**
 * An extension of the content controller class for a SilverWare component controller.
 *
 * @package SilverWare\Model
 * @author Colin Tucker <colin@praxis.net.au>
 * @copyright 2017 Praxis Interactive
 * @license https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @link https://github.com/praxisnetau/silverware
 */
class ComponentController extends ContentController
{
    /**
     * Defines the allowed actions for this controller.
     *
     * @var array
     * @config
     */
    private static $allowed_actions = [
        'index'
    ];
    
    /**
     * Default action for a component controller.
     *
     * @param HTTPRequest $request
     *
     * @return HTTPResponse
     */
    public function index(HTTPRequest $request)
    {
        if (!$this->isCMSPreview()) {
            $this->httpError(404);
        }
        
        return $this->render();
    }
    
    /**
     * Answers a viewer object to render the template for the current page.
     *
     * @param string $action
     *
     * @return SSViewer
     */
    public function getViewer($action)
    {
        // Answer Viewer Object (from parent):
        
        if (!$this->isCMSPreview()) {
            return parent::getViewer($action);
        }
        
        // Load Page Requirements (uses theme):
        
        PageController::create(Page::create())->doInit();
        
        // Load Preview Requirements:
        
        Requirements::css('silverware/silverware: admin/client/dist/styles/preview.css');
        
        // Answer Viewer Object (for CMS preview):
        
        return new SSViewer(sprintf('%s\CMSPreview', Component::class));
    }
}
