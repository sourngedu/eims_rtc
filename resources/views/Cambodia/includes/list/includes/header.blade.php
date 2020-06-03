<div class="card-header">
    <div class="col-lg-12 p-0">
        <a href="{{config("pages.form.action.detect")}}" class="btn btn-primary" data-toggle="modal"
            data-backdrop="static" data-keyboard="false" data-target="#modal">
            <i class="fa fa-plus m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("add")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.view")}}" class="btn btn-primary disabled"
            data-backdrop="static" data-keyboard="false" data-checked-show="view" data-target="#modal">
            <i class="fa fa-eye m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("view")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.edit")}}" class="btn btn-primary disabled"
            data-backdrop="static" data-keyboard="false" data-checked-show="edit" data-target="#modal">
            <i class="fa fa-edit m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("edit")}}
            </span>
        </a>
        <a href="#" data-href="{{config("pages.form.action.delete")}}" class="btn btn-danger disabled"
            data-toggle="sweet-alert" data-sweet-alert="confirm" sweet-alert-controls-id="" data-checked-show="delete">
            <i class="fa fa-trash m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("delete")}}
            </span>
        </a>
        @isset($provinces)
            <a href="#filter" data-toggle="collapse" class="btn btn-primary" role="button" aria-expanded="false">
                <i class="fa fa-filter m-0"></i>
                <span class="d-none d-sm-inline">
                    {{Translator::phrase("filter")}}
                </span>
            </a>
        @endisset


    </div>


</div>
<div class="card-header border-0 pb-0">
    <form role="search" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-search"
        enctype="multipart/form-data">

        <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
            @isset($provinces)
                <div class="col-12 collapse mb-3 p-0 {{array_intersect(request()->all(), array_keys(['programId','courseId','generationId','yearId','semesterId'])) ? "show" : ""}}"
                    id="filter">
                    <div class="col-xl-8 col-12">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <select class="form-control" data-toggle="select" id="province" title="Simple select"
                                    data-add-url="{{$provinces["pages"]["form"]["action"]["add"]}}"  data-allow-clear="true"
                                    data-ajax="{{str_replace("add","list",$provinces["pages"]["form"]["action"]["add"])}}"
                                    data-add-text="{{ Translator::phrase("add_new_option") }}"
                                    data-placeholder="{{ Translator::phrase("choose.province") }}" name="provinceId"
                                    data-select-value="{{request('provinceId')}}"
                                    {{isset($districts) ? " data-append-to=#district data-append-url=". str_replace("add","?provinceId=",$districts["pages"]["form"]["action"]["add"]) : ""}}>
                                    @foreach($provinces["data"] as $o)
                                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                                        {{ $o["name"]}}
                                        @endforeach
                                </select>
                            </div>
                            @isset($districts)
                            <div class="col-md-6 mb-3">
                                <select {{request('districtId') ? "" : "disabled"}} class="form-control" data-toggle="select" id="district" title="Simple select"
                                    data-add-url="{{$districts["pages"]["form"]["action"]["add"]}}"  data-allow-clear="true"
                                    data-ajax="{{str_replace("add","list",$districts["pages"]["form"]["action"]["add"])}}{{request('provinceId') ? "?provinceId=".request('provinceId') : ""}}"
                                    data-add-text="{{ Translator::phrase("add_new_option") }}"
                                    data-placeholder="{{ Translator::phrase("choose.district") }}" name="districtId"
                                    data-select-value="{{request('districtId')}}"
                                    {{isset($communes) ? " data-append-to=#commune data-append-url=". str_replace("add","?districtId=",$communes["pages"]["form"]["action"]["add"]) : ""}}>
                                    @foreach($districts["data"] as $o)
                                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                                        {{ $o["name"]}}
                                        @endforeach
                                </select>
                            </div>
                            @endisset

                            @isset($communes)
                            <div class="col-md-6 mb-3">
                                <select {{request('communeId') ? "" : "disabled"}} class="form-control" data-toggle="select" id="commune" title="Simple select"
                                    data-add-url="{{$communes["pages"]["form"]["action"]["add"]}}"  data-allow-clear="true"
                                    data-ajax="{{str_replace("add","list",$communes["pages"]["form"]["action"]["add"])}}{{request('districtId') ? "?districtId=".request('districtId') : ""}}"
                                    data-add-text="{{ Translator::phrase("add_new_option") }}"
                                    data-placeholder="{{ Translator::phrase("choose.commune") }}" name="communeId"
                                    data-select-value="{{request('communeId')}}">
                                    @foreach($communes["data"] as $o)
                                    <option data-src="{{$o["image"]}}" value="{{$o["id"]}}">
                                        {{ $o["name"]}}
                                        @endforeach
                                </select>
                            </div>
                            @endisset


                            <div class="col-md-4 offset-8">
                                <button type="submit" class="btn btn-primary float-right"><i
                                        class="fa fa-filter-search"></i> {{ Translator::phrase("search_filter") }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            @endisset
        </div>
    </form>
</div>
