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
    var data = {
        labels: [
            @foreach($model->labels as $label)
                "{!! $label !!}",
            @endforeach
        ],
        datasets: [
            {
                fill: false,
                label: "{!! $model->element_label !!}",
                lineTension: 0.3,
                @if($model->colors)
                    borderColor: "{{ $model->colors[0] }}",
                    backgroundColor: "{{ $model->colors[0] }}",
                @endif
                data: [
                    @foreach($model->values as $dta)
                        {{ $dta }},
                    @endforeach
                ],
            }
        ]
    };

    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            responsive: {{ $model->responsive || !$model->width ? 'true' : 'false' }},
            maintainAspectRatio: false,
	        onClick: handleClick,
            @if($model->title)
                title: {
                    display: true,
                    text: "{!! $model->title !!}",
                    fontSize: 20,
                }
            @endif
        }
    });
</script>
