@if(!$model->customId)
    @include('charts::_partials.container.canvas2')
@endif

<script type="text/javascript">
	var ctx = document.getElementById("{{ $model->id }}");

	function handleClick(evt) {
		var activeElement = myChart.getElementAtEvent(evt);
		if (activeElement.length >0)
		$( document ).trigger( "chartOnCLick",  [activeElement,"{{ $model->id }}","{{ $model->key }}"] );
	}

	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: [
                @foreach($model->labels as $label)
					"{!! $label !!}",
                @endforeach
			],
			datasets: [{
				data: [
                    @foreach($model->values as $dta)
                    {{ $dta }},
                    @endforeach
				],
				borderColor: [
                    @if($model->colors)
                            @foreach($model->colors as $color)
						window.chartColors.{{$color}},
                    @endforeach
                    @endif
				],

				backgroundColor: [
					@if($model->colors)
                            @foreach($model->colors as $color)
                                color(window.chartColors.{{ $color }}).alpha(0.5).rgbString(),
                    @endforeach
                            @else

                            @foreach($model->values as $dta)
						"{{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}",
                    @endforeach
                    @endif
				],

				borderWidth: 1,
			}]
		},
		options: {
			responsive: {{ $model->responsive || !$model->width ? 'true' : 'false' }},
			maintainAspectRatio: false,
			legend: {
				position: 'top',
			},
			onClick: handleClick,
            @if($model->title)
			title: {
				display: true,
				text: "{!! $model->title !!}",
				fontSize: 23,
	            fontColor: '#9f9f9f'
			}
            @endif
		}
	});
</script>
