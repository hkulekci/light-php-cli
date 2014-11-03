## A Light Tool for PHP Command Line Interface 

This tool or is example and bootstrap for CLI part of your project. You can fork and send pull request. I want to keep simple.

## Usage 

You can use following line to run a parameter: 

```
> php -c service/php.ini service/bootstrap.php parameter1 index
Running from CLI
parameter1 file index method is runned! Args : a:0:{}
> php -c service/php.ini service/bootstrap.php parameter1 index param1 param2
Running from CLI
parameter1 file index method is runned! Args : a:2:{i:0;s:6:"param1";i:1;s:6:"param2";}
>
```

To run script with while loop, use the following script.

```
php -c service/php.ini service/bootstrap.php as_a_service parameter1 index
```
