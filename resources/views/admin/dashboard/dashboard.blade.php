@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>

.col-md-3.col-sm-6.col-xs-12.count-widget {
    cursor: pointer;
}
.mini-stat {
  padding: 15px;
  margin-bottom: 20px;
}

.mini-stat-icon {
  width: 60px;
  height: 60px;
  display: inline-block;
  line-height: 60px;
  text-align: center;
  font-size: 30px;
  background: none repeat scroll 0% 0% #EEE;
  border-radius: 100%;
  float: left;
  margin-right: 10px;
  color: #FFF;
}

.mini-stat-info {
  font-size: 12px;
  padding-top: 2px;
}

.count-widget span, p {
  color: white;
}

.mini-stat-info span {
  display: block;
  font-size: 30px;
  font-weight: 600;
  margin-bottom: 5px;
  margin-top: 7px;
}

/* ================ colors =====================*/
.bg-0 {
  background-color: #004f5b !important;
  border: 1px solid #004f5b;
  color: white;
}

.fg-0 {
  color: #004f5b !important;
}

.bg-1 {
  background-color: #3b5998 !important;
  border: 1px solid #3b5998;
  color: white;
}

.fg-1 {
  color: #3b5998 !important;
}


.bg-2 {
  background-color: #00a0d1 !important;
  border: 1px solid #00a0d1;
  color: white;
}

.fg-2 {
  color: #00a0d1 !important;
}


.bg-3 {
  background-color: #db4a39 !important;
  border: 1px solid #db4a39;
  color: white;
}

.fg-3 {
  color: #db4a39 !important;
}


.bg-4 {
  background-color: #40ff00 !important;
  border: 1px solid #40ff00;
  color: white;
}

.fg-4 {
  color: #40ff00 !important;
}

.bg-5 {
  background-color: #4e2182 !important;
  border: 1px solid #4e2182;
  color: white;
}

.fg-5 {
  color: #4e2182 !important;
}

.bg-6 {
  background-color: #218226 !important;
  border: 1px solid #218226;
  color: white;
}

.fg-6 {
  color: #218226 !important;
}

.bg-7 {
  background-color: #738221 !important;
  border: 1px solid #738221;
  color: white;
}

.fg-7 {
  color: #738221 !important;
}

.bg-8 {
  background-color: #217282 !important;
  border: 1px solid #217282;
  color: white;
}

.fg-8 {
  color: #217282 !important;
}

.bg-9 {
  background-color: #8b0086 !important;
  border: 1px solid #8b0086;
  color: white;
}

.fg-9 {
  color: #8b0086 !important;
}


.bg-10 {
  background-color: #bf2df4 !important;
  border: 1px solid #bf2df4;
  color: white;
}

.fg-10 {
  color: #bf2df4 !important;
}

.bg-11 {
  background-color: #3c221d !important;
  border: 1px solid #3c221d;
  color: white;
}

.fg-11 {
  color: #3c221d !important;
}

.bg-12 {
  background-color: #823121 !important;
  border: 1px solid #823121;
  color: white;
}

.fg-12 {
  color: #823121 !important;
}

.bg-13 {
  background-color: #c88c80 !important;
  border: 1px solid #c88c80;
  color: white;
}

.fg-13 {
  color: #607e51 !important;
}
.bg-14 {
  background-color: #a2f43e !important;
  border: 1px solid #a2f43e;
  color: white;
}

.fg-14 {
  color: #fca6ff !important;
}
</style>
@php
    // dd($status_counts);
@endphp
<div class="body-content">
  </div>
    <div class="bootstrap snippets bootdey">
      <div class="row" id="status-counts">
        
      </div>
    </div>
  </div>
@endsection

@section('footer-script')
@endsection