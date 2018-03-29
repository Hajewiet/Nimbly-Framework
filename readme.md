Nimbly Framework
================
Nimbly is an ultra-rapid PHP application development micro framework. It lets you create fast PHP web applications with a minimal footprint. 

Nimbly is for 100% customized applications, where each HTML, CSS and JS file is handcrafted and does exactly what it needs to do, no more, no less.
A build-in template engine facilitates top-down development where a web app can evolve from mockups to final implementation all in the same framework.

Nimbly is flexible, organized and almost has no learning curve.


## Under the hood
Nimbly core is written in plain (vanilla) PHP 7 with Apache as web host. Coding principles and philosophy:
* Maximize use of standard available PHP functions for best performance and security. 
* Delegate routing, static file hosting and folder security to the web server (Apache) for better performance and less code.
* PHP logic is implemented in libraries, encouraged to be small, simple and fast.


## What it does
The Nimbly system core is designed to provide a minimal set of features, just enough to get started building your app. It contains:

* Routing.
* Template engine that works with shortcodes between brackets [likethis].
* Support for responsive and adaptive design.
* Image server.
* HTML5 template, core CSS and JavaScript functions to handle the most essential behaviors.
* Inline editing.
* Lazy image loading with automatic image sizing (considering device ppi).
* Data management. By default, data is stored in the `data` directory using a custom NoSQL solution, storing resources in JSON files. 
* JSON api. All data resources are automatically available via a JSON api.
* User management. Users, roles, groups and access rights.
* Admin. Screens for handling system configuration.
* Application layers and modules so you can easily overwrite and extend these core features.


## Shortcodes syntax
The build-in template engine replaces any "shortcode" between brackets, like `[username]` with a variable value, (sub)template or php logic from a library (in order of preference). 

Some examples of shortcodes:
* [html] The shortcode `html` returns a html page from a template file
* [username] shows the name of the currently logged in user or `anonymous`, implemented with a php function that reads it from session

This works for html and any textual content type. You can for example use shortcodes in CSS or JavaScript.

Shortcodes can be nested: you can use shortcodes within shortcodes. `[include [cur-path]/myfile.inc]`

Parameters within a shortcode need double quotes if the parameter string value contains spaces, otherwsise the quotes are not needed. Parameters can only be used for shortcodes implemented by a library function. `[include file="[cur-path]/my file with spaces.inc"]`

As noted before, shortcodes can be implemented by variable, template or lib function.

__variable shortcode__
If you set a nimbly variable (the default core library to this is "set" in core/lib/set/set.php) either programatically with set_variable('somename', value) or with a shortcode in a template like [set somename=value], you can afterwards get the value with the shortcode [somename]. You can also use [get somename] which allows you to use a default value [get somename default="none"]

__template shortcode__
A shortcode can be implemented by a template, either by placing a template with the same name as the shortcode in the same directory as the route, or by placing a generic template in /ext/tpl/. If the shortcode is [somename] and the route is `someroute`, you can create ext/uri/someroute/somename.tpl or a generic (reusable) template in /etc/tpl/somename/index.tpl. A template can contain shortcodes on its own, implemented by again variables, templates or libraries.

__library shortcode__
For more complex shortcodes that require programming logic, you can create a library function. The name of the path and php file should match the name of the shortcode. The function name that implements the shortcode has a suffix `_sc`. Example: [somename] can be implemented by `function somename_sc()` in /ext/lib/somename/somename.php.
Library shortcodes can take parameters [somename param1=value1 param2=value2 param3="value 3"] which are passed as an array to the function.


## Layers
There are three application layers: core, contrib and ext.

__core__
System core providing basic features like routing, template engine and data storage. The core should not be changed. 

__contrib__
Reserved for code (normally modules) by others or for sharing modules between projects.

__ext__
Extension layer. All your custom code goes in this layer. You can extend the core with custom features or overwrite any core feature. To overwrite a core route, template or library with your own version, just place it under the same path.


## Directory Structure
Each layer organizes code in the following sub directories:

* static: static file hosting
* tpl: front-end templates
* lib: php logic in libraries
* uri: url routes
* modules: code can be organized in modules, with the same directory structure (except static)


## Routes
As Nimbly is top-down, any implementation starts with creating a route, an entry point for the application. A route is a path in the uri directory and must contain an index.tpl template file. The index.tpl file can contain any text with (or wihtout) shortcodes, for example, HTML with shortcodes to load sub-templates.

_Dynamic routes_
For dynamic routes with parameters a route.inc file controls if the route is accepted or denied. By convention, the parameters are placed between parenthesis in the /uri/ directory, example: /ext/uri/blog/(author-id)/(slug) where author-id and slug are the parameters. The route.inc file will verifiy if the author-id and slug are valid and if so, accept the route and initiate further handling via the index.tpl file.


## How to work (example)
As pointed out above, start with creating a route and index.tpl file. For a route 'hello' make a directory /ext/uri/hello. If the purpose of the route is returning an html file, you can use the core html template. Simply type [html] in the index.tpl to include it. If you look at the core html template in /core/tpl/html/index.tpl, you see it defines variables like 'page-title' and regions as sub-templates (like page that contains a subtemplate named body). You can easily customize these by adding your own versions.

Example of ext/uri/hello/index.tpl:
```
[set page-title="My First Nimbly Page"]
[html]
```

Example of body.tpl, placed in the same directory (ext/uri/hello/body.tpl):
```
<p>Hello world!</p>
```

Any shortcode used in the core html template can be overwritten in the ext layer. Either by declaring a variable, a template in the same directory as the route you are implementing, a generic template in /ext/tpl/ or a library function in /ext/lib/


Installation
============

## Requirements
* PHP 7.0
* Apache 2.0 or later
* PHP extensions mbstring, php-mcrypt gd and gmp.
* Apache extensions: rewrite

## Installation
Browse to /install.php to start the installation procedure. It will check requirements, configure folder permissions and create an admin user. Note you can only run the installation once, after the installation completes, it is 'hidden' by route /ext/uri/install that returns a 404 page. To run the install again, first delete the route /ext/uri/install.
After installation you can login with your admin acount. The core login page route is /login.