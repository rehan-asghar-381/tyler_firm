@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Create Role</h6>
                </div>
                <div class="text-right">
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form  method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label text-dark-gray" for="">Name</label>
                        <input value="{{ old('name') }}" type="text" name="name" class="form-control font-12 form-control-lg require" required>
                    </div>
                </div>
                <div class="col-md-12">   
                    <div class="form-group">
                        @if(count($permissions) > 0)
                            @foreach($permissions as $module=>$permission)
                                <div class="roles_titles mt-4">{{ $module }} Permissions</div>
                                <div class='water-check-boxs'>
                                    <div class="row">
                                        @foreach($permission as $p)
                                        <div class="col-lg-3 col-md-3 col">
                                            <div class="form-check mb-3 hover-text">
                                                <input class="form-check-input  shadow-none" type="checkbox" name="permission[]" value="{{ $p->name }}" @if($p->name == "dashboard-view") {{ "checked" }} @endif id="flexCheckDefault">
                                                <span class="checkmark"></span>
                                                <label class="form-check-label" for="">
                                                    {{ $p->description }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection