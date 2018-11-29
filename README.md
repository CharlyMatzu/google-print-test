# Custom Slim Framework Skeleton for PHP Rest API Projects
This project is a simple custom setup for PHP API Rest projects using slim framework 3. 

* Easy Configuration
* Examples with database connection and Singleton dummy data
* Based on the original Slim Skeleton Project: https://github.com/slimphp/Slim-Skeleton


### Root /

* __Index.php:__ Slim App initialization, API files inclution.
* __Config.php:__ Contains some constants for storage directory PATHS. Can be used for more useful configuration like database connection, error reporting (slim handles this) and more.
* __vendor/__ Composer dependencies.
* __app/__ All project files used for the API (back-end)


### App/ Directory
All php files located in /App Directory separated depending of their functionality:

* __Middleware:__ First invoked classes. Used for check request params, headers and more before to continue to the controllers.

* __Controller:__ Request and Response Handlers. Receive and return responses only and send information to services.

* __Service:__ Invoked by Controllers. Contains the business logic, data process, validations, etc.

* __Persistence:__ Contains all queries to execute with database, get and set result sets. Data handle only. Singleton classes for data simulation can be here.

* __Includes:__ All Generic and useful classes. 

    * __FlatLogger__: Easy monolog implementation.

* __Models:__ Some useful objects (Entities). Can be removed.

* __Exceptions:__ Custom Exception classes. yeah...


in the App directory there are some php files used by slim framework setup:

* __dependencies:__ Controllers to load
* __middleware:__ Middleware to load. Includes __CORS__ middleware
* __routes:__ API Endpoints
* __errorHandle:__ Custom responses for error handling.
* __setting:__ Extra configuration of the framework, see: https://www.slimframework.com/docs/v3/objects/application.html#application-configuration
* __autoload:__ optional autoloader for classes (currently composer autoloader is working in this project, see: __composer.json__, autoload section): __require_once "vendor/autoload.php"__ is used to include



### TODO
* Add Twig or blade render support for Views.
* Add stream handler endpoint example (upload and download)
* Factory pattern implementation for Database connection and request.

### Feedback
Any advice is perfectly accepted, please, give me your feedback at carlosrozuma@gmail.com.