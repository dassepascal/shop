<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Order;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ManageOrders;

new 
#[Title('Orders')] 
#[Layout('components.layouts.admin')] 
class extends Component
{
    use Toast, WithPagination, ManageOrders;

    public int $perPage = 10;
    public string $search = '';
    public bool $paginationOrders = true;

    public function deleteOrder(Order $order): void
    {
        $order->delete();
        $this->success(__('Order deleted successfully.'));
    }

    private function getSalesByMonth(): array
    {
        $sales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', now()->year)
            ->whereHas('state', function ($query) {
                $query->where('name', '!=', 'Annulé') // Exclure les annulées
                      ->where('name', '!=', 'Remboursé'); // Exclure les remboursées
                    //   ->where('name', '!=', 'Invoiced'); // Exclure les facturés
                    //   ->where('name', '!=', 'En cours'); // Exclure les en cours
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->all();

            // Remplir les mois manquants avec 0
        $monthlySales = array_fill(1, 12, 0);
        foreach ($sales as $month => $total) {
            $monthlySales[$month] = (float) $total;
        }

        return [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            'data' => array_values($monthlySales),
        ];
    }

    // Nouvelle méthode pour calculer les stats de ventes
    private function getSalesStats(): array
    {
        $salesThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total'); // Assumant qu'il y a un champ 'total' dans Order

        $salesLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total');

        // Déterminer la tendance
        $isTrendingUp = $salesThisMonth > $salesLastMonth;
        
        return [
            'salesThisMonth' => number_format($salesThisMonth, 2),
            'salesTrendIcon' => $isTrendingUp ? 'o-arrow-trending-up' : 'o-arrow-trending-down',
            'salesTrendClass' => $isTrendingUp ? 'text-green-500' : 'text-orange-500',
            'salesTrendColor' => $isTrendingUp ? 'text-green-500' : 'text-orange-500',
            'salesTooltip' => $isTrendingUp ? __('Sales are up!') : __('Sales are down')
        ];
    }

    private function getCancelledOrdersStats(): array
    {
        // Filtrer les commandes annulées via la relation state
        $cancelledThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('state', function ($query) {
                $query->where('name', 'Annulé'); // Ajustez 'cancelled' selon votre valeur réelle
            })
            ->sum('total');

        $cancelledLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereHas('state', function ($query) {
                $query->where('name', 'Annulé'); // Ajustez 'cancelled' selon votre valeur réelle
            })
            ->sum('total');

        $isTrendingUp = $cancelledThisMonth > $cancelledLastMonth;

        return [
            'cancelledThisMonth' => number_format($cancelledThisMonth, 2),
            'cancelledTrendIcon' => $isTrendingUp ? 'o-arrow-trending-up' : 'o-arrow-trending-down',
            'cancelledTrendClass' => $isTrendingUp ? 'text-red-500' : 'text-red-500',
            'cancelledTrendColor' => $isTrendingUp ? 'text-red-500' : 'text-red-500',
            'cancelledTooltip' => $isTrendingUp ? __('More cancellations this month') : __('Fewer cancellations this month')
        ];
    }

    private function getRefundedOrdersStats(): array
    {
        // Filtrer les commandes remboursées via la relation state
        $refundedThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('state', function ($query) {
                $query->where('name', 'refunded'); // Ajustez 'refunded' selon votre valeur réelle
            })
            ->sum('total');

        $refundedLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereHas('state', function ($query) {
                $query->where('name', 'refunded'); // Ajustez 'refunded' selon votre valeur réelle
            })
            ->sum('total');

        $isTrendingUp = $refundedThisMonth > $refundedLastMonth;

        return [
            'refundedThisMonth' => number_format($refundedThisMonth, 2),
            'refundedTrendIcon' => $isTrendingUp ? 'o-arrow-trending-up' : 'o-arrow-trending-down',
            'refundedTrendClass' => $isTrendingUp ? 'text-red-500' : 'text-orange-500',
            'refundedTrendColor' => $isTrendingUp ? 'text-red-500' : 'text-orange-500',
            'refundedTooltip' => $isTrendingUp ? __('More refunds this month') : __('Fewer refunds this month')
        ];
    }



    public function with(): array
	{
        $salesStats = $this->getSalesStats();
        $cancelledStats = $this->getCancelledOrdersStats();
        $refundedStats = $this->getRefundedOrdersStats();
        $salesData = $this->getSalesByMonth();
		return [
            'orders' => Order::with('user', 'state', 'addresses')
                ->orderBy(...array_values($this->sortBy))
                ->when($this->search, function (Builder $q)
                {
                    $q->where('reference', 'like', "%{$this->search}%")
                        ->orWhereRelation('addresses', 'company', 'like', "%{$this->search}%")
                        ->orWhereRelation('state', 'name', 'like', "%{$this->search}%");
                })
                ->paginate($this->perPage),
			'headersOrders' => $this->headersOrders(),
            'salesThisMonth' => $salesStats['salesThisMonth'],
            'salesTrendIcon' => $salesStats['salesTrendIcon'],
            'salesTrendClass' => $salesStats['salesTrendClass'],
            'salesTrendColor' => $salesStats['salesTrendColor'],
            'salesTooltip' => $salesStats['salesTooltip'],
            'cancelledThisMonth' => $cancelledStats['cancelledThisMonth'],
            'cancelledTrendIcon' => $cancelledStats['cancelledTrendIcon'],
            'cancelledTrendClass' => $cancelledStats['cancelledTrendClass'],
            'cancelledTrendColor' => $cancelledStats['cancelledTrendColor'],
            'cancelledTooltip' => $cancelledStats['cancelledTooltip'],
            'refundedThisMonth' => $refundedStats['refundedThisMonth'],
            'refundedTrendIcon' => $refundedStats['refundedTrendIcon'],
            'refundedTrendClass' => $refundedStats['refundedTrendClass'],
            'refundedTrendColor' => $refundedStats['refundedTrendColor'],
            'refundedTooltip' => $refundedStats['refundedTooltip'],
            'salesLabels' => $salesData['labels'],
            'salesData' => $salesData['data'],
		];
	}
   
}; ?>


<div>
    <x-header title="{{ __('Orders') }}" separator progress-indicator >
        <x-slot:actions>
            <x-input 
                placeholder="{{ __('Search...') }}" 
                wire:model.live.debounce="search" 
                clearable
                icon="o-magnifying-glass" 
            />
            <x-button 
                icon="s-building-office-2" 
                label="{{ __('Dashboard') }}" 
                class="btn-outline lg:hidden" 
                link="{{ route('admin') }}" 
            />
        </x-slot:actions>
    </x-header>
    
    <div class="flex space-x-4 mb-8" >
       
        
        <x-stat
            title="{{ __('Sales') }}"
            description="{{ __('This month') }}"
            value="{{ $salesThisMonth }}"
            icon="{{ $salesTrendIcon }}"
            class="{{ $salesTrendClass }}"
            color="{{ $salesTrendColor }}"
            tooltip-right="{{ $salesTooltip }}" />

            <x-stat
            title="{{ __('Cancelled Orders') }}"
            description="{{ __('This month') }}"
            value="{{ $cancelledThisMonth }}"
            icon="{{ $cancelledTrendIcon }}"
            class="{{ $cancelledTrendClass }}"
            color="{{ $cancelledTrendColor }}"
            tooltip-right="{{ $cancelledTooltip }}" />

            <x-stat
            title="{{ __('Refunded Orders') }}"
            description="{{ __('This month') }}"
            value="{{ $refundedThisMonth }}"
            icon="{{ $refundedTrendIcon }}"
            class="{{ $refundedTrendClass }}"
            color="{{ $refundedTrendColor }}"
            tooltip-right="{{ $refundedTooltip }}" />
            
        <!-- Autres stats... -->
    </div>

      <!-- Graphique des ventes -->
      <div class="mt-6 mb-8">
        <x-card title="{{ __('Sales by Month') }}">
            <canvas id="salesChart" height="100"></canvas>
        </x-card>
    </div>
    
    @include('livewire.admin.orders.table')
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($salesLabels),
                    datasets: [{
                        label: 'Ventes (€)',
                        data: @json($salesData),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Montant (€)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Mois'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Mettre à jour le graphique quand les données changent
            Livewire.on('updateChart', () => {
                salesChart.data.labels = @json($salesLabels);
                salesChart.data.datasets[0].data = @json($salesData);
                salesChart.update();
            });
        });
    </script>
    @endpush
</div>
</div>