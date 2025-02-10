@foreach ($season->weeks as $week)
	<div class="col-md-6">
		<div class="card">
			<div class="card-header ribbon">
				<div class="d-flex align-items-center flex-row gap-2">
					<h3 class="card-title">
						{{ $week->week_date->format('F, Y') }}
					</h3>
					<div class="">{{ $week->week }}. Week of Season</div>
				</div>
				<div class="ribbon-label {{ $week->period == 1 ? 'bg-info' : 'bg-primary' }}">{{ $week->period }}. Period</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table-striped table-hover table-rounded table-row-bordered table-row-gray-300 gy-3 gs-6 table overflow-hidden border border-gray-300">
						<tbody>
							@foreach ($week->matches as $match)
								<tr class="{{ $match->status == 'completed' ? 'bg-primary-subtle' : '' }}">
									<td class="fw-semibold">
										{{ $match->final_date->format('d F Y') }}
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
											</div>
											<div class="d-flex align-items-center flex-row gap-1">
												<div class="symbol symbol-20px">
													<img src="https://api.dicebear.com/9.x/identicon/svg?backgroundColor={{ str_replace('#', '', $match->awayTeam->color) }}&seed={{ $match->awayTeam->name }}" alt="" />
												</div>
												<span class="text-muted">
													<b class="text-black">{{ $match->awayTeam->name }}</b>
													(home)
												</span>
											</div>
										</div>
									</td>
									<td>
										<div class="d-flex flex-column gap-2">
											<span>
												{{ $match->home_score == -1 ? '-' : $match->home_score }}
											</span>
											<span>
												{{ $match->away_score == -1 ? '-' : $match->away_score }}
											</span>
										</div>
									</td>
									<td class="fs-5 fw-bolder">
										{{ $match->final_date->format('H:i') }}
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endforeach
