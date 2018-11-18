<?php

namespace SmartPage\Middleware;
use Dappur\Middleware\Middleware as Middleware;

/**
 * [SPBootstrap Middleware]
 * -> Később ezt a fájlt innen ki kell venni, és át rakni a csomagomba....!!!!
 */
class SPBootstrap extends Middleware
{
    public function __invoke($request, $response, $next)
    {

			/**
			 * [Add Custom Path to TwigView]
			 * @var [type]
			 */

			$sp_tpls = $this->container['conf']->get('dir.tpl.root');
			$sp_macros = $this->container['conf']->get('dir.tpl.macros');
			$assets = $this->container['conf']->get('dir.assets');
			$css = $this->container['conf']->get('dir.tpl.css');
			$modules = $this->container['conf']->get('dir.tpl.modules');
			$admin = $this->container['conf']->get('dir.tpl.admin');
			$headers = $this->container['conf']->get('dir.tpl.headers');
			$this->view->getEnvironment()->getLoader()->prependPath($sp_tpls, 'sp');

      $this->view->getEnvironment()->getLoader()->prependPath($sp_macros, 'macros');
			$this->view->getEnvironment()->getLoader()->prependPath($assets, 'assets');
			$this->view->getEnvironment()->getLoader()->prependPath($css, 'css');

			$this->view->getEnvironment()->getLoader()->prependPath($modules, 'modules');
			$this->view->getEnvironment()->getLoader()->prependPath($headers, 'headers');

			$this->view->getEnvironment()->getLoader()->prependPath($admin, 'admin');

			$aos = $this->container['conf']->get('dir.tpl.aos');
			$this->view->getEnvironment()->getLoader()->prependPath($aos, 'aos');


			/**
			 * Add SP Dependencies to the Global Enviroment
			 * @var [$this->container]
			 */
      $this->view->getEnvironment()->addGlobal('conf', $this->conf);
			$this->view->getEnvironment()->addGlobal('resources', $this->resources);
			$this->view->getEnvironment()->addGlobal('assets', $this->assets);

			$this->view->getEnvironment()->addGlobal('css', $this->css);
			$this->view->getEnvironment()->addGlobal('api', $this->api);
			$this->view->getEnvironment()->addGlobal('Money', $this->Money);

			$this->view->getEnvironment()->addGlobal('AS', $this->AS);

			/**
			 * Add SP TwigExtionsons to the Global Enviroment
			 * @var [$this->container]
			 */
			$this->view->addExtension(new \SmartPage\TwigExtension\SPHelpers($this->container['request']));
			$this->view->addExtension(new \SmartPage\TwigExtension\SPImages($this->container));



			return $next($request, $response);
    }
}
