
<div class="card-body">
    <div class="chart">
        <canvas id="chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@3.10.1/dist/chart.min.js"></script>
<script>
    
        var ctx = document.getElementById('chart').getContext('2d');
        var userChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: {!! json_encode($datasets) !!},
            },
        });
    </script>