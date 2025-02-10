<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h1 class="card-title text-muted">Season Matches</h1>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table-striped table-hover table-rounded table-row-bordered table-row-gray-300 gy-3 gs-6 table overflow-hidden border border-gray-300">
					<tbody>
						@forelse ($flat_matches as $match)
							<tr>
								<td>
									<b>
										{{ $match->final_date->format('d F Y') }}
									</b>
								</td>
								<td>
									<div class="d-flex flex-column gap-2">
										<div class="d-flex align-items-center flex-row gap-1">
											<div class="symbol symbol-20px">
												<img src="https://api.dicebear.com/9.x/identicon/svg?backgroundColor={{ str_replace('#', '', $match->homeTeam->color) }}&seed={{ $match->homeTeam->name }}" alt="" />
											</div>
											<span class="text-muted">
												<b class="text-black">{{ $match->homeTeam->name }}</b>
												(home)
											</span>
                                            <span>
                                                @switch($match->winner_str)
                                                    @case("home")
                                                        +3 points
                                                        @break
                                                    @case('draw')
                                                        +1 point
                                                        @break
                                                    @default
                                                        +0 point
                                                @endswitch
                                            </span>
										</div>
										<div class="d-flex align-items-center flex-row gap-1">
											<div class="symbol symbol-20px">
												<img src="https://api.dicebear.com/9.x/identicon/svg?backgroundColor={{ str_replace('#', '', $match->awayTeam->color) }}&seed={{ $match->awayTeam->name }}" alt="" />
											</div>
											<span class="text-muted">
												<b class="text-black">{{ $match->awayTeam->name }}</b>
												(away)
											</span>
                                            <span>
                                                @switch($match->winner_str)
                                                    @case("away")
                                                        +3 points
                                                        @break
                                                    @case('draw')
                                                        +1 point
                                                        @break
                                                    @default
                                                        +0 point
                                                @endswitch
                                            </span>
										</div>
									</div>
								</td>
								<td>
									<div class="d-flex flex-column gap-2">
										<span class="{{ $match->winner_str == "home" ? 'text-primary' : '' }}">
											{{ $match->home_score == -1 ? '-' : $match->home_score }}
										</span>
										<span class="{{ $match->winner_str == "away" ? 'text-primary' : '' }}">
											{{ $match->away_score == -1 ? '-' : $match->away_score }}
										</span>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="2">No Data</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
