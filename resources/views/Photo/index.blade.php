@extends("layouts.master-v1")
@section("meta")
@foreach(config("app.meta") as $keys)
@for($i = 0 ; $i< count($keys);$i++) @php $meta=array();$content=array(); @endphp @foreach ($keys[$i] as $name=> $item)
    @php $meta[] =
    $name ; @endphp @endforeach
    @if(count($meta) == 1)
    <meta {{$meta[0]}}="{{ $keys[$i][$meta[0]] }}" />
    @else
    <meta {{$meta[0]}}="{{ $keys[$i][$meta[0]] }}" {{$meta[1]}}="{{ $keys[$i][$meta[1]] }}" />
    @endif @endfor @endforeach @endsection


    @section("style")
    <link rel="icon" href="{{config("app.favicon")}}" type="image/png">
    <link rel="stylesheet" href="{{asset('/assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('/assets/vendor/@fortawesome/fontawesome-pro/css/pro.min.css')}}"
        type="text/css">
    <link rel="stylesheet" href="{{asset('/assets/vendor/select-google-font/dist/selectGfont.min.css') }}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/sweetalert2/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/argon.min.css?v=1.1.0')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('/assets/css/spinner.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset("/assets/vendor/quill/dist/quill.core.css") }}" />
    <link rel="stylesheet" href="{{asset("/assets/css/custom.css") }}" />
    <link rel="stylesheet" href="{{asset("/assets/css/icon.css") }}" />
    <link rel="stylesheet" href="{{asset("/assets/vendor/color-picker-pro/dist/light.min.css") }}" />
    <link rel="stylesheet" href="{{asset('/assets/vendor/nouislider/distribute/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/croppie/croppie.css')}}">

    @endsection

    @section("bodyClass","g-sidenav-show g-sidenav-pinned")
    @section("content")

    @include(Auth::user()->role('view_path').".includes.navLeft")
    <div class="main-content" id="panel">
        @include(Auth::user()->role('view_path').".includes.navTop")
        <!-- Header -->
        <div class="header bg-{{config("app.theme_color.name")}} pb-6"
            data-theme-bg-color="{{config("app.theme_color.name")}}">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">{{Translator::phrase("student")}} </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item text-white"><i class="fas fa-home"></i></li>
                                    @if (config("pages.parameters.param1") != null && config("pages.parameters.param1")
                                    == "list")
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{Translator::phrase(config("pages.parameters.param1").'.student_study_course')}}
                                    </li>
                                    @else
                                    <li class="breadcrumb-item">
                                        <a
                                            href="{{url(config("pages.host").config("pages.path").str_replace("photo/","",config("pages.pathview"))."list")}}">
                                            {{Translator::phrase("list.student_study_course")}}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{Translator::phrase('edit.photo')}}
                                    </li>
                                    @endif
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="{{url()->current()}}" class="btn btn-secondary btn-sm"
                                data-toggle="cotent-refresh"><i class="fas fa-sync-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content container-fluid mt--6">
            @include(config("pages.parent").".includes.modal.index")
            @include(config("pages.view"))
            @include(Auth::user()->role('view_path').".includes.navFooter")
        </div>
    </div>

    @endsection

    @section("script")

    <script src="{{asset("/assets/vendor/jquery/dist/jquery.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/jquery/dist/jquery-ui.min.js")}}"></script>
    <script src="{{asset('/assets/js/custom/urlhelper.js')}}"></script>
    <script src="{{asset("/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/sweetalert2/dist/sweetalert2.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/js-cookie/js.cookie.js")}}"></script>
    <script src="{{asset("/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/select2/dist/js/select2.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/select2/dist/js/select2.dropdownPosition.js")}}"></script>


    <script src="{{asset("/assets/vendor/quill/dist/quill.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/dropzone/dist/min/dropzone.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js")}}"></script>

    <script src="{{asset("/assets/vendor/anchor-js/anchor.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/clipboard/dist/clipboard.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/holderjs/holder.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/prismjs/prism.js")}}"></script>
    <script src="{{asset('/assets/vendor/bootstrap/dist/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{asset("/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
    <script src="{{asset("/assets/vendor/validatorjs/dist/validator.js")}}"></script>
    @if (app()->getLocale() !== "en")
    <script src="{{asset("/assets/vendor/validatorjs/dist/lang/".app()->getLocale().".js")}}"></script>
    <script
        src="{{asset("/assets/vendor/bootstrap-datepicker/dist/locales/bootstrap-datepicker.".app()->getLocale().".min.js")}}">
    </script>
    @endif
    <script src="{{asset("/assets/vendor/lazyload/intersection-observer.js")}}"></script>
    <script src="{{asset("/assets/vendor/lazyload/lazyload.min.js")}}"></script>

    <script src="{{asset('/assets/js/custom/validation.js')}}"></script>
    <script src="{{asset('/assets/js/custom/replace-with-tag.js')}}"></script>
    <script src="{{asset('/assets/js/custom/form-modal.js')}}"></script>
    <script src="{{asset('/assets/js/custom/form-modal.js')}}"></script>
    <script src="{{asset('/assets/vendor/autogrow/autogrow-ui.js')}}"></script>
    <script src="{{asset('/assets/vendor/color-picker-pro/dist/default-picker.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/nouislider/distribute/nouislider.min.js')}}"></script>
    <script src="{{ asset('/assets/vendor/konva/konva.min.js')}}"></script>
    <script src="{{ asset('/assets/vendor/croppie/croppie.js')}}"></script>
    <script src="{{asset("/assets/js/custom/ajaxTableData.js")}}"></script>
    <script src="{{asset("/assets/js/argon.min.js?v=1.1.0")}}"></script>
    @endsection
