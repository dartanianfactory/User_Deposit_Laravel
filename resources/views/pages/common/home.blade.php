@extends('layouts.base')

@section('section')
    <section>
        <div>
            <h3>Движения денежных средств</h3>
        </div>
        
        <article>
            @forelse ($depositHistory as $rowHistory)
                <div>
                    <h3>{{ $rowHistory->user->email }}</h3>
                </div>
            @empty
                <h3>Нет доступных записей</h3>
            @endforelse
        </article>
    </section>
@endsection
