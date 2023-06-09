<div class="modal fade admin-query" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('setting.Edit Badge')}}</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="ti-close "></i></button>
            </div>
            <form method="POST" action="{{route('gamification.badges.update')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <input type="hidden" name="id" id="widgetEditId">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="editTitle">{{ __('common.Title') }}
                                    <strong
                                        class="text-danger">*</strong></label>
                                <input name="title"
                                       id="editTitle"

                                       class="primary_input_field name  "
                                       placeholder="{{ __('common.Title') }}"
                                       type="text"
                                       value="{{old('title')}}">
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="editPoint">{{ __('common.Condition') }}
                                    <strong
                                        class="text-danger">*</strong></label>
                                <input name="point"
                                       id="editPoint"

                                       class="primary_input_field name  "
                                       placeholder="{{ __('common.Condition') }}"
                                       type="number"
                                       value="{{old('point')}}">
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                       for="">{{ __('courses.Image') }}<small>(200x200)</small> </label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input filePlaceholder"
                                           type="text"
                                           id="editImage"
                                           value=""
                                           placeholder="Browse file"
                                           readonly="">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                               for="document_file_image_3">{{ __('common.Browse') }}</label>
                                        <input type="file" class="d-none fileUpload"
                                               name="image"
                                               id="document_file_image_3">
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">


                        <div class="col-lg-12 mt-30">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="primary-btn tr-bg mr-10"
                                        data-dismiss="modal">{{__('common.Cancel')}}</button>
                                <button type="submit" class="primary-btn fix-gr-bg tooltip-wrapper "
                                        data-original-title="" title="">
                                    <i class="ti-check"></i>
                                    {{__('common.Update')}} </button>

                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>
