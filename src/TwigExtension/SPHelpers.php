<?php

namespace SmartPage\TwigExtension;
use SmartPage\Dappurware\SPUtiles;
use Psr\Http\Message\RequestInterface;
//use Dappur\Dappurware\Utils;

class SPHelpers extends \Twig_Extension {

  protected $request;

  public function __construct(RequestInterface $request) {
      $this->request = $request;
  }

  public function getName() {
      return 'SPHelpers';
  }

  public function getFilters() {
      return array(
		  new \Twig_SimpleFilter('printObj', array($this, 'printObj')),
			new \Twig_SimpleFilter('printCard', array($this, 'printCard')),
		  new \Twig_SimpleFilter('spage', array($this, 'spage')),
		  new \Twig_SimpleFilter('row', array($this, 'row')),
			new \Twig_SimpleFilter('slugify', array($this, 'slugify')),
      //new \Twig_SimpleFilter('slugify', array($this, 'slugify'))
      );
  }

  public function getFunctions() {
      return [
		  new \Twig_SimpleFunction('spage', [$this, 'spage']),
		  new \Twig_SimpleFunction('row', [$this, 'row']),
			new \Twig_SimpleFunction('resources', [$this, 'resources']),
			new \Twig_SimpleFunction('checkAssets', [$this, 'checkAssets'])
      ];
  }

  public function printObj($obj, $type = null, $class='php', $pre='pre') {
    $out = null;
    if ($pre){
      echo '<'.$pre.'><code class="'.$class.'">';
	  if($type === 'json'){
		echo json_encode($obj, true);
	  } else {
      	print_r($obj);
  	  }
      echo '</code></'.$pre.'>';
    }

  }


	public function printCard($obj, array $text, $type = null, $class='php', $pre='pre') {
    $out = null;
    echo '<div class="card"><div class="card-header"><h4>'.$text['h1'].'</h4></div>';
		//echo '<div class="card-body">'.$text['body'].'</div>';

	  $this->printObj($obj, $type, $class, $pre);
		echo '<div class="card-footer">'.$text['footer'].'</div>
		</div>';
  }

  public function spage($first = 'SMART', $second = 'Page', $sub = null, $class="text-info"){
	  $first = strtoupper($first);
	  $second = ucfirst($second);
	  $sub = ucfirst($sub);
	  $txt = '';
	  if ($sub) {
	  	$txt = '-><mark class="text-dark">'.$sub.'</mark>';
	  }
	  return '<samp class="sp-text text-dark"><b class="'.$class.'">'.$first.'</b>'.$second.$txt.'</samp>';
  }

  public function row($first = 'SPC', $text=null, $second = null){
	  $first = $first;
	  $second = ucfirst($second);
	  $txt = '';
	  if ($text) {
	  	$txt = '=><mark class="text-dark">'.$text.'</mark>';
	  }
	  return '<samp class="sp-text text-black"><kbd>['.$first.']'.$txt.'</kbd></samp><br>';
  }


	public function resources($path) {
		return	$this->checkAsset($path);
	}

	public function slugify($string = null) {
		if ($string) {
				return	SPUtiles::slugify($string);
		}
		return false;
	}

	public function checkAsset($path=null, $root = null) {
      if (substr( $path, 0, 4 ) === "http" or substr( $path, 0, 2 ) === '//'){
        return $path;
      } else {
				if ($root) {
					return $path;
				}
        return '/api/resources?path='. $path;
      }
  }


}
