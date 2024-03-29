<div class="row">
    <div class="col">
        @if ($response["success"])
        @foreach ($response["data"] as $year => $subjects)
        <div class="card">
            <div class="card-header">
                <h2 class="h2 font-weight-bold mb-0">
                    មុខវិជ្ជាកំពុងបង្រៀន | {{$year}}
                </h2>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($subjects as $row)
                    <div class="col-xl-6 col-md-6">
                        <a href="{{ $row["action"]["link"]}}">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">
                                                {{$row["study_subject"]["name"]}}</h5>
                                            <span class="font-weight-bold mb-0 text-muted">
                                                {{$row["lesson_count"]}}
                                                {{Translator::phrase("lesson")}}
                                            </span>
                                        </div>
                                        <div class="col-4">
                                            <img src="{{$row["study_subject"]["image"]}}" alt="" class="w-100">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>

                    @endforeach
                </div>
            </div>
            {{-- @include(config("pages.parent").".includes.teaching.includes.schedule.includes.body") --}}

        </div>
        @endforeach
        @else
        <div class="card">
            <div class="text-center p-3">
                <p class="m-0"><svg width="64" height="41" viewBox="0 0 64 41" xmlns="http://www.w3.org/2000/svg">
                        <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                            <ellipse fill="#F5F5F5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                            <g fill-rule="nonzero" stroke="#D9D9D9">
                                <path
                                    d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z">
                                </path>
                                <path
                                    d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"
                                    fill="#FAFAFA"></path>
                            </g>
                        </g>
                    </svg></p>
                <span>{{ $response["message"] }}</span>
            </div>
        </div>
        @endif
    </div>
</div>
