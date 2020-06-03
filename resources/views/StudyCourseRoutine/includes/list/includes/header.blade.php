<div class="card-header">
    <div class="col-lg-12 p-0">
        <a href="{{config("pages.form.action.detect")}}" class="btn btn-primary" data-toggle="modal"
            data-target="#modal" data-backdrop="static" data-keyboard="false">
            <i class="fa fa-plus m-0"></i>
            <span class="d-none d-sm-inline">
                {{Translator::phrase("add.".str_replace("-","_",config("pages.form.name")))}}
            </span>
        </a>
    </div>


</div>
<div class="card-header border-0 pb-0">
    <div class="row flex-lg-row flex-md-row flex-sm-row-reverse flex-xs-row-reverse">
        @if (request("search"))
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 mb-3">
            <div class="search text-center">
                <span class="">{{Translator::phrase("search_results")}} :</span>
                <span
                    class="{{$response["success"] ? "text-green font-weight-600" :"text-red font-weight-600"}}">{{request("search")}}</span>
            </div>
        </div>
        @endif
        <div class="{{request("search") ? "col-lg-4" : "col-lg-4 offset-lg-8"}} col-md-12 col-sm-12 col-xs-12 mb-3">
            <form role="search" class="needs-validation" method="GET" action="{{request()->url()}}" id="form-search"
                enctype="multipart/form-data">
                <div class="form-group w-100">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="dropdown" data-close="false">
                                <span class="input-group-text h-100" data-toggle="dropdown">
                                    <i class="fas fa-filter"></i>
                                </span>
                                <div
                                    class="p-2 dropdown-menu dropdown-menu-md  dropdown-menu-right dropdown-menu-arrow">
                                    @foreach (config("pages.form.validate.attributes") as $key => $item)
                                    @if ($key !== "image" && $key !== "photo")
                                    <div class="custom-control custom-checkbox">
                                        <input {{array_key_exists($key,request()->all()) ? "checked" : "" }} value="✓"
                                            {{$response["success"] ? "" : (request("search") ? "" : "disabled=disabled")}}
                                            type="checkbox" class="custom-control-input" id="customCheck-{{$key}}"
                                            name="{{$key}}">
                                        <label class="custom-control-label lh-150 d-inline"
                                            for="customCheck-{{$key}}">{{$item}}</label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="search" id="search" data-toggle="search"
                            placeholder="{{ Translator::phrase("search") }}" value="{{request("search")}}"
                            {{$response["success"] ? "" : (request("search") ? "" : "disabled=disabled")}} />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
