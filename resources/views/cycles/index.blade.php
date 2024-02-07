@extends('plantillas.navp')
@section('nav')

<div class="row p-3 mb-2 bg-secondary-subtle rounded-pill">
    <div class="col">
        <h1>
            {{ __('Cycles') }}
        </h1>
    </div>
    <div class="col text-end">
        <a href="{{ url()->previous() }}" class="me-2" role="button">
            <i class="bi bi-arrow-90deg-left fs-3"></i>
        </a>

    </div>
</div>


<div class="accordion" id="accordionExample">
    @foreach ($cycle as $cycle)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $cycle->id }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $cycle->id }}" aria-expanded="true" aria-controls="collapse{{ $cycle->id }}">
                    {{ $cycle->name }}
                </button>
            </h2>
            <div id="collapse{{ $cycle->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $cycle->id }}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{__('Name')}} </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cycle->sortedModules  as $module)
                                <tr>
                                    <td>{{ $module->name }}</td> {{-- Aquí cerré correctamente la etiqueta </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>
@endsection
