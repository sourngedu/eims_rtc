<div class="card-body p-0">
    <div class="table-responsive py-4">
        <table
            data-url="{{str_replace("add","list-datatable",config("pages.form.action.add"))}}{{config("pages.search")}}"
            class="table table-flush" data-toggle="datatable-ajax">
            <thead class="thead-light">
                <tr>
                    <th data-type="checkbox" data-key="null" width="1">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="table-check-all" data-toggle="table-checked"
                                data-checked-controls="table-checked"
                                data-checked-show-controls='["view","edit","delete"]' type="checkbox">
                            <label class="custom-control-label" for="table-check-all"></label>
                        </div>
                    </th>
                    <th data-type="text" data-key="id" width="1" class="sort" data-sort="id">
                        {{Translator::phrase("numbering")}}​</th>
                    @if (Auth::user()->role_id == 1)
                    <th data-type="text" data-key="staff.institute.name" width="1" class="sort" data-sort="institute">
                        {{Translator::phrase('institute')}}​</th>
                    @endif
                    <th data-type="text-image" data-key="name" data-url="staff.photo" class="sort" data-sort="name">
                        {{Translator::phrase("teacher")}}​</th>
                    <th data-type="text-image" data-key="study_subject.name" data-url="study_subject.image"
                        class="sort">
                        {{Translator::phrase("subject")}}​</th>

                    <th width=1 data-type="text" data-key="year">{{Translator::phrase("year")}}​</th>
                    <th width=1 data-type="option" data-key="view,edit,delete"></th>

                </tr>
            </thead>
        </table>
        <div class="d-none" id="datatable-ajax-option">
            <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a data-toggle="modal" data-target="#modal" id="btn-option-view" class="dropdown-item" href="">
                        <i class="fas fa-eye"></i> {{Translator::phrase("view")}}
                    </a>

                    <a data-toggle="modal" data-target="#modal" id="btn-option-edit" class="dropdown-item" href="">

                        <i class="fas fa-edit"></i> {{Translator::phrase("edit")}}</a>


                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item sweet-alert-reload" data-toggle="sweet-alert" id="btn-option-delete"
                        data-sweet-alert="confirm" data-sweet-id="" href="">
                        <i class="fas fa-trash"></i> {{Translator::phrase("delete")}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
