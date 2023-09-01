@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="body-content">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Email Template Detail</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Template Name</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $template->name }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark-gray" for="">Description</label>
                                <div>
                                    {!! $template->description !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script>
    // $(".img-zoom-m").ezPlus();
</script>
@endsection