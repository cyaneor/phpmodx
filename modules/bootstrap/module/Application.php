<?php namespace modules\bootstrap\module;

/**
 * Interface Application allows the plugin to have a main function that will be called after initializing all plugins.
 * @package bootstrap\plugin
 */
interface Application
{
  /**
   * Executed after module initialization.
   * Module can interrupt the function call (other modules will not be called).
   * @return ModuleResult
   */
  function onMainModule(): ModuleResult;
}