@php
    $user = Auth::user();
    if ($user->role_id == 2) {
        $groups = Modules\Quiz\Entities\QuestionGroup::where('active_status', 1)->where('user_id', $user->id)->latest()->get();
    } else {
        $groups = Modules\Quiz\Entities\QuestionGroup::where('active_status', 1)->latest()->get();
    }
@endphp
@if(isset($editLesson))

    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'update-course-quiz', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'question_bank']) }}

@else
    @if (permissionCheck('question-bank.store'))

        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'save-course-quiz',
        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'question_bank']) }}

    @endif
@endif

<input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="course_id" value="{{@$course->id}}">
<input type="hidden" name="category" value="{{@$course->category_id}}">
<input type="hidden" name="question_type" value="M">
@if (isset($course->subcategory_id))
    <input type="hidden" name="sub_category" value="{{@$course->subcategory_id}}">
@endif
<div class="section-white-box">
    <div class="add-visitor">
        <input type="hidden" name="chapterId" value="{{@$chapter->id}}">
        <input type="hidden" name="quiz_id" value="{{@$editLesson->lessonQuiz->id}}">
        <div class="row">
            <div class="col-lg-12">

                <div class="quiz_div">
                    <input type="hidden" name="is_quiz" value="1">


                    {{-- <div class="input-effect mt-2 pt-1 mb-30">
                           <div class="col-xl-6 ">
                            <div class="row">
                                <div class="col-md-6">

                                    <input type="radio" class="common-radio type1" data-key="{{@$key}}"
                                           id="type{{@$course->id}}1{{@$key}}" name="type"
                                           value="1" checked>
                                    <label
                                        for="type{{@$course->id}}1{{@$key}}">Existing</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" data-key="{{@$key}}" class="common-radio type2"
                                           id="type{{@$course->id}}2{{@$key}}" name="type"
                                           value="2">
                                    <label
                                        for="type{{@$course->id}}2{{@$key}}">New</label>
                                </div>
                            </div>

                        </div>
                    @if ($errors->has('quiz'))
                        <span class="invalid-feedback invalid-select" role="alert">
                <strong>{{ $errors->first('quiz') }}</strong>
            </span>
                    @endif
                </div> --}}


                    @php
                        $online_exam=$editLesson->lessonQuiz;
                    @endphp
                    {{-- @dd($online_exam) --}}
                    {{-- Start New Create --}}
                    <div class="mt-20">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <label class="primary_input_label mt-1" for=""> {{__('quiz.Quiz Title')}}
                                        <span>*</span></label>
                                    <input {{ $errors->has('title') ? ' autofocus' : '' }}
                                           class="primary_input_field name{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                           type="text" name="title" autocomplete="off"
                                           value="{{isset($online_exam)? $online_exam->title: old('title')}}">
                                    <input type="hidden" name="id"
                                           value="{{isset($online_exam)? $online_exam->id: ''}}">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-25">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <label class="primary_input_label mt-1" for="">{{__('quiz.Minimum Percentage')}}
                                        *</label>
                                    <input {{ $errors->has('title') ? ' percentage' : '' }}
                                           class="primary_input_field name{{ $errors->has('percentage') ? ' is-invalid' : '' }}"
                                           type="number" name="percentage" autocomplete="off"
                                           value="{{isset($online_exam)? $online_exam->percentage: old('percentage')}}">
                                    <input type="hidden" name="id"
                                           value="{{isset($group)? $group->id: ''}}">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('percentage'))
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('percentage') }}</strong>
                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-25">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <label class="primary_input_label mt-1" for="">{{__('quiz.Instruction')}}
                                        <span>*</span></label>
                                    <textarea {{ $errors->has('instruction') ? ' autofocus' : '' }}
                                              class="primary_input_field name{{ $errors->has('instruction') ? ' is-invalid' : '' }}"
                                              cols="0" rows="4"
                                              name="instruction">{{isset($online_exam)? $online_exam->instruction: old('instruction')}}</textarea>
                                    <span class="focus-border textarea"></span>
                                    @if($errors->has('instruction'))
                                        <span
                                            class="error text-danger"><strong>{{ $errors->first('instruction') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End New Create --}}


                </div>


            </div>
        </div>

        <div class="row mt-40">
            <div class="col-lg-12 text-center">
                <button type="submit" class="primary-btn fix-gr-bg"
                        data-toggle="tooltip">
                    <i class="ti-check"></i>
                    {{__('common.Save')}}
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
