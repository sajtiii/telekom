# Telekom test
This is my small application for my telekom application.

## 1. part (Questions):
#### Angular
I am trying my best to answer these questions, but currently I do not have any relations to AngularJS, in my procejts I mainly use VueJS, so I am trying to answer the following questions with analogies between those two.

###### 1. What is the main idea behind signals? 
 

###### 2. What are the pros and the cons of standalone components? 
As in VueJS, it is possible to build up the application using one file only, but this comes with many drawbacks. Tearing apart the application into smaller, managable portions can solve the problem, but this approach also introduces some drawbacks.

Standalone components are easier to manage, reusable, and have their own scope of variables, functions, etc..., on the other hand, sharing data between components becomes harder.

###### 3. What is the difference between pure and impure pipes? 




###### 4. What is RxJS? 
Reactive Extensions for JavaScript (RxJS) is a reactive (when the data changes change the DOM) library utilizing the observer design pattern (when something happens, react to it). 

###### 5. What are Value Accessors? Where can you use them? 
A Value Accessor defines a bridge between the Angular forms API and the native DOM element.



###### 6. How can components communicate with each other? 
 
###### 7. What is AsyncPipe? How may you use it?

#### Laravel
###### 8. What are Middlewares? For which purpose you may use them? 
Middlewares in a Laravel application sits between the actual request and the controller. These classes are located inside the `app/Http/Middlewares` folder. Every request that has the specific middleware attached to it goes throuh it, and the middleware can decice what to do with it. It can wither drop, modify or simply just forward it.

They can be used in many ways, such as modifying the request (eg.: adding or removing headers) also they can be used to authorize the request even before they reach the controller.    

Laravel can also handle middlewares in batches (`web`, `api` middleware groups). They contain multiple middlewares, therefore these are easier to apply to routes. Routes inside the `routes/web.php` are automatically assigned with the `web` middleware group. API routes are similary with the `api` group.


###### 9. How does exception handling work in Laravel? 
Laravel handles all exceptions by default. Once a request is arrived, a corresponding kernel is built up, which contains a giant `try {} catch {}` block, so every execption which are unhandled inside the code are handled by this block.

After catching it, the exception can be routed to specific drivers using the `app/Exceptions/Handler.php` file. 

For exampe: A request fails with an unhandled case (like division with 0). The correspoding exception class is thrown (in out case: `\DivisionByZeroError`). With the following code registered inside the `app/Exceptions/Handler.php` file:
```php
$this->reportable(function (Throwable $e) {
    if ($e instanceof \DivisionByZeroError) {
        die('Huppszi duppszi');
    }
});
```
The error is handled by a custom error message.

This is error handling mechanism is especally useful while using external exception aggregator tools link https://sentry.io.

###### 10. How can you programmatically run external scripts in Laravel? 
Simple php functions such as `exec()` and `shell_exec()` can be used. Also, symfony's `Process` class can be used. Alongside with those options, a package called [Task Runner](https://github.com/protonemedia/laravel-task-runner) can be applied for such tasks.

###### 11. In which ways can you query all data from a database table? 
Querying every rows from Laravel can be quite simple using the query builder on a specific model (eg.: `Model::query()->all()` or `Model::all()`), but it can be resource hungry on large datasets. The `::all()` function utilizes the lazy loading technique, therefore it is quite easy to run into problems like N+1 query.

An other way is to utilize the built in paginator using the `Model::query()->pageinate(20)` snippet, which paginates the resource limiting results to 20 pcs/page.
 
###### 12. How would you write into a database table user requests that failed due to authentication or authorization issues?  
For simpler applications with less visitors a simple `FailedRequest::query()->insert()` (where `FailedRequest` is a model) can be a good solution, as it is easy to implement, but for larger applications some additional care is required.

Larger applicaitons can utilize the queue (using redis) or simply just the redis cache and dump their data into them while handling a request. After it, a scheduled job can easily dump this data inside the database in batches, therefore saving on query count and resource usage.


## 2. part (Practical exercise):
The backend was written in Laravel 10.x, and the frontend was developed using Vue 3.x.

I also left some notes in the code (comments starting with `// NOTE:`). These mark points where I would have made different decisions in the development that would not have been bound by the assignment.

Some basic github actions were also added to the software stack.