<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h1 class="card-title text-muted">Season Table</h1>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-hover table-rounded overflow-hidden border border-gray-300 table-row-bordered table-row-gray-300 gy-3 gs-6 ">
					<thead>
						<tr class="fw-bold bg-gray-200">
							<th>#</th>
							<th>TEAM</th>
							<th>P</th>
							<th>W</th>
							<th>D</th>
							<th>L</th>
							<th>G</th>
							<th>AV</th>
							<th>P</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($season->teamPoints as $point_team)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>
									<div class="flex flex-row">
										<div class="symbol symbol-25px">
											<img src="https://api.dicebear.com/9.x/identicon/svg?backgroundColor={{ str_replace('#', '', $point_team->team->color) }}&seed={{ $point_team->team->name }}" alt="" />
										</div>
										<b>{{ $point_team->team->name }}</b>
									</div>
								</td>
								<td>{{ $point_team->wins + $point_team->losses + $point_team->draws }}</td>
								<td>{{ $point_team->wins }}</td>
								<td>{{ $point_team->losses }}</td>
								<td>{{ $point_team->draws }}</td>
								<td>{{ $point_team->total_score }}:{{ $point_team->total_enemy_score }}</td>
								<td>{{ $point_team->total_score - $point_team->total_enemy_score }}</td>
								<td>{{ $point_team->total_points }}</td>
							</tr>
						@empty
                            <tr>
                                <td colspan="9" class="text-center">No data available</td>
                            </tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
