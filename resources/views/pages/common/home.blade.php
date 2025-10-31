@extends('layouts.base')

@section('section')
    <section>
        <div>
            <h3>Движения денежных средств</h3>
        </div>
        
        <article class="mt-4">
            @forelse ($depositHistory as $rowHistory)
                <div class="mt-2">
                    <h3>От: {{ $rowHistory->fromUser->email }}</h3>
                    <h3>К: {{ $rowHistory->toUser->email }}</h3>
                    <h3>Тип: {{ $rowHistory->type }}</h3>
                    <h3>Сумма: {{ $rowHistory->amount }}</h3>
                </div>
            @empty
                <h3>Нет доступных записей</h3>
            @endforelse
        </article>
    </section>
@endsection
