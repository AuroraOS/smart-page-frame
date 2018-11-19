<?php

namespace SmartPage\Middleware;

use SmartPage\Model\SPConfigGroups;
use SmartPage\Model\SPConfig;
use SmartPage\Model\SPPages;

use SmartPage\Dappurware\SPSettings;
use SmartPage\Pages\Page;
//use SmartPage\Dappurware\SPAssets2;
use Aos\Core\AosConfig;

use Dappur\Middleware\Middleware as Middleware;


class SPPagesManager extends Middleware
{
		protected $routes = [];

		public function __invoke($request, $response, $next){
			$conf = &$this->conf;

			// * Get the page data
			// *-----------------------------------------------------------------
			$page = new Page($conf->get('is.page'));
			$this->view->getEnvironment()->addGlobal('page', $page->asConfig());

			// * Get the page related modules, and the data as well data
			// *-----------------------------------------------------------------
			$modules = SPSettings::pageModules($conf->get('is.page'), $page->asConfig()->modules());
			$this->view->getEnvironment()->addGlobal('modules', $modules);

      return $next($request, $response);
    }
}
