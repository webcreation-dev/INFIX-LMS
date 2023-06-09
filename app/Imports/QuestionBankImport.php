<?php

namespace App\Imports;


use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionBankMuOption;

class QuestionBankImport implements ToModel, WithHeadingRow
{
    public $group, $category, $subcategory;

    public function __construct($group, $category, $subcategory = null)
    {
        $this->group = $group;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function model(array $row)
    {
        $options = [];
        $regex = 'option_';
        foreach ($row as $key => $value) {
            if (str_starts_with($key, $regex)) {
                $options[str_replace($regex, '', $key)] = $value;
            }
        }

        $correct = trim($row['correct_ans'] ?? '');
        $correct_options = explode('|', $correct);


        $total = 0;


        $question = new QuestionBank([
            'question' => $row['question'],
            'marks' => $row['mark'],
            'type' => $row['type'],
            'q_group_id' => $this->group,
            'category_id' => (int)$this->category,
            'sub_category_id' => (int)$this->subcategory,
            'user_id' => Auth::user()->id,
            'number_of_option' => $total,
        ]);
        $question->save();
        if ($row['type'] == "M") {
            $i = 1;
            foreach ($options as $key => $option) {
                if (!empty($option)) {
                    $online_question_option = new QuestionBankMuOption();
                    $online_question_option->question_bank_id = $question->id;
                    $online_question_option->title = $option;
                    if (in_array($key, $correct_options)) {
                        $online_question_option->status = 1;
                    } else {
                        $online_question_option->status = 0;
                    }
                    $online_question_option->save();

                    $question->number_of_option = $i;
                    $question->save();
                    $i++;
                }

            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
