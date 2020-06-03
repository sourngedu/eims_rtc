<div class="card m-0">
    <div class="card-header py-2 px-3">
        <label class="label-arrow label-primary label-arrow-right">
            A
        </label>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-row">
                    @csrf
                    @if (request()->segment(3) == "view")
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="id">
                            {{ Translator:: phrase("numbering") }}
                        </label>
                        <span class="form-control" id="id" name="id"
                            value="{{config("pages.form.data.id")}}">{{config("pages.form.data.id")}}</span>
                    </div>
                    @endif
                </div>

                @if (Auth::user()->role_id == 1)
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label data-toggle="tooltip" rel="tooltip" data-placement="top"
                            title="{{config("pages.form.validate.questions.institute")}}" class="form-control-label"
                            for="institute">

                            {{ Translator:: phrase("institute") }}

                            @if(config("pages.form.validate.rules.institute"))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset">
                                <i class="fas fa-asterisk fa-xs"></i>
                            </span>
                            @endif
                        </label>

                        <select class="form-control" data-toggle="select" id="institute" title="Simple select"
                            data-url="{{$institute["pages"]["form"]["action"]["add"]}}"
                            data-ajax="{{str_replace("add","list",$institute["pages"]["form"]["action"]["add"])}}"
                            data-text="{{ Translator::phrase("add_new_option") }}"
                            data-placeholder="{{ Translator::phrase("choose.institute") }}" name="institute"
                            data-select-value="{{config("pages.form.data.institute.id")}}"
                            {{config("pages.form.validate.rules.institute") ? "required" : ""}}>
                            @foreach($institute["data"] as $o)
                            <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">{{ $o["name"]}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @else
                    <input type="hidden" name="institute" value="{{Auth::user()->institute_id}}">
                @endif

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="name">
                            {{ Translator:: phrase("quiz_name") }}

                            @if(array_key_exists("name",config("pages.form.validate.rules"))) <span
                                class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="{{ Translator::phrase("quiz_name") }}"
                            value="{{config("pages.form.data.name")}}"
                            {{(array_key_exists("name", config("pages.form.validate.rules"))) ? "required" : ""}} />

                    </div>
                </div>

                <div class="form-row">
                    @if (config('app.languages'))
                    @foreach (config('app.languages') as $lang)
                    <div class="col-md-6 mb-3">
                        <label class="form-control-label" for="{{$lang["code_name"]}}">
                            {{ Translator:: phrase(str_replace("-","_",config("pages.form.name")).".as.".$lang["translate_name"]) }}

                            @if(array_key_exists($lang["code_name"],config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>
                        <input type="text" class="form-control" name="{{$lang["code_name"]}}"
                            id="{{$lang["code_name"]}}"
                            placeholder="{{ Translator::phrase(str_replace("-","_",config("pages.form.name")).".as.".$lang["translate_name"]) }}"
                            value="{{config("pages.form.data.".$lang["code_name"])}}"
                            {{(array_key_exists($lang["code_name"], config("pages.form.validate.rules"))) ? "required" : ""}} />
                    </div>
                    @endforeach
                    @endif
                </div>




                <div class="form-row">

                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="description">
                            {{ Translator:: phrase("description") }}

                            @if(array_key_exists("description",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif

                        </label>

                        <div class="form-group">
                            <div class="input-group input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info"></i></span>
                                </div>
                                <textarea class="form-control" id="description"
                                    placeholder="{{ Translator:: phrase("description") }}" value=""
                                    {{(array_key_exists("description", config("pages.form.validate.rules"))) ? "required" : ""}}
                                    name="description">{{config("pages.form.data.description")}}</textarea>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-control-label" for="image">
                            {{ Translator:: phrase("image") }}
                            @if(array_key_exists("image",config("pages.form.validate.rules")))
                            <span class="badge badge-md badge-circle badge-floating badge-danger"
                                style="background:unset"><i class="fas fa-asterisk fa-xs"></i></span>
                            @endif
                        </label>
                        <div class="dropzone dropzone-single" data-toggle="dropzone"
                            data-dropzone-url="{{config("pages.form.data.image")}}?type=original">
                            <div class="fallback">
                                <div class="custom-file">
                                    <input type="file" placeholder="{{ Translator:: phrase("drop_image_here") }}"
                                        class="custom-file-input" id="dropzoneBasicUpload" name="image"
                                        {{(array_key_exists("image", config("pages.form.validate.rules"))) ? "required" : ""}} />
                                    <label data-toggle="tooltip" rel="tooltip" data-placement="top" title="123"
                                        class="custom-file-label"
                                        for="dropzoneBasicUpload">{{ Translator:: phrase("choose.image") }}</label>
                                </div>
                            </div>

                            <div class="dz-preview dz-preview-single">
                                <div class="dz-preview-cover">
                                    <img class="dz-preview-img"
                                        data-src="{{config("pages.form.data.image")}}?type=original" alt
                                        data-dz-thumbnail>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                @if (!config("pages.form.data"))
                <div class="form-row">
                    <div class="form-name">
                        <div class="custom-control custom-checkbox mb-3">

                            <label class="form-control-label"><i class="fas fa-sticky-note "></i>
                                {{ Translator:: phrase("note") }} </label>
                            <br>
                            <label class="form-control-label">
                                <span class="badge badge-md badge-circle badge-floating badge-danger"
                                    style="background:unset">
                                    <i class="fas fa-asterisk fa-xs"></i></span> <span>
                                    {{ Translator:: phrase("field_required") }}</span> </label>


                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
