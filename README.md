# Clockwork Codeigniter Integration
Debug your application with Clockwork, a powerful tool for finding and fixing issues in PHP code, with Codeigniter, a popular PHP framework. It helps developers to understand and improve the performance of their Codeigniter applications. By using Clockwork's user-friendly interface and visualizations, developers can easily identify and fix problems in their code, resulting in better-performing and higher-quality PHP applications.

This repository provides a straightforward integration of Clockwork, a robust PHP debugging and profiling tool, with Codeigniter, a widely-used PHP framework. By following these simple steps, you can seamlessly integrate Clockwork into your Codeigniter applications and gain valuable insights into your code's performance and behavior.

## Prerequisites

1. Clockwork application (This guide uses CI version 2.1.0, the installation process may vary with other versions)
2. Composer package loader

## Installation

1. **Modify the autload config file**: In the file located `application/config/autoload.php`:
   
   Require the composer autoload file above the autload packages array:
   ```php
   require_once APPPATH . 'vendor/autoload.php'; // Composer Autoload Packages
   $autoload['packages'] = array();
   ```
   Add the debug library to the autload libraries array:
   ```php
   $autoload['libraries'] = array('debug');
   ```

2. **Enable the clockwork hook**:

   Enable hooks in the file located `application/config/config.php`:
   ```php
   $config['enable_hooks'] = TRUE;
   ```
   Add the clockwork hook library function under `application/config/hooks.php`:
   ```php
   /*------- After the controller, end the Clockwork Debugger request (Only works if it's being used) -------*/
   $hook['post_controller'] = array(
     'class'    => 'Clockwork',
     'function' => 'requestProcessed',
     'filename' => 'Clockwork.php',
     'filepath' => 'libraries/'
   );
   ```
   
3. **Add libraries**: Under the directory `application/libraries/` add the following files:
   -  Clockwork.php
   -  Debug.php
     
4. **Set the clockwork routes**: Add the following routes in the file located `application/config/routes.php`:

   ```php
   // Clockwork Debugger API Endpoint
   $route['__clockwork/(:any)/(:any)/(:any)'] = "clockwork/api_clockwork/index/{$1}/{$2}/{$3}";
   $route['__clockwork/(:any)/(:any)'] = "clockwork/api_clockwork/index/{$1}/{$2}";
   $route['__clockwork/(:any)'] = "clockwork/api_clockwork/index/{$1}";
   // Clockwork Web UI
   $route['__clockwork'] = "clockwork/clockworkweb/index";
   ```
   
5. **Add controllers**: Under the directory `application/controllers/` add the following files:
   -  controllers/api_clockwork.php
   -  controllers/clockworkweb.php
   
1. **Install the Clockwork Library**: Install the clockwork library via composer in the directory `application/`:

   After running the following command, the `vendor/` directory will be created along with the `composer.json` and `composer.lock` files.
   ```
   $ composer require itsgoingd/clockwork
   ```

## Usage

Clockwork will now start capturing data from your Codeigniter application, including HTTP requests, database queries, execution time, and more. Navigate to the Clockwork dashboard under the route `<APPROUTE>/__clockwork`to explore the gathered data and analyze your application's performance. Use Clockwork's user-friendly interface to identify potential bottlenecks, debug issues, and optimize your code for better efficiency.

The first time the `Clockwork\Support\Vanilla\Clockwork::init` function is used, the `clockworkweb/` directory will be created outside the `application/` directory. This directory contains the assets used by the web UI.

Log() function documentation:
```php
/**
 * Print a log message on the debugger
 *
 * @param string $message The message to show as a description
 * @param mixed $value The value to show on the log
 * @param string $level The level of the log, options: v - view, c - controller, m - model, l - library, h - helper, f - framework, a - application, p - permissions
 * @param string $type The type of the log, options: emergency, alert, critical, error, warning, notice, info, debug
 * @return void
 */
function log( string $message, $value, $level = 'c', $type = 'info' )
```
Use the following line in your application to log variables:
```php
$this->CI->dbug->log('Message', $variable, 'c', 'info');
```

Event() function documentation:
```php
/**
 * Log an event into the timeline of the debugger
 *
 * @param  string $label A description of the event (Only used with action start)
 * @param  string $name The name of the event, has to be the same on both actions (Used for start and end of the event)
 * @param  string $action Whether to start or end the event, options: start, end
 * @param  string $level The level of the log, options: v - view, c - controller, m - model, l - library, h - helper, f - framework, a - application, p - permissions
 * @param  string $color The color of the timeline, options: blue, red, green, purple, grey
 * @return void
 */
function event( string $label, string $name, string $action, string $level = 'c', string $color = 'blue' )
```
Use the following line in your application to log events:
```php
$this->CI->dbug->event('Event Description', 'event-name', 'start', 'c', 'blue'); // Start Event
...
$this->CI->dbug->event('Event Description', 'event-name', 'end', 'c', 'blue'); // End Event
```

## Contributing

If you find any issues with the integration or have improvements to suggest, we welcome contributions! Feel free to open issues, submit pull requests, or provide feedback to help enhance the Clockwork Codeigniter Integration.
