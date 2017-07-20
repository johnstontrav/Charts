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
        type: "{{ $model->hbar ? 'horizontalBar' : 'bar' }}",
        data: {
            labels: [
                @foreach($model->labels as $label)
                    "{!! $label !!}",
                @endforeach
            ],
            datasets: [

                @for ($i = 0; $i < count($model->datasets); $i++)
                    {
                        fill: true,
                        label: "{!! $model->datasets[$i]['label'] !!}",
                        lineTension: 0.3,

		            borderWidth: 1,

                        @if($model->colors and count($model->colors) > $i)
                            borderColor: window.chartColors.{{ $model->colors[$i] }},
                            backgroundColor: color(window.chartColors.{{ $model->colors[$i] }}).alpha(0.5).rgbString(),
                        @else
                            $c = sprintf('#%06X', mt_rand(0, 0xFFFFFF))
                            borderColor: "{{ $c }}",
                            backgroundColor: "{{ $c }}",
                        @endif
                        data: [
                            @foreach($model->datasets[$i]['values'] as $dta)
                                {{ $dta }},
                            @endforeach
                        ],
                    },
                @endfor
            ]
        },
	    options: {
		    responsive: {{ $model->responsive || !$model->width ? 'true' : 'false' }},
		    maintainAspectRatio: false,
		    onClick: handleClick,
            @if($model->title)
		    title: {
			    display: true,
			    text: "{!! $model->title !!}",
			    fontSize: 20,
		    },
            @endif
		    scales: {
			    yAxes: [{
				    display: true,
				    ticks: {
					    beginAtZero: true,
				    },
                    @if($model->stacked)
				    stacked: true
                    @endif
			    }],
                @if($model->stacked)
			    xAxes: [{
				    stacked: true
			    }]
                @endif
		    }
	    }
    });
</script>
