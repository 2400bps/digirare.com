<div class="card">
    <div class="card-header">
        <span class="lead font-weight-bold">
            Trade History
            <small class="ml-1 text-muted">{{ number_format($order_matches->count()) }} Found</small>
        </span>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th scope="col" style="width: 50px">#</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">Source</th>
                    <th scope="col">Traded</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order_matches as $match)
                <tr>
                    <th scope="row">{{ $order_matches->count() - $loop->index }}.</th>
                    <td>
                    @if($card->token->divisible)
                        {{ $match->forward_asset === $card->name ? $match->forward_quantity_normalized : $match->backward_quantity_normalized }}
                    @else
                        {{ $match->forward_asset === $card->name ? number_format($match->forward_quantity_normalized) : number_format($match->backward_quantity_normalized) }}
                    @endif
                        {{ $card->name }}
                    </td>
                    <td>{{ $match->trading_price_normalized }} {{ explode('/', $match->trading_pair_normalized)[1] }}</td>
                    <td>{{ $match->forward_asset === $card->name ? $match->backward_quantity_normalized : $match->forward_quantity_normalized }} {{ explode('/', $match->trading_pair_normalized)[1] === $card->name ? explode('/', $match->trading_pair_normalized)[0] : explode('/', $match->trading_pair_normalized)[1] }}</td>
                    <td><a href="{{ route('collectors.show', ['collector' => $match->tx1_address]) }}">{{ str_limit($match->tx1_address, 8) }}</a></td>
                    <td>{{ $match->confirmed_at->diffForHumans() }}</td>
                </tr>
                @endforeach
                @if($order_matches->count() === 0)
                <tr>
                    <td colspan="5" class="text-center"><em>No Trades Found</em></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>