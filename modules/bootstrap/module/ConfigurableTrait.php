<?php namespace modules\bootstrap\module;

/**
 * The ConfigurableTrait class.
 * This trait provides methods for handling configuration files and directories.
 */
trait ConfigurableTrait
{
  /**
   * Parses a configuration file.
   * This function parses the specified configuration file and returns its contents as an array.
   *
   * @param string $filename The name of the configuration file to parse.
   * @return array|false An array containing the configuration file contents or false on failure.
   */
  final static public function getConfig(string $filename): array|false
  {
    return ($content = @file_get_contents(self::getConfigPath($filename)))
        ? @json_decode($content, true) : false;
  }

  /**
   * Returns the path to the configuration file.
   *
   * This method returns the full path to the configuration file, based on the
   * provided configuration file name. The path is constructed by appending
   * the configuration directory to the filename.
   *
   * @param string $filename The name of the configuration file.
   * @return string The full path to the configuration file.
   */
  final static public function getConfigPath(string $filename): string
  {
    return self::getConfigDir() . DIRECTORY_SEPARATOR . $filename;
  }

  /**
   * Returns the path to the configuration directory.
   *
   * This method returns the full path to the configuration directory.
   * The directory path is constructed by appending the "configs" folder
   * to the module directory.
   *
   * @return string The full path to the configuration directory.
   */
  final static public function getConfigDir(): string
  {
    return self::getRootDir() . DIRECTORY_SEPARATOR . 'configs';
  }
}