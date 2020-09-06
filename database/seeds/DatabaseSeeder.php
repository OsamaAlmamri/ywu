<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
##################### user Contents
        $this->call(EmployeeCategoryTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(PostTableSeeder::class);
        //$this->call(CommentTableSeeder::class);
##################### women Contents
        $this->call(WomenCategoriesTableSeeder::class);
        $this->call(WomenPostsTableSeeder::class);
##################### subjects with trainings
        $this->call(SubjectCategoryTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(TrainingTableSeeder::class);
        $this->call(TrainingTitleTableSeeder::class);
        $this->call(TitleContentTableSeeder::class);
        $this->call(ExamTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
#################### ٍ SharedUsers
        $this->call(SharedUserTableSeeder::class);
#################### ٍ Employee Categories and Trainings
        $this->call(CategoryTrainingTableSeeder::class);
    }
}
