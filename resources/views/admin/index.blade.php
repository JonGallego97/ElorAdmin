@extends('admin.plantillas.nav')
@section('nav')

<div class="row align-items-md-stretch mb-4">
    <div class="col-md-4">
        <a href="{{ route('admin.students.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('Students')}}</h2>

                <div class="row align-items-center ">
                    <div class="col md-8">
                        <p><h5><b>{{__('Total students')}} {{ $students }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/alumno/black.png') }}" style="width: 100px" alt="Student">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.teachers.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('Teachers')}}</h2>
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <p><h5><b>{{__('Total teachers')}} {{ $teachers }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/profesor/black.png') }}" style="width: 100px" alt="Teacher">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.personal.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('Personal')}}</h2>
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <p><h5><b>{{__('TotalPersonal')}} {{ $personal }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/profesor/black.png') }}" style="width: 100px" alt="Teacher">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>
</div>
<div class="row align-items-md-stretch mb-4">
    <div class="col-md-6">
        <a href="{{ route('admin.departments.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('Departments')}}</h2>
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <p><h5><b>{{__('Total departments')}} {{ $departments }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/departamento/black.png') }}" style="width: 100px" alt="Department">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('admin.cycles.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('Cycles')}}</h2>
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <p><h5><b>{{__('Total cycles')}} {{ $cycles }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/ciclo/black.png') }}" style="width: 100px" alt="Cycle">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>
</div>
<div class="row align-items-md-stretch mb-4">
    <div class="col-md-6">
        <a href="{{ route('admin.withoutRole.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('UsersWithoutRole')}}</h2>
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <p><h5><b>{{__('Total')}} {{__('UsersWithoutRole')}}: {{ $usersWithoutRole }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/role/black.png') }}" style="width: 100px" alt="User">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('admin.modules.index') }} " style="text-decoration: none; color: inherit;">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3 shadow">
                <h2>{{__('Modules')}}</h2>
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <p><h5><b>{{__('Total')}} {{__('Modules')}}: {{ $modules }}</b></h5></p>
                    </div>
                    <div class="col-auto">
                        <img src="{{ asset('images/admin/module/black.png') }}" style="width: 100px" alt="Cycle">
                    </div>
                </div>
                <button class="btn btn-outline-secondary" type="button">{{__('View more')}}</button>
            </div>
        </a>
    </div>
</div>

@endsection

