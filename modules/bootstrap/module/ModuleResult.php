<?php namespace modules\bootstrap\module;

/**
 * Used to control the processing of modules.
 */
enum ModuleResult: int {
  /** Interrupt the processing and continue calling the function from other modules. */
  case Continue = 0;

  /** Interrupt the processing of this function and do not call other modules from the list. */
  case Handled = 1;
}
