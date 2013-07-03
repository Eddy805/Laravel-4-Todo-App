<?php

class TasksTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('tasks')->delete();

        $tasks = array(
            ['title' => 'haircut', 'completed' => false],
            ['title' => 'learn php5.5 new feature', 'completed' => true]
        );

        // Uncomment the below to run the seeder
        DB::table('tasks')->insert($tasks);
    }

}