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

/*abstract*/ class rex_dashboard_component extends rex_dashboard_component_base
{
  var $title;
  var $content;
  
  function rex_dashboard_component($title = '', $content = '', $cache_options = array())
  {
    if(!isset($cache_options['lifetime']))
    {
      // default cache lifetime in seconds
      $cache_options['lifetime'] = 60;
    }
    
    $this->title = $title;
    $this->content = $content;
    
    parent::rex_dashboard_component_base($cache_options);
  }

  
  /*public*/ function setTitle($title)
  {
    $this->title = $title;
  }
  
  /*public*/ function getTitle()
  {
    return $this->title;
  }
  
  /*public*/ function setContent($content)
  {
    $this->content = $content;
  }
  
  /*public*/ function getContent()
  {
    return $this->content;
  }
   
  /*public*/ function _get()
  {
    global $I18N;
    
    $this->prepare();
    $content = $this->getContent();
    
    if($content)
    {
      return '
      					<div class="rex-dashboard-content">
                <h3>'. htmlspecialchars($this->getTitle()) .'</h3>
                %%config%%
                '. $content .'
                <p class="rex-dashboard-component-updatedate">
                  '. $I18N->msg('dashboard_component_lastupdate') .'
                  %%cachetime%%
                </p>
              </div>';
    }
    
    return '';
  }
  
  /*
   * Static Method: Returns boolean if is notification
   */
  /*public static*/ function isValid($component)
  {
    return is_object($component) && is_a($component, 'rex_dashboard_component');
  }
}