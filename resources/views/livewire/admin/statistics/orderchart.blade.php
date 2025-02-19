<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Models\Order;
use Livewire\Component;

class OrderChart extends Component
{
    public int $year;
    public array $years;

    public function mount()
    {
        $this->year = request()->year ?? now()->year;
        $this->years = range(now()->year, 2019);
    }

    public function getOrdersChartProperty()
    {
        $orders = Order::selectRaw('
            count(*) as data, 
            month(created_at) as month, 
            monthname(created_at) as month_name
        ')
            ->whereYear('created_at', $this->year)
            ->groupBy('month', 'month_name')
            ->orderBy('month', 'asc')
            ->get();

        return Chartisan::build()
            ->labels($orders->pluck('month_name')->toArray())
            ->dataset(__('Orders'), $orders->pluck('data')->toArray());
    }

    public function render()
    {
        return view('livewire.admin.statistics.order-chart');
    }
}

?>
<div>
    <x-header title="{!! __('Order Chart') !!}" separator progress-indicator>
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customRange1">{{ __('Year') }} : </label>

                            {{-- @foreach ($this->years as $year)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="year-{{ $year }}" name="year" class="custom-control-input" value="{{ $year }}" {{ $year == $this->year ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="year-{{ $year }}">{{ $year }}</label>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div id="ordersChart" style="height: 300px;" class="card-body">
                        <!-- Chart will be rendered here -->
                    </div>
                </div>
            </div>
        </div>
    </x-header>
</div>