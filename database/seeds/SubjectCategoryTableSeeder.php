<?php


use App\Models\TrainingContents\SubjectCategory;
use Illuminate\Database\Seeder;

class SubjectCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubjectCategory::create([
            'name'=>'التغطية الاعلامية',
        ]);
        SubjectCategory::create([
            'name'=>'الدعم النفسي',
        ]);
        SubjectCategory::create([
            'name'=>'إدارة الحالة',
        ]);
        SubjectCategory::create([
        'name'=>'الدعم القانوني',
        ]);
        SubjectCategory::create([
            'name'=>'IT',
        ]);
//        SubjectCategory::create([
//            'name'=>'فيزياء',
//        ]);
//        SubjectCategory::create([
//        'name'=>'تكامل و تفاضل',
//        ]);
//        SubjectCategory::create([
//            'name'=>'جبر وهندسة',
//        ]);
//        SubjectCategory::create([
//            'name'=>'فلسفة',
//        ]);
//        SubjectCategory::create([
//        'name'=>'تاريخ اسلامي',
//        ]);
//        SubjectCategory::create([
//            'name'=>'بسكوت ابو ولد',
//        ]);
//        SubjectCategory::create([
//            'name'=>'بفك عدنان ولينا',
//        ]);
    }
}
