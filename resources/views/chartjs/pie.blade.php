@if(!$model->customId)
    @include('charts::_partials.container.canvas2')
@endif

<script type="text/javascript">
	var ctx = document.getElementById("{{ $model->id }}");

	var myChart_{{ $model->id }} = new Chart(ctx, {
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
                    @if(!empty($model->colors) AND is_array($model->colors))
                            @foreach($model->colors as $color)
                            @if (substr($color,0,1) == '#')
						'{{$color}}',
                    @else
						window.chartColors.{{$color}},
                    @endif

                    @endforeach
                    @endif
				],

				backgroundColor: [
                    @if(!empty($model->colors) AND is_array($model->colors))
                            @foreach($model->colors as $color)
                            @if (substr($color,0,1) == '#')
						'{{$color}}',
					@else
                        color(window.chartColors.{{ $color }}).alpha(0.5).rgbString(),
                    @endif
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
			onClick: function(evt) {
				var activeElement = myChart_{{ $model->id }}.getElementAtEvent(evt);
				if (activeElement.length > 0)
					$(document).trigger("chartOnCLick", [activeElement, "{{ $model->id }}", "{{ $model->key }}"]);
			},
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
