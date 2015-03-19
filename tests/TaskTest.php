<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');
    //setting new DB variable and connect to to_do_test database

    class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()//clearing the table after each test, protected??
        {
            Task::deleteAll();
        }

        function test_getId()
        {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $test_Task = new Task($description, $id, $category_id);
             $test_Task->save();

             //Act
             $result = $test_Task->getId();

             // Assert
             $this->assertEquals(true, is_numeric($result));

         }

         function test_getCategoryId()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $test_Task = new Task($description, $id, $category_id);
             $test_Task->save();

             //Act
             $result = $test_Task->getCategoryId();

             //Assert
             $this->assertEquals(true, is_numeric($result));
         }

         function test_setId()
         {
             //Arrange
             $name = "Home stuff";
             $id = null;
             $test_category = new Category($name, $id);
             $test_category->save();

             $description = "Wash the dog";
             $category_id = $test_category->getId();
             $test_Task = new Task($description, $id, $category_id);
             $test_Task->save();

             //Act
             $test_Task->setId(2);

             //Assert
             $result = $test_Task->getId();
             $this->assertEquals(2, $result);
         }

        function test_save()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";//setting test description
            $category_id = $test_category->getId();//set id to null
            $test_Task = new Task($description, $id, $category_id);
            //put id and description into new instance of Task class, put into test_Task variable

            //Act
            $test_Task->save();//save our test_Task

            //Assert
            $result = Task::getAll();
            $this->assertEquals($test_Task, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";//set descriptions for each task
            $category_id = $test_category->getId();
            $test_Task = new Task($description, $id, $category_id);//use two tasks to verify getAll method
            $test_Task->save();

            $description2 = "Water the lawn";
            $test_Task2 = new Task($description2, $id, $category_id);
            $test_Task2->save();

            //Act
            $result = Task::getAll();//result = all of the objects we get from the Task class

            //Assert
            $this->assertEquals([$test_Task, $test_Task2], $result);
        }

      function test_deleteAll()
      {
          //Arrange
          $name = "Home stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Wash the dog";
          $category_id = $test_category->getId();
          $test_Task = new Task($description, $id, $category_id);
          $test_Task->save();

          $description2 = "Water the lawn";
          $test_Task2 = new Task($description2, $id, $category_id);
          $test_Task2->save();


          //Act
          Task::deleteAll();


          //Assert
          $result = Task::getAll();
          $this->assertEquals([], $result);

      }

       function test_find()
       {
           //Arrange
           $name = "Home stuff";
           $id = null;
           $test_category = new Category($name, $id);
           $test_category->save();

           $description = "Wash the dog";
           $category_id = $test_category->getId();
           $test_Task = new Task($description, $id, $category_id);
           $test_Task->save();

           $description2 = "Water the lawn";
           $test_Task2 = new Task($description2, $id, $category_id);
           $test_Task2->save();

           //Act
           $result = Task::find($test_Task->getId());

           //Assert
           $this->assertEquals($test_Task, $result);
       }
       
               function task_name()
        {
            //Arrange
            $name = "Tommy";
            $id = 5;
            $test_category = new Category($name, $id);
            $test_category->save();
            $category_id = $test_category->getId();


            $name = "Wash Car";
            $id = 3;
            $test_Task = new Task($name, $id, $category_id);
            $test_Task->save();

            $result = Task::searchByName("Wash Car");

            //assert
            $this->assertEquals($test_Task, $result);


        }

    }
?>
