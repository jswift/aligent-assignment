# The assignment of coding challenge

This is a submission of the coding challenge given by Aligent Consulting. The description of the challenge is not a public question.

## Getting Started

The solution is written by PHP with Zend Framework as a Restful API. It has passed the tests on Linux (Apache HTTPD 2.4 + PHP 7.1.23).

To assess this solution as a web service, you should deploy it on a web server (Apache) and enable URL-rewrite module. The permission of its running directory should include executing permissions and without write permissions (for the concern of security risks).

### Prerequisites

It is a typical web-based application written by PHP Language. Before running the code, you should make sure the environment has been included:
```
A Linux server(CentOS 7 or similar)
Apache HTTPD server 2.4 or higher
PHP 7
Composer tools
```
To set up the environment, the operator may need some specific permission, especially to install the relevant software and launch them.


### Installing

After preparing the classical PHP running environment, check out the code and install the application to a directory with Apache HTTPD server managed.

First, 
```
cd <path/to/setup>
```

then checkout the code from Github,

```
git clone https://github.com/jingfs/aligent-assignment.git .
```

then install the application,

```
composer install
```

and if you want to run the unit tests, you also need to change the config (the value of HOST) for PHPUnit,

```
vi module/Finder/test/ObjectsControllerTest.php
```

Finally, test it. There are many ways to test it. Here is an example to test it by a curl command.

```
curl -S -d '{"samples": [{"x": 6.0,"y": 8.0,"distance": 5.0}, {"x": 0.0,"y": 0.0,"distance": 5.0}]}' -H "Content-Type: application/json" -X POST http://zf.local.net/v1.0/object-finder/objects

```

## Versioning

It is version 1.0 and just for assessing the coding skills. In the following days, I am going to add more features such as a web-based GUI to demonstrate the queries and solutions.

## License

All the copyrights belong to Aligent Consulting.

