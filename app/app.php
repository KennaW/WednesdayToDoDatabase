<?php
    //linking to src file
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";
    require_once __DIR__."/../src/Category.php";

    //setting variable for Silex Application
    $app = new Silex\Application();

    //connect to database
    $DB = new PDO('pgsql:host=localhost;dbname=to_do');

    //telling the app to look in the views folder
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //get method for the index page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig', array('categories' => Category::getAll()));
    });

    //get method for tasks page, and call getAll function on Task class and save it into an array
    $app->get("/tasks", function() use ($app) {
        return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));
    });

    //get method for the category page, call getAll function on Category class and put it into an array
    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.twig', array('categories' => Category::getAll()));
    });

    //get id for current category
    $app->get("/categories/{id}", function($id) use ($app) {
      $category = Category::find($id);
      return $app['twig']->render('category.twig', array('category' => $category,
        'tasks' => $category->getTasks()));
    });

    //post method for categories page for 'name' from our form, getAll function for Category class
    $app->post("/categories", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('index.twig', array('categories' => Category::getAll()));
    });

    //post method for tasks page for 'description' from our form, getAll function for Task class
    $app->post("/tasks", function() use ($app) {
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $task = new Task($description, $id = null, $category_id);
        $task->save();
        $category = Category::find($category_id);
        return $app['twig']->render('category.twig', array('category' => $category,
            'tasks' => Task::getAll()));
    });

    //post method for delete_tasks, calls the deleteAll function and renders index.twig
    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('index.twig');
    });

    //post method for delete_categories, calls the deleteAll function and renders index.twig
    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.twig');
    });

    return $app;


?>
