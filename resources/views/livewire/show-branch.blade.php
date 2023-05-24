<div>
    <style>
        .singleBranch {
            display: flex;
            grid-gap: 5px;
        }

        .branchList tbody th, .branchList tbody td {
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
    <table id="" class="table  branchList "
           wire:ignore
    >
        <tbody>
        @php
            $level=1;
        @endphp
        @foreach($branches->where('parent_id',0) as $key=>$branch)
            @if(!empty($branches))
                <tr class="{{$level!=1?'collapse':''}} nastable{{$level}}   parentId0  "
                    data-id="{{$branch->id}}"
                    data-parent_id="0"
                    {{--        wire:ignore--}}
                    :key="{{$branch->id}}"
                    data-level="{{$level}}"
                >
                    <td class="singleBranch" style="padding: 0">
                        @for($i=2;$i<=$level;$i++)
                            <span class="text-white">=</span>
                        @endfor
                        @if(count($branch->childs)!=0)
                            <a class="link_value theme_btn small_btn4 btn-header-link collapsed"
                               data-toggle="collapse"
                               href="#collapseBranch{{$branch->id}}" role="button"
                               aria-expanded="false"
                               data-level="{{$level}}"
                               data-branch_id="{{$branch->id}}"
                               aria-controls="collapseBranch">
                            </a>
                        @else
                            <a href="#">
                                <i class="fas fa-circle" style="    font-size: 8px; "></i>
                            </a>
                        @endif
                        <a href="#"
                           data-id="{{$branch->id}}"
                           data-parent="0"
                           class="activeBranchCode  ">
                            <span>{{$branch->group}}</span>
                        </a>


                    </td>
                    <td class="" style="padding: 0">

                        <label class="primary_checkbox d-flex " for="branch-{{$branch->id}}">
                            <input type="checkbox" id="branch-{{$branch->id}}" name="branch[]"
                                   class=" common-checkbox checkBranch"
                                   data-code="{{$branch->code}}"
                            >
                            <span class="checkmark"></span>
                        </label>
                    </td>
                </tr>
            @endif
        @endforeach


        {{--            @foreach($branches->where('parent_id',0) as $key=>$branch)--}}
        {{--                @include('org::students._single_branch',['branch'=>$branch,'level'=>1])--}}
        {{--            @endforeach--}}

        </tbody>
    </table>

    @push('js')

        <script>

            $(document).ready(function () {

                $(document).on('keyup', '#searchBranch', function () {
                    let search = this.value;

                    let jo = $('.branchList tbody').find("tr");

                    if (this.value == "") {
                        jo.show();
                        return;
                    }
                    jo.hide();

                    jo.filter(function (i, v) {
                        var $t = $(this);
                        let title = $t.closest('tr').find('td').eq(0).text().trim();
                        let code = $t.closest('tr').find('td').eq(1).text().trim();
                        if (title.toLowerCase().indexOf(search.toLowerCase()) > -1 || code.toLowerCase().indexOf(search.toLowerCase()) > -1) {
                            return true;
                        }
                        return false;
                    }).show();
                });
            });

        </script>
        <script>
            function removeChild(parent_id, ids) {
                let child = $('.branch_' + parent_id);
                ids.push(parent_id);

                if (child.length) {
                    $(child).each(function (index) {
                        let id = $(this).data('id');
                        removeChild(id, ids);
                    });
                }
                return ids

            }

            function showPreloader() {
                $.LoadingOverlay("show");
            }

            function hidePreloader() {
                $.LoadingOverlay("hide");
            }

            function loadChildBranch(id, level, item, active) {
                let url = "{{route('org.branch-tree-list')}}"
                showPreloader()
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {id: id, level: level, active: active},
                    success: function (data) {
                        item.closest('tr').after(data);

                        hidePreloader();
                    }
                });
            }

            $(document).on('click', '.btn-header-link', function () {
                let item = $(this);
                let branch_id = item.data('branch_id');
                let level = item.data('level');
                let status = item.hasClass('collapsed');


                if (status) {
                    item.removeClass('collapsed');
                    let itemStatus = item.closest('tr').find('.checkBranch').is(":checked")
                    loadChildBranch(branch_id, level, item, itemStatus)
                } else {
                    item.addClass('collapsed');
                    let ids = [];
                    $(removeChild(branch_id, ids)).each(function (index, parent_id) {
                        $('.branch_' + parent_id).remove();
                    });

                }
            });

            $(document).on("click", ".checkBranch", function () {
                $.LoadingOverlay("show");
                let item = $(this);

                // let parent_id = item.closest('tr').data('parent_id')
                // let parentStatus = $('tr[data-id=' + parent_id + ']').find('.checkBranch').is(":checked");


                let itemStatus = item.is(":checked")


                // if (parentStatus) {
                //     itemStatus = true;
                // }
                item.attr('checked', itemStatus)

                let code = item.data('code')
                if (itemStatus) {
                    item.closest('tr').find('.activeBranchCode').addClass('active');
                } else {
                    item.closest('tr').find('.activeBranchCode').removeClass('active');

                }

                let ids = [];
                let branch_id = item.closest('tr').data('id')
                $(removeChild(branch_id, ids)).each(function (index, parent_id) {
                    let link = $('.branch_' + parent_id).find('a');
                    let input = $('.branch_' + parent_id).find('.checkBranch');

                    $(link).each(function (index) {
                        let $this = $(this);
                        if (itemStatus) {
                            $this.addClass('active');

                        } else {
                            $this.removeClass('active');
                        }
                    });
                    if (itemStatus) {
                        input.attr('checked', true)
                    } else {
                        input.attr('checked', false)
                    }

                });


            @this.branchFilter(code)
            });

            window.livewire.on('addBranchFilter', message => {
                $.LoadingOverlay("hide");

            })
        </script>

    @endpush
</div>
