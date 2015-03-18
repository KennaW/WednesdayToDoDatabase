<?php
    class Task
    {
        private $description;
        private $category_id;
        private $id;

        //setting a construct for Task class with arguments $description and $id
        function __construct($description, $id = null, $category_id)
        {
            $this->description = $description;
            $this->id = $id;
            $this->category_id = $category_id;
        }
        //setting $new_id as an integer and equal to our $id
        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }
        //setting $new_description as a string and equal to our $description
        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function setCategoryId($new_category_id)
        {
            $this->category_id = (int) $new_category_id;
        }

        //getter for returning $id
        function getId()
        {
            return $this->id;
        }
        //getter for returning $description
        function getDescription()
        {
            return $this->description;
        }

        function getCategoryId()
        {
            return $this->category_id;
        }

        function save()
        {
            //setting variable using GLOBALS to call tasks table and insert data and return id.
            $statement = $GLOBALS['DB']->query("INSERT INTO tasks (description, category_id) VALUES
                ('{$this->getDescription()}', {$this->getCategoryId()}) RETURNING id;");
            //use PDO fetch method to get id and put into assoc array
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            //setting setId to result
            $this->setId($result['id']);
        }


        static function getAll()
        {
            //calling Global variable DB, select all from tasks table, put into $returned_tasks
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            //creating empty array
            $tasks = array();
            //foreach loop
            foreach($returned_tasks as $task) {
                //getting description and id from each task
                $description = $task['description'];
                $id = $task['id'];
                //instantiate new Task with description and id from above in $new_task
                $category_id = $task['category_id'];
                $new_task = new Task($description, $id, $category_id);
                //push everything into tasks array
                array_push($tasks, $new_task);
            }
            //return tasks array
            return $tasks;
        }

        static function deleteAll()
        {
            //use global function to call DB, then exec to run a SQL statement to delete ALL from tasks table
            $GLOBALS['DB']->exec("DELETE FROM tasks *;");
        }

        static function find($search_id)//giving find method search_id as an argument
        {
            $found_task = null;
            //use getAll method on Task class, save to tasks variable
            $tasks = Task::getAll();
            foreach($tasks as $task) {
                $task_id = $task->getId();//getting all task id's = new task_id variable
                if ($task_id == $search_id) {//if they are equal...
                    $found_task = $task;//set task == new variable found_task
                }
            }
            return $found_task;//return found task
        }

    // static function can scan everything. In this case, in order to do a search
    // 'search' uses the value $search_term from the twig form
    // we create a new array because sql and php won't talk to each other without the array
    // then we query the globals database for all of the tasks where description matches a wild card version of $search_term. The result of the query is assigned to $search result
    // then we start to fill our array (with array_push)
    // for each instance of search_result, we create a new this_result, which needs the description, category id, and id from the class Task.
    // we then 'push' each instance of $this_result into the empty array $search_array
    // then we have to return the array.

        // static function search($search_term)
        // {
        //     $search_array = array();
        //     $search_result = $GLOBALS['DB']->query("SELECT * FROM tasks WHERE description LIKE '%{$search_term}%'");
        //     foreach($search_result as $this_result) {
        //         $this_result = new Task($description, $category_id, $id);
        //         array_push($search_array, $this_result);
        //     }
        //     return $search_array;
        //
        // }








    }
?>
