<?php

/**
 * Backenddashboard Addon
 * 
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 * @author <a href="http://www.redaxo.de">www.redaxo.de</a>
 * 
 * @package redaxo4
 * @version svn:$Id$
 */

/*abstract*/ class rex_dashboard_component_base
{
  var $config;
  var $funcCache;
  
  function rex_dashboard_component_base($cache_options = array())
  {
    $this->funcCache = new rex_function_cache(new rex_file_cache($cache_options));
  }
  
  /*protected*/ function prepare()
  {
    // override in subclasses to prepare component
  }
  
  
  /*public*/ function checkPermission()
  {
    // no permission required by default
    return true;
  }

  /*public*/ function setConfig(/*rex_dashboard_component_config*/ $config)
  {
    $this->config = $config;
  }
  
  /*public*/ function get()
  {
    if($this->checkPermission())
    {
      $callable = array($this, '_get');
      $cachekey = $this->funcCache->computeCacheKey($callable);
      $cacheBackend = $this->funcCache->getCache(); 
      
      $configForm = '';
      if($this->config)
      {
        $configForm = $this->config ? $this->config->get() : '';
        
        if($this->config->changed())
          $cacheBackend->remove($cachekey);
      }
      
      $content = $this->funcCache->call($callable);
      
      $cachestamp = $cacheBackend->getLastModified($cachekey);
      if(!$cachestamp) $cachestamp = time(); // falls kein gueltiger cache vorhanden
      $cachetime = rex_formatter::format($cachestamp, 'strftime', 'datetime');
      
      $content = strtr($content, array('%%cachetime%%' => $cachetime));
      $content = strtr($content, array('%%config%%' => $configForm));
      
      return $content;
    }
    return '';
  }
  
  /*public abstract*/ function _get()
  {
    trigger_error('The _get method has to be overridden by a subclass!', E_USER_ERROR);
  }
  
  /*public*/ function registerAsExtension($params)
  {
    $params['subject'][] = $this;
    return $params['subject'];
  }
}