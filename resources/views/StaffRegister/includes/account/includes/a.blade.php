<div class="sticky-top" data-spy="affix" data-offset-top="100">
    <div class="card m-0">
        <div class="card-header">
            <div class="font-weight-600">{{Translator::phrase("account")}}</div>
            <div class="list-group list-group-flush">
                <div href="#" class="list-group-item">
                    <div class="row">
                        <div class="avatar avatar-xl rounded">
                            <img data-src="{{config("pages.form.data.photo"). '?type=original'}}" alt=""
                                id="crop-image">
                        </div>
                        <div class="col ml--2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0 text-sm">
                                        {{config("pages.form.data.first_name")}}
                                        {{config("pages.form.data.last_name")}}
                                    </h4>
                                </div>
                            </div>
                            <p class="text-sm mb-0">
                                {{config("pages.form.data.staff_institute.institute.name")}}
                            </p>
                            <p class="text-sm mb-0">
                                {{config("pages.form.data.staff_institute.designation.name")}}
                            </p>
                            @if(config("pages.form.data.account"))
                            <p class="text-sm mb-0 text-green">
                                {{Translator::phrase("has_account")}}
                                <i class="fas fa-check-circle"></i>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!config("pages.form.data.account"))
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.email")}}" class="form-control-label"
                        for="email">

                        {{ Translator:: phrase("email") }}
                        @if(config("pages.form.validate.rules.email"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger"
                            style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif

                    </label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input disabled type="email" class="form-control" id="email"
                                placeholder="{{ Translator:: phrase("email") }}"
                                value="{{config("pages.form.data.email")}}"
                                {{config("pages.form.validate.rules.email") ? "required" : ""}} name="email" />
                        </div>
                    </div>

                </div>
                <div class="col-md-4 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{ Translator:: phrase("old_password_will_be_use_if_field_password_is_not_input") }}" class="form-control-label"
                        for="password">
                        {{ Translator:: phrase("password") }}
                        @if(config("pages.form.validate.rules.password"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger"
                            style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span> @endif

                    </label>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" id="password"
                                placeholder="{{ Translator:: phrase("new_password") }}"
                                value=""
                                {{config("pages.form.validate.rules.password") ? "required" : ""}} name="password" />

                        </div>
                    </div>

                </div>

                <div class="col-md-4 mb-3">
                    <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                        title="{{config("pages.form.validate.questions.role")}}" class="form-control-label"
                        for="role">
                        {{ Translator:: phrase("role") }}
                        @if(config("pages.form.validate.rules.role"))
                        <span class="badge badge-md badge-circle badge-floating badge-danger" style="background:unset">
                            <i class="fas fa-asterisk fa-xs"></i>
                        </span>
                        @endif
                    </label>

                    <select class="form-control" data-toggle="select" id="role" title="Simple select"
                        data-url="{{$role["pages"]["form"]["action"]["add"]}}"
                        data-ajax="{{str_replace("add","list",$role["pages"]["form"]["action"]["add"])}}"
                        data-text="{{ Translator::phrase("add_new_option") }}"
                        data-placeholder="{{ Translator::phrase("choose.role") }}" name="role"
                        data-select-value="{{config("pages.form.data.role.id")}}" {{config("pages.form.validate.rules.role") ? "required" : ""}}>
                        @foreach($role["data"] as $o)
                        <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
