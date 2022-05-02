<div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
            <p class="text-center">
                <i class="fas fa-caret-left mr-2" style="cursor:pointer;" wire:click="sumLessYear('less')"></i>
                    <strong>{{ '1 Ene ,'.$anio.' - '.'31 Dic ,'.$anio }}</strong>
                <i class="fas fa-caret-right ml-2" style="cursor:pointer;" wire:click="sumLessYear('sum')"></i>
            </p>

            <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas wire:ignore.self id="salesChart" height="180" style="height: 180px;"></canvas>
            </div>
            <!-- /.chart-responsive -->
            </div>
        </div>
    <!-- /.row -->
    </div>
    <!-- ./card-body -->
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <span class="description-percentage text-{{ $venta_total->venta > $gastos_total->gastos ? 'success' : ( $venta_total->venta == $gastos_total->gasto ? 'warning' : 'danger' ) }}">
                    <!-- <i class="fas fa-caret-up"></i> 17% -->
                    @if($venta_total->venta > $gastos_total->gastos)
                        <i class="fas fa-caret-up"></i>
                    @elseif($venta_total->venta == $gastos_total->gastos)
                        <i class="fas fa-caret-left"></i>
                    @else
                        <i class="fas fa-caret-down"></i>
                    @endif
                    @if($gastos_total->gastos > 0) 
                        {{ number_format(( $venta_total->venta / $gastos_total->gastos) * 100, 2) }}%
                    @else
                        0% 
                    @endif
                    </span>
                    <h5 class="description-header">${{$venta_total->venta}}</h5>
                    <span class="description-text">TOTAL VENTA</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <span class="description-percentage text-{{ $gastos_total->gastos > $venta_total->venta  ? 'danger' : ( $venta_total->venta == $gastos_total->gasto ? 'warning' : 'success' ) }}">
                    <!-- <i class="fas fa-caret-left"></i> 0%-->
                    @if($gastos_total->gastos > $venta_total->venta)
                        <i class="fas fa-caret-up"></i>
                    @elseif($venta_total->venta == $gastos_total->gastos)
                        <i class="fas fa-caret-left"></i>
                    @else
                        <i class="fas fa-caret-down"></i> 
                    @endif
                    
                    @if($gastos_total->gastos > 0) 
                        {{ number_format(( ($gastos_total->gastos - $venta_total->venta) / $gastos_total->gastos ) * 100, 2) }}%
                    @else
                        0% 
                    @endif 
                    </span> 
                    <h5 class="description-header">${{$gastos_total->gastos}}</h5>
                    <span class="description-text">TOTAL GASTOS</span>
                </div>
                <!-- /.description-block -->
            </div>
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <?php $utilidad = $gastos_total->gastos > 0 ? number_format(( $venta_total->venta - $gastos_total->gastos), 2) : 0; ?>
                    <span class="description-percentage text-{{ $utilidad > 0 ? 'success' : ( $utilidad == 0 ? 'warning' : 'danger' ) }}">
                        <!-- <i class="fas fa-caret-up"></i> 17% -->
                        @if($utilidad > 0)
                            <i class="fas fa-caret-up"></i>
                        @elseif($utilidad == 0)
                            <i class="fas fa-caret-left"></i>
                        @else
                            <i class="fas fa-caret-down"></i>
                        @endif
                    </span>
                    <h5 class="description-header">${{$utilidad}}</h5>
                    <span class="description-text">UTILIDAD</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-3 col-6">
                <div class="description-block border-right">
                    <span class="description-percentage text-{{ $produccion_total->produccion > 0  ? 'success' : 'warning' }}">
                    <!-- <i class="fas fa-caret-up"></i> 20% -->
                    @if($produccion_total->produccion > 0)
                        <i class="fas fa-caret-up"></i>
                    @else
                        <i class="fas fa-caret-left"></i>
                    @endif 
                    </span>
                    <h5 class="description-header">{{$produccion_total->produccion}} lb</h5>
                    <span class="description-text">TOTAL PRODUCCIÓN</span>
                </div>
                <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <!-- <div class="col-sm-3 col-6">
            <div class="description-block">
                <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                <h5 class="description-header">1200</h5>
                <span class="description-text">GOAL COMPLETIONS</span>
            </div>
            </div> -->
        </div>
        <!-- /.row -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer type="text/javascript">

      const salesChartCanvas = document.getElementById('salesChart').getContext('2d')

      const salesChartData = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [
          {
            label: 'Gastos',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointColor: '#3b8bba',
            fill: false,
            tension: 0.1,
            data: @json($datos_gastos)
          },
          {
            label: 'Ventas',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointColor: 'rgba(210, 214, 222, 1)',
            fill: false,
            tension: 0.1,
            data: @json($datos_ventas)
          }
        ]
      }

      const salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
      }

      const salesChart = new Chart(salesChartCanvas, {
          type: 'line',
          data: salesChartData,
          options: salesChartOptions
        }
      )

      window.livewire.on('renderChart', (data) => {
        
        salesChart.data = data
        salesChart.update()
    })
    </script>
</div>
