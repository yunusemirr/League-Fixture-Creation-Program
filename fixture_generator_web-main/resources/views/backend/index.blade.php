@extends('backend.layout.root')


@section('content')
    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-gradient-to-r from-sky-500 via-sky-600 to-sky-200 p-0">
                <div class="card-body p-4">
                    <div class="flex flex-row justify-between items-center">
                        <h1 class="text-white">{{ Str::title($selectedSeason->name) }}</h1>
                        <div class="min-w-xl-200px">
                            <select data-control="select2" class="form-select" data-placeholder="Select season...">
                                <option value=""></option>
                                @foreach($seasons as $season)
                                    <option @selected($selectedSeason->id == $season->id) value="{{ $season->id }}">{{ $season->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card shadow">
                <div class="card-header">
                    <h1 class="card-title">{{ Str::title($type) }}</h1>
                    <div class="card-toolbar">
                        <div class="flex flex-row gap-2">
                            <a href="#" data-type-select="standings" class="btn {{ $type == "standings" ? 'btn-primary' : 'btn-secondary' }} btn-sm">Standings</a>
                            <a href="#" data-type-select="fixture" class="btn {{ $type == "fixture" ? 'btn-primary': 'btn-secondary' }} btn-sm">Fixture</a>
                        </div>
                    </div>
                </div>
                @if($type == "fixture")
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <select data-change-week class="form-select form-select-solid" data-control="select2" data-placeholder="Select week">
                                <option value=""></option>
                                @foreach($selectedSeason->weeks as $week)
                                    <option @selected($selectedWeek->id == $week->id) value="{{ $week->id }}">{{ $week->date->format('d F Y') }} Week</option>
                                @endforeach
                            </select>
                        </div>

                        @foreach($selectedWeek->matches->groupBy('match_datetime') as $date => $matches)
                            <div class="col-12">
                                <div class="card card-dashed h-full">
                                    <div class="card-header">
                                        <h2 class="card-title">
                                            {{ $date }}
                                        </h2>
                                    </div>
                                    <div class="card-body h-full">
                                        @foreach($matches as $match)
                                            <div class="flex flex-row justify-between mb-2">
                                                <div class="border-2 rounded-xl p-2 aspect-square flex items-center justify-center font-bold text-primary">
                                                    20:00
                                                </div>
                                                <div class="flex flex-row items-center gap-2">
                                                    <span>{{ $match->homeTeam->name }}</span>
                                                    <b>-</b>
                                                    <span>{{ $match->awayTeam->name }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Team</th>
                                    <th>O</th>
                                    <th>G</th>
                                    <th>B</th>
                                    <th>M</th>
                                    <th>A</th>
                                    <th>Y</th>
                                    <th>AV</th>
                                    <th>P</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="color: {{ $team->color }}">{{ $team->name }}</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="flex flex-col justify-center items-center gap-2 text-neutral-600">
                        <div class="">
                            <i class="fas fa-champagne-glasses fs-2"></i>
                        </div>
                        <span class="text-xl font-semibold">{{ $selectedSeason->name }}</span>
                        <span class="text-lg font-medium">*{{ $teams->count() }} Teams</span>
                        <span class="text-lg font-bold">Start: {{ $selectedSeason->start_date->format('d F Y') }}</span>
                        <span class="text-lg font-bold">End: {{ $selectedSeason->end_date->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    @vite('resources/css/app.css')
@endpush

@push('js')
    <script>
       $(document).ready(function () {
        console.log("sa");
         $(document).on("click","[data-type-select]", function (e) {
            console.log("dsadas");
            e.preventDefault();
            const type = $(this).data("type-select");
            const url = new URL(window.location.href);
            url.searchParams.set("type", type);
            window.location.href = url.toString();
        });

        $(document).on("change","[data-change-week]", function () {
            const week = $(this).val();
            const url = new URL(window.location.href);
            url.searchParams.set("week", week);
            window.location.href = url.toString();
        });
       });
    </script>
@endpush
